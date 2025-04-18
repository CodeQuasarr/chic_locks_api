<?php

namespace App\Http\Controllers\Api\V1\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentStripeController extends Controller
{

    public function createPaymentIntent(Request $request): JsonResponse
    {
        $user = $request->user();
        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $request->amount * 100,
            'currency' => 'eur',
            'metadata' => [
                'user_id' => $user->id,
                'email' => $user->email,
            ],
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }
}
