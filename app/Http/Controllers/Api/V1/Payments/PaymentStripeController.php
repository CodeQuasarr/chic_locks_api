<?php

namespace App\Http\Controllers\Api\V1\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentStripeController extends Controller
{

    public function createPaymentIntent(Request $request): \Illuminate\Http\JsonResponse
    {
        Stripe::setApiKey(config('services.stripe.secret'));

//        $paymentIntent = PaymentIntent::create([
//            'amount' => $request->amount * 100, // Montant en cents
//            'currency' => 'eur', // ou 'usd' selon votre devise
//        ]);

        $paymentIntent = PaymentIntent::create([
            'amount' => $request->amount * 100,
            'currency' => 'eur',
            'metadata' => [
                'user_id' => 10,
                'email' => 'samsoniteu@gmail.com',
            ],
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }
}
