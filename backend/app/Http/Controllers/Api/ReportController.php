<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Actions\Reports\GetCustomerCountByAgeRangeAction;
use App\Actions\Reports\GetCustomerCountByCityAction;
use App\Actions\Reports\GetCustomerCountByStateAction;
use App\Actions\Reports\GetCustomersPercentageByStateAction;
use App\Actions\Reports\GetCustomersPerMonthAction;
use App\Actions\Reports\GetTopCitiesWithMostCustomersAction;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/reports/customers-per-month",
     *     summary="Clientes cadastrados por mês (últimos 12 meses)",
     *     tags={"Relatórios"},
     *     @OA\Response(response=200, description="Dados dos clientes por mês")
     * )
     */
    public function customersPerMonth(GetCustomersPerMonthAction $action): JsonResponse
    {
        return response()->json($action->execute());
    }

    /**
     * @OA\Get(
     *     path="/api/reports/customer-count-by-city",
     *     summary="Clientes por cidade",
     *     tags={"Relatórios"},
     *     @OA\Response(response=200, description="Quantidade de clientes por cidade")
     * )
     */
    public function customerCountByCity(GetCustomerCountByCityAction $action): JsonResponse
    {
        return response()->json($action->execute());
    }

    /**
     * @OA\Get(
     *     path="/api/reports/customer-count-by-state",
     *     summary="Clientes por estado",
     *     tags={"Relatórios"},
     *     @OA\Response(response=200, description="Quantidade de clientes por estado")
     * )
     */
    public function customerCountByState(GetCustomerCountByStateAction $action): JsonResponse
    {
        return response()->json($action->execute());
    }

    /**
     * @OA\Get(
     *     path="/api/reports/customer-percentage-by-state",
     *     summary="Distribuição percentual por estado",
     *     tags={"Relatórios"},
     *     @OA\Response(response=200, description="Percentual de clientes por estado")
     * )
     */
    public function customerPercentageByState(GetCustomersPercentageByStateAction $action): JsonResponse
    {
        return response()->json($action->execute());
    }

    /**
     * @OA\Get(
     *     path="/api/reports/customer-count-by-age-range",
     *     summary="Clientes por faixa etária",
     *     tags={"Relatórios"},
     *     @OA\Response(response=200, description="Quantidade de clientes por faixa etária")
     * )
     */
    public function customerCountByAgeRange(GetCustomerCountByAgeRangeAction $action): JsonResponse
    {
        return response()->json($action->execute());
    }

    /**
     * @OA\Get(
     *     path="/api/reports/top-cities-with-most-customers",
     *     summary="Top 5 cidades com mais clientes",
     *     tags={"Relatórios"},
     *     @OA\Response(response=200, description="Top cidades com mais clientes")
     * )
     */
    public function topCitiesWithMostCustomers(GetTopCitiesWithMostCustomersAction $action): JsonResponse
    {
        return response()->json($action->execute());
    }
}
