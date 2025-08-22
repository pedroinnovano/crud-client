<?php

namespace App\Actions\Reports;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class GetCustomerCountByCityAction
{
    public function execute(): array
    {
        return Customer::select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderByDesc('total')
            ->get()
            ->toArray();
    }
}
