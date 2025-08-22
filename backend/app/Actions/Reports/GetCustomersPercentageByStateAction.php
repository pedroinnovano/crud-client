<?php

namespace App\Actions\Reports;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class GetCustomersPercentageByStateAction
{
    public function execute(): array
    {
        $total = Customer::count();

        if ($total === 0) {
            return [];
        }

        return Customer::select('state', DB::raw('COUNT(*) as total'))
            ->groupBy('state')
            ->get()
            ->map(function ($row) use ($total) {
                return [
                    'state' => $row->state,
                    'total' => $row->total,
                    'percentage' => round(($row->total / $total) * 100, 2),
                ];
            })
            ->toArray();
    }
}
