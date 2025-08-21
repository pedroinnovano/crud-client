<?php
namespace App\Jobs;

use App\Events\CustomerCreated;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendCustomerWebhook implements ShouldQueue
{
    public function handle(CustomerCreated $event): void
    {
        $customer = $event->customer;

        Http::post(config('services.webhook.url'), [
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
