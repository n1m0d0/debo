<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhoneStoreRequest;
use App\Http\Resources\PhoneCollection;
use App\Http\Resources\PhoneResource;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advertisements = Phone::paginate(20);
        return new PhoneCollection($advertisements);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PhoneStoreRequest $request)
    {
        $phone = new Phone();
        $phone->number = $request->number;
        $phone->phoneable_id = $request->phoneable_id;
        $phone->phoneable_type = User::class;
        $phone->save();

        return new PhoneResource($phone);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $phone = Phone::findOrFail($id);
            return new PhoneResource($phone);
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
        try {
            $phone = Phone::findOrFail($id);
            $phone->delete();
            return new PhoneResource($phone);
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
}
