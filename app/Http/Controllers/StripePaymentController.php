<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;


class StripePaymentController extends Controller
{
    public function createCheckoutSession($STRIPE_SECRET_KEY){
        \Stripe\Stripe::setApiKey($STRIPE_SECRET_KEY);
        
        // Set the content type header before any content is sent to the output
        header('Content-Type: application/json');


$YOUR_DOMAIN = 'http://localhost:4242';

$checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => [[
    # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
    'price' => '{{PRICE_ID}}',
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/success.html',
  'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
    }
}
