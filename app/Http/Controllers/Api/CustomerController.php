<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Http\Requests\v1\StoreCustomerRequest;
use App\Http\Requests\v1\UpdateCustomerRequest;
use App\Http\Resources\Api\CustomerCollection;
use App\Http\Resources\Api\CustomerResource;
use Illuminate\Http\Request;
use App\Filters\v1\CustomersFilter;



class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //creamos un nuevo objeto
        $filter = new CustomersFilter();

        //elementos que se construirá a partir de la clase
        $filterItems = $filter->transform($request);// [['column', 'operator', 'value']]

        //incluir la relacion entre customers e invoices
        $includeInvoices = $request->query('includeInvoices');

        $customers = Customer::where($filterItems);
        
        if($includeInvoices){
            $customers = $customers->with('invoices');
        }
        
        return new CustomerCollection($customers->paginate()->appends($request->query()));

        
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
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //incluir la relacion entre customers e invoices
        $includeInvoices = request()->query('includeInvoices');

        //validamos que exista
        if($includeInvoices){
            return new CustomerResource($customer->loadMissing('invoices'));
        }

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
