<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use App\Models\District;
use App\Models\SubDistrict;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserAddressController extends Controller
{
    public function index()
    {
        $assets = Asset::where('is_active', true)->get();
        $userAddresses = UserAddress::where('user_id', Auth::id())->with('subDistrict.district')->get();
        return view('pages.landing.userAddress', compact('userAddresses', 'assets'));
    }

    public function create()
    {
        $assets = Asset::where('is_active', true)->get();
        $districts = District::with('subdistricts')->get();
        return view('pages.landing.userAddressAdd', compact('districts', 'assets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_name' => 'required',
            'receiver_phone' => 'required',
            'sub_district_id' => 'required|exists:sub_districts,id',
            'address' => 'required',
            'type' => 'required|in:home,office,other',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'required|in:active,inactive',
        ]);

        DB::transaction(function () use ($request) {
            if ($request->status == 'active') {
                UserAddress::where('user_id', Auth::id())->update(['status' => 'inactive']);
            }

            $data = $request->all();
            $data['user_id'] = Auth::id();
            UserAddress::create($data);
        });

        return redirect()->route('user.addresses')->with('success', 'Alamat berhasil ditambahkan');
    }

    public function edit($id)
    {
        $assets = Asset::where('is_active', true)->get();
        $address = UserAddress::findOrFail($id);
        $districts = District::with('subdistricts')->get();
        return view('pages.landing.userAddressEdit', compact('address', 'districts', 'assets'));
    }

    public function update(Request $request, $id)
    {
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

        return redirect()->route('user.addresses')->with('success', 'Alamat berhasil diperbarui');
    }

    public function destroy($id)
    {
        $address = UserAddress::find($id);
        $address->delete();

        return redirect()->route('user.addresses')->with('success', 'Alamat berhasil dihapus');
    }   
}
