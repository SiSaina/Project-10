<?php

namespace App\Http\Controllers\Api\V1;

use App\Filter\V1\ImageFilter;
use App\Models\Image;
use App\Http\Requests\V1\StoreImageRequest;
use App\Http\Requests\V1\UpdateImageRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreImageRequest;
use App\Http\Resources\V1\ImageCollection;
use App\Http\Resources\V1\ImageResource;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ImageFilter();
        $filterItems = $filter->transform($request);

        if(count($filterItems) === 0) {
            return new ImageCollection(Image::paginate());
        }
        else {
            return new ImageCollection(Image::where($filterItems)->paginate());
        }
    }
    public function bulkStore(BulkStoreImageRequest $request)
    {
        Image::insert(collect($request->validated())->toArray());
    }
    public function upload(Request $request){
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('practise-images', 'public');

            return 'storage/' . $path;
        }
        return null;
    }
    /**
     * Store a newly created resource in storage.     
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImageRequest $request)
    {    
        $image = Image::create([
            'product_id' => $request->input('product_id'), // make sure key matches JSON
            'url' => $request->input('url'),               // store file name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Image record created successfully',
            'data' => $image,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        return new ImageResource($image);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        $image->update($request->validated());
        return new ImageResource($image);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }


}
