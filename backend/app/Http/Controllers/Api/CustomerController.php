<?php

namespace App\Http\Controllers\Api;

use App\Events\CustomerCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Jobs\SendCustomerWebhook;
use App\Models\Customer;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="CRUD Client API",
 *      description="Documentação da API de clientes via Swagger",
 *      @OA\Contact(
 *          email="phmsanttos@gmail.com"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Servidor Local"
 * )
 */

class CustomerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/customers",
     *     summary="Listar clientes",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filtrar por nome do cliente",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clientes"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Customer::query();
        
        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        $customers = $query->latest()->paginate(10);
        return new CustomerCollection($customers);
    }

    /**
     * @OA\Post(
     *     path="/api/customers",
     *     summary="Criar cliente",
     *     tags={"Clientes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Fulano da Silva"),
     *             @OA\Property(property="email", type="string", example="fulano@email.com"),
     *             @OA\Property(property="phone", type="string", example="(81) 99999-9999"),
     *             @OA\Property(property="city", type="string", example="Recife"),
     *             @OA\Property(property="state", type="string", example="PE"),
     *             @OA\Property(property="photo", type="string", example="https://example.com/foto.jpg"),
     *             @OA\Property(property="age", type="integer", example=30)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cliente criado com sucesso"
     *     )
     * )
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());
        event(new CustomerCreated($customer));
//        SendCustomerWebhook::dispatchSync($customer);
        return new CustomerResource($customer);
    }
    /**
     * @OA\Get(
     *     path="/api/customers/{id}",
     *     summary="Mostrar cliente específico",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do cliente",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente encontrado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente não encontrado"
     *     )
     * )
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * @OA\Put(
     *     path="/api/customers/{id}",
     *     summary="Atualizar cliente",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do cliente",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Novo Nome"),
     *             @OA\Property(property="email", type="string", example="novo@email.com"),
     *             @OA\Property(property="phone", type="string", example="(81) 98888-8888"),
     *             @OA\Property(property="city", type="string", example="Olinda"),
     *             @OA\Property(property="state", type="string", example="PE"),
     *             @OA\Property(property="photo", type="string", example="https://example.com/photo.jpg"),
     *             @OA\Property(property="age", type="integer", example=25)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente atualizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente não encontrado"
     *     )
     * )
     */

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return new CustomerResource($customer);
    }

    /**
     * @OA\Delete(
     *     path="/api/customers/{id}",
     *     summary="Deletar cliente",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do cliente",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Cliente deletado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente não encontrado"
     *     )
     * )
     */

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->noContent();
    }
}
