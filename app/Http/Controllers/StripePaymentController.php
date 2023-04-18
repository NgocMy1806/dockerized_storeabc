<?php

namespace App\Http\Controllers;

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

class StripePaymentController extends Controller
{
  public function checkout(Request $request)
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
    Session::put('checkout.email', $request->input('email'));

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

  public function checkoutOK(Request $request)
  {

    // dd($request->all());
    // Retrieve email from session
    $email = Session::get('checkout.email');

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
// dd($cart);
    try {

      DB::beginTransaction();
      $customer = new Customer;
      $customer->name = 'test';
      $customer->email = $email;
      $customer->country_id = '1';
      $customer->state_id = '1';
      $customer->city_id = '1';
      $customer->address_bottom = '1';
      

      $customer->save();
      // Create a new order in the database
      $order = new Order();
      $order->customer_id = $customer->id;
      $order->total_amount = $stripePaymentIntent->amount / 100;
      $order->order_status = 0;
      $order->payment_status = 1;
      $order->transaction_id = $stripePaymentIntentId;
      $order->is_pickup = 0;
      $order->payment_method = 1;
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

      // Redirect to the order confirmation page
      DB::commit();
      return view('user.checkoutOK')->with('order', $order);
    } catch (Throwable $e) {
      DB::rollBack();
      dd($e);
    }
  }
}
