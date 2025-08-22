<?php

namespace App\Actions\Reports;
use App\Models\Customer;
use Carbon\Carbon;

class GetCustomersPerMonth
{
    public function execute(): array
    {
        return Customer::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as total')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => Carbon::createFromDate($item->year, $item->month)->format('M/Y'),
                    'total' => $item->total,
                ];
            })
            ->toArray();
    }
}
