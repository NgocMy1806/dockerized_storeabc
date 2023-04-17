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
      'success_url' => route('checkoutOK'),
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
           'images' => [ asset('storage/thumbnail/' .  $item['thumbnail'])]
          ],
        ],
        'quantity' => $item['quantity'],
      ];
    }

    return $line_items;
  }

  public function checkoutOK(Request $request)
  {

    dd($request->all());
// Retrieve email from session
$email = Session::get('checkout.email');
dump($email);
// Get the Stripe session ID from the URL parameters
$stripeSessionId = $request->query('session_id');
dd($stripeSessionId);
// Retrieve the Stripe session from the API
Stripe::setApiKey(config('services.stripe.secret'));

$stripeSession = StripeSession::retrieve($stripeSessionId);
dump($stripeSession);
// Get the payment intent from the Stripe session
$stripePaymentIntentId = $stripeSession->payment_intent;
dump($stripePaymentIntentId);
$stripePaymentIntent = PaymentIntent::retrieve($stripePaymentIntentId);
dump($stripePaymentIntent);

// Retrieve cart from session
$cart = Session::get('cart');

$customer= new Customer;
$customer->email = $email;

// Create a new order in the database
$order = new Order();
$order->customer_id = $customer->id;
$order->total_amount = $stripePaymentIntent->amount / 100;
$order->order_status = 0;
$order->payment_status = 1;
$order->transaction_id = $stripePaymentIntentId ;
$order->is_pickup =0;
$order->payment_method = 1;
$order->save();

// Create order items for each product in the cart
foreach ($cart as $item) {
    $orderItem = new OrderDetail();
    $orderItem->order_id = $order->id;
    $orderItem->product_id = $item['product_id'];
    $orderItem->quantity = $item['quantity'];
    $orderItem->price = $item['price'];
    $orderItem->save();
}

// Clear the cart in the session
Session::forget('cart');

// Redirect to the order confirmation page
return view('user.checkoutOK')->with('order', $order);
}
   
}
