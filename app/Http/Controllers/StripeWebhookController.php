<?php

namespace App\Http\Controllers;

use App\Jobs\ConvertCartToOrder;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe;
use Stripe\StripeClient;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function create(Request $request, StripeClient $stripe)
    {
        $secret = 'whsec_9a3e8f68e7d6e61e64b5eff35f1798776914da3d0a6a2326364b4a1b78137f1e';

        try {
            $event = Stripe\Webhook::constructEvent($request->getContent(), $request->header('Stripe-Signature'), $secret);
        } catch (UnexpectedValueException $e) {
            Log::error($e);
            return response('Unexpected value, bad payload', 400);
        } catch (Stripe\Exception\SignatureVerificationException $e) {
            Log::error($e);
            return response('Signature could not be verified', 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $stripe->checkout->sessions->retrieve($event->data->object->id);

                // create a job where cart items are moved to an order
                ConvertCartToOrder::dispatch($session);
        }

        return response('', 200);
    }
}
