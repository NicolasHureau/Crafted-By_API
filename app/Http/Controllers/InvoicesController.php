<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoicesRequest;
use App\Http\Requests\UpdateInvoicesRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

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
     * @OA\Get(
     *     path="/invoices",
     *     summary="Get a list of invoices",
     *     tags={"Invoices"},
     *     security={ {"sanctum": {} }},
     *     @OA\Response(
     *         response="200",
     *          description="Succesful operation",
     *          @OA\JsonContent(type="array",
     *                  @OA\Items(type="object", ref="#/components/schemas/InvoiceModel"))
     *     ),
     *      @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function index()
    {
        $this->authorize('viewAny');

        if (Auth::user()->hasRole('admin')) {
            return InvoiceResource::collection(Invoice::all());
        }

        return InvoiceResource::collection(Invoice::where('customer_id', Auth::user()->getAuthIdentifier()));
    }

    /**
     * Store a newly created resource in storage.
     * @OA\Post(
     *     path="/Invoices",
     *     summary="Invoice Store",
     *     operationId="addInvoice",
     *     description="Create Invoice",
     *     tags={"Invoices"},
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *          @OA\JsonContent(ref="#/components/schemas/InvoiceModel")
     *     ),
     *      @OA\Response(
     *          response="201",
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/InvoiceModel")
     *      ),
     *      @OA\Response(
     *          response=405,
     *          description="Invalid input"
     *      )
     * )
     */
    public function store(StoreInvoicesRequest $request)
    {
        $this->authorize('create', $request);

        $invoice = Invoice::create($request->all());

        $status = Status::where('number', 1)->first();
        $invoice->status()->attach($status->id);

        $invoice->product()->attach($request->product_id, ['quantity' => $request->product_quantity]);

        return new InvoiceResource($invoice);
    }

    /**
     * Display the specified resource.
     * @OA\Get(
     *          path="/invoices/{invoice_id}",
     *          summary="Find a invoice by Id",
     *          description="Return a single invoice",
     *          tags={"Invoices"},
     *          operationId="getInvoiceById",
     *          security={ {"sanctum": {} }},
     *          @OA\Parameter(
     *            name="invoice_id",
     *            in="path",
     *            description="Id of invoice to return",
     *            required=true
     *          ),
     *          @OA\Response(
     *            response=200,
     *            description="Successful operation",
     *            @OA\JsonContent(ref="#/components/schemas/InvoiceModel")
     *          ),
     *          @OA\Response(response=400, description="Invalid request")
     *      )
 */
    public function show(Invoice $invoice)
    {
        $this->authorize('view', $invoice);

        return new InvoiceResource($invoice);
    }

    /**
     * Update the specified resource in storage.
     * @OA\Put(
     *       path="/invoices/{invoice_id}",
     *       operationId="updateInvoice",
     *       tags={"Invoices"},
     *       summary="Update existing invoice",
     *       description="Returns updated invoice data",
     *       security={ {"sanctum": {} }},
     *       @OA\Parameter(
     *           name="invoice_id",
     *           description="Invoice id",
     *           required=true,
     *           in="path",
     *       ),
     *       @OA\RequestBody(
     *           required=true,
     *           @OA\JsonContent(ref="#/components/schemas/InvoiceModel")
     *       ),
     *       @OA\Response(
     *           response="202",
     *           description="Successful operation",
     *           @OA\JsonContent(ref="#/components/schemas/InvoiceModel")
     *       ),
     *        @OA\Response(response=400, description="Bad Request"),
     *        @OA\Response(response=401, description="Unauthenticated"),
     *        @OA\Response(response=403, description="Forbidden"),
     *        @OA\Response(response=404, description="Resource Not Found")
     *   )
 */
    public function update(UpdateInvoicesRequest $request, Invoice $invoices)
    {
        $this->authorize('update', Auth::user());

        $invoices->update($request->all());

        return (new InvoiceResource($invoices))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     * @OA\Delete(
     *         path="/invoices/{invoice_id}",
     *         operationId="deleteInvoice",
     *         tags={"Invoices"},
     *         summary="Delete existing invoice",
     *         description="Deletes a record and returns no content",
     *         security={ {"sanctum": {} }},
     *         @OA\Parameter(
     *             name="invoice_id",
     *             description="Invoice id",
     *             required=true,
     *             in="path",
     *             @OA\Schema(type="uuid")
     *         ),
     *         @OA\Response(
     *             response=204,
     *             description="Successful operation",
     *             @OA\JsonContent()
     *          ),
     *         @OA\Response(response=401, description="Unauthenticated"),
     *         @OA\Response(response=403, description="Forbidden"),
     *         @OA\Response(response=404, description="Resource Not Found")
     *    )
 */
    public function destroy(Invoice $invoices)
    {
        $this->authorize('delete', Auth::user());

        $invoices->delete();

        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
