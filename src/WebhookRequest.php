<?php

namespace HelloOne\Laravel\Webhooks;


use Illuminate\Foundation\Http\FormRequest;

class WebhookRequest extends FormRequest {

    const SIGNATURE_HEADER_NAME = 'x-hello-one-signature';
    const SIGNATURE_SALT_HEADER_NAME = 'x-hello-one-signature-salt';

    /**
     * @return array
     */
    public function rules(): array {
        return [
            'event' => [ 'required', 'string' ],
            'data'  => [ 'required', 'array' ],
            'created_at'  => [ 'required', 'date' ]
        ];
    }
}
