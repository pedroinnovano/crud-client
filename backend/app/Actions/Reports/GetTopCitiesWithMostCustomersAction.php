<?php

namespace App\Actions\Reports;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class GetTopCitiesWithMostCustomersAction
{
    public function execute(int $limit = 5): array
    {
        return Customer::select('city', DB::raw('COUNT(*) as total'))
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
