<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoicesRequest;
use App\Http\Requests\UpdateInvoicesRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return InvoiceResource::collection(Invoice::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoicesRequest $request)
    {
        $invoice = Invoice::create($request->all());

        $status = Status::where('number', 1)->first();
        $invoice->status()->attach($status->id);

        $invoice->product()->attach($request->product_id, ['quantity' => $request->product_quantity]);

        return new InvoiceResource($invoice);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
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
