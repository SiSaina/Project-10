<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Filter\V1\ProductFilter;
use App\Models\Product;
use App\Http\Requests\V1\StoreProductRequest;
use App\Http\Requests\V1\UpdateProductRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductResource;
use App\Http\Resources\V1\ProductCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ProductFilter();
        $filterItems = $filter->transform($request);

        $includeImages = $request->query('includeImages');
        $includeOrders = $request->query('includeOrders');
        $includeCategory = $request->query('includeCategory');

        $products = Product::where($filterItems);
        if($includeImages) {
            $products->with('images');
        }
        if($includeOrders) {
            $products->with('orders');
        }
        if($includeCategory) {
            $products->with('category');
        }
        return new ProductCollection($products
            ->orderBy('id', 'asc')
            ->paginate()
            ->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        return new ProductResource(Product::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $includeImages = request()->query('includeImages');
        $includeOrders = request()->query('includeOrders');
        $includeCategory = request()->query('includeCategory');
        if($includeImages) {
            $product->loadMissing('images');
        }
        if($includeOrders) {
            $product->loadMissing('orders');
        }
        if($includeCategory) {
            $product->loadMissing('category');
        }
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete product.', 'error' => $e->getMessage()], 500);
        }
    }

}
