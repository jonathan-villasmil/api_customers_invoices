<?php

namespace App\Http\Controllers\Api;

use App\Models\Invoice;
use App\Http\Requests\v1\StoreInvoiceRequest;
use App\Http\Requests\v1\UpdateInvoiceRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\InvoiceCollection;
use App\Http\Resources\Api\InvoiceResource;
use App\Filters\v1\InvoicesFilter;
use App\Http\Requests\v1\BulkStoreInvoiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;



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
        $queryItems = $filter->transform($request); // [['column', 'operator', 'value']]

        //verificamos
        if (count($queryItems) == 0) {
            return new InvoiceCollection(Invoice::paginate());
        } else {
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
        return new InvoiceResource(Invoice::create($request->all()));
    }

    public function bulkStore(BulkStoreInvoiceRequest $request)
    {

        $bulk = collect($request->all())->map(function ($arr, $key) {
            return Arr::except($arr, ['customerId', 'billedDate', 'paidDate']);
        });

        Invoice::insert($bulk->toArray());
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
        $invoice->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        // Verificar si el cliente existe
        if (!$invoice) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        // Eliminar el cliente de la base de datos
        $invoice->delete();

        return response()->json(['message' => 'Cliente eliminado exitosamente']);

        // $invoice->delete();

        // return redirect()->route('invoices')
        //     ->with('success', 'Invoice deleted successfully');
    }
}
