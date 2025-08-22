<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ReportController;


Route::apiResource('customers', CustomerController::class);

Route::prefix('reports')->controller(ReportController::class)->group(function () {
    Route::get('customers-per-month', 'customersPerMonth');
    Route::get('customer-count-by-city', 'customerCountByCity');
    Route::get('customer-count-by-state', 'customerCountByState');
    Route::get('customer-percentage-by-state', 'customerPercentageByState');
    Route::get('customer-count-by-age-range', 'customerCountByAgeRange');
    Route::get('top-cities-with-most-customers', 'topCitiesWithMostCustomers');
});
