<?php

namespace App\Http\Controllers\Api;

use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\InvoiceCollection;
use App\Http\Resources\Api\InvoiceResource;
use App\Filters\v1\InvoicesFilter;
use Illuminate\Http\Request;




class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //creamos un nuevo objeto
        $filter = new InvoicesFilter();

        //elementos que se construirá a partir de la clase
        $queryItems = $filter->transform($request);// [['column', 'operator', 'value']]

        //verificamos
        if(count($queryItems) == 0){
            return new InvoiceCollection(Invoice::paginate());
        }else{
            $invoices = Invoice::where($queryItems)->paginate();
            return new InvoiceCollection($invoices->appends($request->query()));
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
    public function store(StoreInvoiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
