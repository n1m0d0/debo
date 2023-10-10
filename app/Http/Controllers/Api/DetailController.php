<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DetailCollection;
use App\Http\Resources\DetailResource;
use App\Models\Detail;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = Detail::paginate(20);
        return new DetailCollection($details);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $detail = new Detail();
        $detail->order_id = $request->order_id;
        $detail->product_id = $request->product_id;
        $detail->price = $request->price;
        $detail->save();

        return new DetailResource($detail);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $detail = Detail::findOrFail($id);
            return new DetailResource($detail);
        } catch (\Exception $e) {
            return response()->json([
                'is_success' => false,
                'message'   => 'Validation errors',
                'errors'  => [
                    'id' => 'Id not found!'
                ],
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
