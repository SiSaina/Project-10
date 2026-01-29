<?php

namespace App\Http\Controllers\Api\V1;

use App\Filter\V1\OrderDetailFilter;
use App\Models\OrderDetail;
use App\Http\Requests\V1\StoreOrderDetailRequest;
use App\Http\Requests\V1\UpdateOrderDetailRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\OrderDetailCollection;
use App\Http\Resources\V1\OrderDetailResource;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {        
        $filter = new OrderDetailFilter();
        $filterItems = $filter->transform($request);

        if(count($filterItems) === 0) {
            return new OrderDetailCollection(OrderDetail::paginate());
        }
        else {
            return new OrderDetailCollection(OrderDetail::where($filterItems)->paginate());
        }
    }

    /**
     * Store a newly created resource in storage.     
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderDetailRequest $request)
    {
        return new OrderDetailResource(OrderDetail::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderDetail $orderDetail)
    {
        return new OrderDetailResource($orderDetail);
    }

    public function showUserProduct($userId)
    {
        $include = ['order.product.images', 'user', 'address'];
        $UserOrderDetail = OrderDetail::with($include)->where('user_id', $userId)->get();
        return OrderDetailResource::collection($UserOrderDetail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderDetailRequest $request, OrderDetail $orderDetail)
    {
        $orderDetail->update($request->validated());
        return new OrderDetailResource($orderDetail);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderDetail $orderDetail)
    {
        //
    }
}
