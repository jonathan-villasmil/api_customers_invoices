<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\Api\CustomerCollection;
use App\Http\Resources\Api\CustomerResource;
use Illuminate\Http\Request;
use App\Services\CustomerQuery;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //creamos un nuevo objeto
        $filter = new CustomerQuery();

        //elementos que se construirá a partir de la clase
        $queryItems = $filter->transform($request);// [['column', 'operator', 'value']]

        //verificamos
        if(count($queryItems) == 0){
            return new CustomerCollection(Customer::paginate(100));
        }else{
            return new CustomerCollection(Customer::where($queryItems)->paginate(100));
        }

        

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
