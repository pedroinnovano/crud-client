<?php

namespace App\Actions\Reports;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class GetCustomerCountByStateAction
{
    public function execute(): array
    {
        return Customer::select('state', DB::raw('count(*) as total'))
            ->groupBy('state')
            ->orderByDesc('total')
            ->get()
            ->toArray();
    }
}
