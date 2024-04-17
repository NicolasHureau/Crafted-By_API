<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Color;
use App\Models\Material;
use App\Models\Product;
use App\Models\Size;
use App\Models\Style;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends Controller
{
    /**
     * Instantiate a new controller instance with middleware.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     * @OA\Get(
     *       path="/products",
     *       operationId="getProductList",
     *       summary="Get a list of products",
     *       tags={"Products"},
     *       description="Returns list of products",
     *       @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ProductCard")
     *       ),
     *       @OA\Response(response=400, description="Invalid request")
     *   )
     */
    public function index(Request $request): ResourceCollection
    {
        $products = Product::query();

        foreach (request()->query() as $key => $value)
        {
            if (!is_null($value))
            {
                $products = $products->$key($value);
            }
        };

        $products = $products->get();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     * @OA\Post(
     *     path="/products",
     *     summary="Products Store",
     *     tags={"Products"},
     *     operationId="addProduct",
     *     description="Create Product",
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProductModel")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ProductModel")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     * )
     */
    public function store(StoreProductsRequest $request)
    {
        $this->authorize('create', $request);
        $requestData = $request->all();

        $size = Size::firstOrCreate([
            'height' => $requestData['height'],
            'width' => $requestData['width'],
            'depth' => $requestData['depth'],
            'capacity' => $requestData['capacity'],
        ]);
        $requestData['size_id'] = $size->id;

        $category = Category::firstOrCreate(['category' => $requestData['category']]);
        $requestData['category_id'] = $category->id;

        $material = Material::firstOrCreate(['material' => $requestData['material']]);
        $requestData['material_id'] = $material->id;

        $style = Style::firstOrCreate(['style' => $requestData['style']]);
        $requestData['style_id'] = $style->id;

        $color = Color::firstOrCreate(['color' => $requestData['color']]);
        $requestData['color_id'] = $color->id;

        $requestData['active'] = true;

        $product = Product::create($requestData);
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     * @OA\Get(
     *         path="/products/{product_id}",
     *         summary="Find a product by Id",
     *         description="Return a single product",
     *         tags={"Products"},
     *         operationId="getProductById",
     *         @OA\Parameter(
     *           name="product_id",
     *           in="path",
     *           description="Id of product to return",
     *           required=true,
     *         ),
     *         @OA\Response(
     *           response=200,
     *           description="Successful operation",
     *           @OA\JsonContent(ref="#/components/schemas/ProductModel")
     *         ),
     *         @OA\Response(response=400, description="Invalid request")
     *     )
     */
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     * @OA\Put(
     *     path="/products/{id}",
     *     operationId="updateProduct",
     *     tags={"Products"},
     *     summary="Update existing product",
     *     description="Returns updated product data",
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         description="Product id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="uuid")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProductModel")
     *     ),
     *     @OA\Response(
     *         response="202",
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ProductModel")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found"
     *     )
     * )
     */
    public function update(UpdateProductsRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $product->update($request->all());
        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     * @OA\Delete(
     *       path="/products/{id}",
     *       operationId="deleteProduct",
     *       tags={"Products"},
     *       summary="Delete existing product",
     *       description="Deletes a record and returns no content",
     *       security={ {"sanctum": {} }},
     *       @OA\Parameter(
     *           name="id",
     *           description="Product id",
     *           required=true,
     *           in="path",
     *           @OA\Schema(
     *               type="uuid"
     *           )
     *       ),
     *       @OA\Response(
     *           response=204,
     *           description="Successful operation",
     *           @OA\JsonContent()
     *        ),
     *       @OA\Response(
     *           response=401,
     *           description="Unauthenticated",
     *       ),
     *       @OA\Response(
     *           response=403,
     *           description="Forbidden"
     *       ),
     *       @OA\Response(
     *           response=404,
     *           description="Resource Not Found"
     *       )
     *  )
     */
    public function destroy(Product $products)
    {
        $this->autorize('delete', $products);
        $products->delete();
        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
