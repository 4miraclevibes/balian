<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use App\Models\District;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserAddressController extends Controller
{
    public function index()
    {
        try {
            $userAddresses = UserAddress::where('user_id', Auth::id())
                ->with('subDistrict.district')
                ->get();
            return response()->json(['data' => $userAddresses], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving addresses', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'receiver_name' => 'required',
                'receiver_phone' => 'required',
                'sub_district_id' => 'required|exists:sub_districts,id',
                'address' => 'required',
                'type' => 'required|in:home,office,other',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'status' => 'required|in:active,inactive',
            ]);

            $address = DB::transaction(function () use ($validatedData) {
                if ($validatedData['status'] == 'active') {
                    UserAddress::where('user_id', Auth::id())->update(['status' => 'inactive']);
                }

                $validatedData['user_id'] = Auth::id();
                return UserAddress::create($validatedData);
            });

            return response()->json(['message' => 'Address added successfully', 'data' => $address], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error adding address', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $address = UserAddress::with('subDistrict.district')->findOrFail($id);
            return response()->json(['data' => $address], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Address not found', 'error' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $address = UserAddress::findOrFail($id);
            
            $validatedData = $request->validate([
                'receiver_name' => 'required',
                'receiver_phone' => 'required',
                'sub_district_id' => 'required|exists:sub_districts,id',
                'address' => 'required',
                'type' => 'required|in:home,office,other',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'status' => 'required|in:active,inactive',
            ]);

            DB::transaction(function () use ($address, $validatedData) {
                if ($validatedData['status'] == 'active') {
                    UserAddress::where('user_id', $address->user_id)
                               ->where('id', '!=', $address->id)
                               ->update(['status' => 'inactive']);
                }

                $address->update($validatedData);
            });

            return response()->json(['message' => 'Address updated successfully', 'data' => $address], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating address', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $address = UserAddress::findOrFail($id);
            $address->delete();

            return response()->json(['message' => 'Address deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting address', 'error' => $e->getMessage()], 500);
        }
    }

    public function getDistricts()
    {
        try {
            $districts = District::with('subdistricts')->get();
            return response()->json(['data' => $districts], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving districts', 'error' => $e->getMessage()], 500);
        }
    }
}
