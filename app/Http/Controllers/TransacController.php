<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Http\Resources\PackageResource;
use App\Models\Feature;
use App\Models\Transaction;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\SignatureVerificationException;
use Stripe\StripeClient;
use Stripe\Webhook;
use UnexpectedValueException;

class TransacController extends Controller
{

	public function index()
	{
		$packages = Package::all();
		$features = Feature::where('active', true)->get();
		return inertia('Credit/Index', [
			'features' => FeatureResource::collection($features),
			'packages' => PackageResource::collection($packages),
			'success' => session('success'),
			'error' => session('error'),
		]);
	}

    /**
     * @throws ApiErrorException
     */
    public function buyCredits(Package $package)
	{
        $stripe = new StripeClient(env( 'STRIPE_SECRET' ));

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                'price_data' => [
                    'currency' => 'cad',
                    'product_data' => [
                        'name' => $package->name . ' - ' . $package->credits . ' credits ',
                    ],
                    'unit_amount' => $package->price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('credits.success', [], true),
            'cancel_url' => route('credits.cancel', [], true),
        ]);

        Transaction::create([
            'status'=>'pending',
            'package_id'=>$package->id,
            'price'=>$package->price,
            'credits'=>$package->credits,
            'session_id'=>$checkout_session->id,
            'user_id'=>Auth::id(),
        ]);
        return redirect($checkout_session->url);
	}

	public function success()
	{
        return to_route( 'credits.index' )->with('success', 'Vous avez reussi votre achat de credits');
	}

	public function cancel()
	{
        return to_route('credits.index')->with('error', 'Votre achat a echouer, veuillez reessayer');

    }
	public function webhook()
	{
        $endpoint_secret = env('SECRET_WEBHOOK_KEY');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $sig_header,
                $payload,
                $endpoint_secret,
            );
        } catch (UnexpectedValueException $e) {
            // Invalid payload
          return response('',400);

        } catch (SignatureVerificationException $e) {
           return response('',400);
        }
        // Handle the event
        switch ($event->type) {

            case 'checkout.session.completed':
                $session = $event->data->object;
                $transaction = Transaction::where('session_id', $session->id)->first();
                if ($transaction && $transaction->status == 'pending'){
                    $transaction->status = 'paid';
                    $transaction->save();
                    $transaction->user->availaible_credits += $transaction->credits;
                    $transaction->user->save();
                }
            default:
                // Unexpected event type
                error_log('Received unknown event type');

        }
          return response("");
    }


}
