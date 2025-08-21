<?php

namespace App\Listeners;

use App\Events\CustomerCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendCustomerWebhook
{
    public function handle(CustomerCreated $event): void
    {

        $customer = $event->customer;

        $url = config('services.webhooks.url');

        Log::info('Webhook URL:', [$url]);

        Http::post($url, [
            'name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'city' => $customer->city,
            'state' => $customer->state,
            'photo' => $customer->photo,
            'age' => $customer->age,
        ]);
    }
}
