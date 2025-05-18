<?php

namespace App\Http\Controllers\Api\V1;

use App\Filter\V1\AddressFilter;
use App\Models\Address;
use App\Http\Requests\V1\StoreAddressRequest;
use App\Http\Requests\V1\UpdateAddressRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AddressResource;
use App\Http\Resources\V1\AddressCollection;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new AddressFilter();
        $filterItems = $filter->transform($request);

        if(count($filterItems) === 0) {
            return new AddressCollection(Address::paginate());
        }
        else {
            return new AddressCollection(Address::where($filterItems)->paginate());
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddressRequest $request)
    {
        return new AddressResource(Address::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        return new AddressResource($address);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        $address->update($request->validated());
        return new AddressResource($address);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        //
    }
}
