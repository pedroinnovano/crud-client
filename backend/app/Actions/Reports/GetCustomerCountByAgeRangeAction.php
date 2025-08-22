<?php

namespace App\Actions\Reports;

use App\Models\Customer;

class GetCustomerCountByAgeRangeAction
{
    public function execute(): array
    {
        $ranges = [
            '0-18' => [0, 18],
            '19-25' => [19, 25],
            '26-35' => [26, 35],
            '36-50' => [36, 50],
            '51+' => [51, 150],
        ];

        $result = [];

        foreach ($ranges as $label => [$min, $max]) {
            $count = Customer::whereBetween('age', [$min, $max])->count();
            $result[] = [
                'range' => $label,
                'total' => $count,
            ];
        }

        return $result;
    }
}
