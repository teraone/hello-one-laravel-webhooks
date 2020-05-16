<?php

namespace HelloOne\Laravel\Webhooks;


use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller {


    /**
     * @param WebhookRequest $request
     *
     * @return JsonResponse
     */
    public function webhook( WebhookRequest $request ) {
        try {
            $this->validateRequestSignature( $request );
        } catch ( WebhookException $exception ) {
            $this->logError( $exception->getMessage(), $request );

            return new JsonResponse( [ 'error' => $exception->getMessage() ], 400 );
        }
        $this->logRequest( 'Request successful', $request );


        Event::dispatch('hello-one.webhook.' . $request->json( 'event' ),
            $request->json( 'data' ),
            false);

        return new JsonResponse( [ 'message' => 'success' ], 200 );
    }

    /**
     * @param WebhookRequest $request
     *
     * @throws WebhookException
     */
    private function validateRequestSignature( WebhookRequest $request ) {

        if ( ! $request->secure() ) {
            throw new WebhookException( 'Request was not detected to be secure' );
        }

        if ( ! $request->hasHeader( $request::SIGNATURE_HEADER_NAME ) ) {
            throw new WebhookException( 'Missing request header: ' . $request::SIGNATURE_HEADER_NAME );
        }

        if ( ! $request->hasHeader( $request::SIGNATURE_SALT_HEADER_NAME ) ) {
            throw new WebhookException( 'Missing request header: ' . $request::SIGNATURE_SALT_HEADER_NAME );
        }


        $payload   = $request->header( $request::SIGNATURE_SALT_HEADER_NAME ) . '.' .  $request->getContent();
        $signature = hash_hmac( 'sha256', $payload, config( 'hello-one-webhooks.signing_secret' ) );


        if ($signature !== $request->header($request::SIGNATURE_HEADER_NAME)) {
            throw new WebhookException( 'The signature is invalid' );
        }


    }

    private function logError( string $message, WebhookRequest $request ) {
        if ( config( 'hello-one-webhooks.log_errors' ) ) {
            Log::channel( config( 'hello-one-webhooks.log_channel' ) )
               ->error( 'hello one Webhook: ' . $message );
        }
    }

    private function logRequest( string $message, WebhookRequest $request ) {
        if ( config( 'hello-one-webhooks.log_requests' ) ) {
            Log::channel( config( 'hello-one-webhooks.log_channel' ) )
               ->debug( 'hello one Webhook: ' . $message, $request->toArray() );
        }
    }

}
