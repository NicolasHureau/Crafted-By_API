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

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        return response()->json(Product::all());
        return ProductResource::collection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductsRequest $request)
    {
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
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductsRequest $request, Product $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $products)
    {
        //
    }
}
