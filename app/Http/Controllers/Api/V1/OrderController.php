<?php

namespace App\Http\Controllers\Api\V1;

use App\Filter\V1\OrderFilter;
use App\Models\Order;
use App\Http\Requests\V1\StoreOrderRequest;
use App\Http\Requests\V1\UpdateOrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreOrderRequest;
use App\Http\Resources\V1\OrderResource;
use App\Http\Resources\V1\OrderCollection;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new OrderFilter();
        $filterItems = $filter->transform($request);

        $includeOrderDetails = $request->query('includeOrderDetails');

        $orders = Order::where($filterItems);
        if($includeOrderDetails) {
            $orders->with('orderDetails');
        }
        return new OrderCollection($orders
            ->paginate()
            ->appends($request->query()));
    }
    public function bulkStore(BulkStoreOrderRequest $request)
    {
        $createdOrders = [];
        foreach ($request->validated() as $item) {
            $createdOrders[] = Order::create($item);
        }

        return response()->json([
            'message' => 'Orders created',
            'orders' => $createdOrders
        ], 201);
    }
    /**
     * Store a newly created resource in storage.     
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        return new OrderResource(Order::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $includeOrderDetails = request()->query('includeOrderDetails');
        if($includeOrderDetails) {
            $order->loadMissing('orderDetails');
        }

        return new OrderResource($order->load('orderDetails'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {


        $order->update($request->validated());
        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
