<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoicesRequest;
use App\Http\Requests\UpdateInvoicesRequest;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): jsonResponse
    {
        $invoices = Invoice::all();
        $invoicesList = [];
        foreach ($invoices as $invoice) {
            $invoicesList[] = [
                'id' => $invoice->id,
                'status' => $invoice->status->last(),
                'customer' => $invoice->customer,
                'products' => $invoice->product,
            ];
        }
        return response()->json($invoicesList);
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
    public function store(StoreInvoicesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoicesRequest $request, Invoice $invoices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoices)
    {
        //
    }
}
