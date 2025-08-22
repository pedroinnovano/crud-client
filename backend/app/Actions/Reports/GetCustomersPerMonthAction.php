<?php

namespace App\Actions\Reports;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class GetCustomersPerMonthAction
{
    public function execute(): array
    {
        return Customer::select(
            DB::raw('COUNT(*) as total'),
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')
        )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get()
            ->reverse()
            ->values()
            ->toArray();
    }
}
