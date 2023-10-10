<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressCollection;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advertisements = Address::paginate(20);
        return new AddressCollection($advertisements);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $phone = new Address();
        $phone->ubication = $request->ubication;
        $phone->addressable_id = $request->addressable_id;
        $phone->addressable_type = Order::class;
        $phone->save();

        return new AddressResource($phone);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $phone = Address::findOrFail($id);
            return new AddressResource($phone);
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
