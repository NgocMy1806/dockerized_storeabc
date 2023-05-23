<?php

namespace App\Http\Controllers;

use App\Mail\OrderSuccessMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\ApiErrorException;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderDetail;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Mail;
use App\Services\EcService;


class StripePaymentController extends Controller
{
  public $ecService;
  public $watchCategories;
  public $bagCategories;

  public function __construct(EcService $ecService)
  {

    $this->ecService = $ecService;
    $this->watchCategories = $this->ecService->getWatchCategories();
    $this->bagCategories = $this->ecService->getBagCategories();
  }

  public function checkout(Request $request)
  {
    $paymentMethod = $request->input('payment_method');
    // dd($paymentMethod);
    if ($paymentMethod == 'stripe') {
      return $this->checkoutStripe($request);
      // } else if ($paymentMethod == 'bank_transfer') {
      //   return $this->checkoutBankTransfer($request);
    } else {
      return $this->checkoutBankTransfer($request);
    }
  }
  public function checkoutStripe(Request $request)
  {
    // Retrieve cart from session
    $cart = Session::get('cart');

    // Create a Stripe checkout session
    Stripe::setApiKey(config('services.stripe.secret'));

    $checkout_session = StripeSession::create([
      'payment_method_types' => ['card'],
      'line_items' => $this->getLineItems($cart),
      'mode' => 'payment',
      'success_url' => route('checkoutOK') . '?session_id={CHECKOUT_SESSION_ID}',
      'cancel_url' => route('getCheckout'),
    ]);

    // Store email in session for later use
    $checkout_details = [
      'name' => $request->input('name'),
      'email' => $request->input('email'),
      'country_id' => $request->input('country'),
      'state_id' => $request->input('state'),
      'city_id' => $request->input('city'),
      'address_bottom' => $request->input('address_bottom'),
    ];

    Session::put('checkout.details', $checkout_details);
    // Redirect to the Stripe checkout page
    return redirect()->to($checkout_session->url);
  }
  protected function getLineItems($cart)
  {
    $line_items = [];

    foreach ($cart as $item) {
      // dd($item['thumbnail']);
      $line_items[] = [
        'price_data' => [
          'currency' => 'usd',
          'unit_amount' => $item['price'] * 100, // Stripe requires the price in cents
          'product_data' => [
            'name' => $item['name'],
            'images' => [asset('storage/thumbnail/' .  $item['thumbnail'])]
          ],
        ],
        'quantity' => $item['quantity'],
      ];
    }

    return $line_items;
  }

  //checkout ok in case of using stripe
  public function checkoutOK(Request $request)
  {

    // Retrieve email from session
    // $email = Session::get('checkout.email');

    // Get the Stripe session ID from the URL parameters
    $stripeSessionId = $request->query('session_id');

    // Retrieve the Stripe session from the API
    Stripe::setApiKey(config('services.stripe.secret'));

    $stripeSession = StripeSession::retrieve($stripeSessionId);
    // dd($stripeSession);
    // Get the payment intent from the Stripe session
    $stripePaymentIntentId = $stripeSession->payment_intent;

    $stripePaymentIntent = PaymentIntent::retrieve($stripePaymentIntentId);
    // dd($stripePaymentIntent);

    // Retrieve cart from session
    $cart = Session::get('cart');

    // Retrieve checkout details from session
    $checkout_details = Session::get('checkout.details');
    // dd($cart);
    try {

      DB::beginTransaction();
      $customer = customer::where('email', $checkout_details['email'])->first();
      if (!$customer) {
        $customer = new customer;
        $customer->name = $checkout_details['name'];
        $customer->email = $checkout_details['email'];
        $customer->country_id = $checkout_details['country_id'];
        $customer->state_id = $checkout_details['state_id'];
        $customer->city_id = $checkout_details['city_id'];
        $customer->address_bottom = $checkout_details['address_bottom'];
        $customer->save();
      }
      // Create a new order in the database
      $order = new Order();
      $order->customer_id = $customer->id;
      $order->total_amount = $stripePaymentIntent->amount / 100;
      $order->order_status = 'pending';
      $order->payment_status = 'paid';
      $order->transaction_id = $stripePaymentIntentId;
      $order->is_pickup = 'no';
      $order->payment_method = 'stripe';
      $order->country_id = $checkout_details['country_id'];
      $order->state_id = $checkout_details['state_id'];
      $order->city_id = $checkout_details['city_id'];
      $order->address_bottom = $checkout_details['address_bottom'];
      $order->save();

      // Create order items for each product in the cart
      foreach ($cart as $item) {
        $orderItem = new OrderDetail();
        $orderItem->order_id = $order->id;
        $orderItem->product_id = $item['id'];
        $orderItem->quantity = $item['quantity'];
        $orderItem->price = $item['price'];
        $orderItem->save();
      }

      // Clear the cart in the session
      Session::forget('cart');
      Session::forget('total');
      Session::forget('totalQuantity');

      // Send the order confirmation email
      Mail::to($customer->email)->send(new OrderSuccessMail($customer, $order));

      // Redirect to the order confirmation page
      DB::commit();
      return view(
        'user.checkoutOK',
        [
          'payment_method' => 'stripe',
          'watchCategories' => $this->watchCategories,
          'bagCategories' => $this->bagCategories,

        ]
      );
    } catch (Throwable $e) {
      DB::rollBack();
      dd($e);
    }
  }

  public function checkoutBankTransfer(Request $request)
  {
    $paymentMethod = $request->input('payment_method');
    // dd($paymentMethod);
    try {
      
      $cart = session()->get('cart', []);
      // dd ($cart);
      $total = Session::get('total');
      // dd (Session::get('total'));
      DB::beginTransaction();
      $customer = customer::where('email',  $request->input('email'))->first();
      if (!$customer) {
        $customer = new Customer;
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->country_id = $request->input('country');
        $customer->state_id = $request->input('state');
        $customer->city_id = $request->input('city');
        $customer->address_bottom = $request->input('address_bottom');
        $customer->save();
      }

      $order = new Order();
      $order->customer_id = $customer->id;
      $order->total_amount = $total;
      $order->order_status = 'pending';
      $order->payment_status = 'unpaid';
      $order->transaction_id = "";
      $order->is_pickup = 'no';
      $paymentMethod == 'bank' ? $order->payment_method = 'bank' : $order->payment_method = 'COD';
      $order->country_id =  $request->input('country');
      $order->state_id = $request->input('state');
      $order->city_id = $request->input('city');
      $order->address_bottom = $request->input('address_bottom');
      $order->save();

      foreach ($cart as $item) {
        $orderItem = new OrderDetail();
        $orderItem->order_id = $order->id;
        $orderItem->product_id = $item['id'];
        $orderItem->quantity = $item['quantity'];
        $orderItem->price = $item['price'];
        $orderItem->save();
      }

      DB::commit();

      // Clear the cart in the session
      Session::forget('cart');
      Session::forget('total');
      Session::forget('totalQuantity');

      // Send the order confirmation email
      Mail::to($customer->email)->send(new OrderSuccessMail($customer, $order));

      //session()->put('payment_method', 'bank');
      if ($paymentMethod == 'bank') {
        return view(
          'user.checkoutOK',
          [
            'payment_method' => 'bank',
            'watchCategories' => $this->watchCategories,
            'bagCategories' => $this->bagCategories,
          ]
        );
      } else {
        return view(
          'user.checkoutOK',
          [
            'payment_method' => 'COD',
            'watchCategories' => $this->watchCategories,
            'bagCategories' => $this->bagCategories,
          ]
        );
      }
    } catch (Throwable $e) {
      DB::rollBack();
      dd($e);
    };
  }
}
