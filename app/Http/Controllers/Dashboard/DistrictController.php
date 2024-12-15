<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\SubDistrict;
use Illuminate\Support\Facades\DB;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::all();
        $subdistricts = SubDistrict::all();
        return view('pages.dashboard.districts.index', compact('districts', 'subdistricts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        District::create($request->all());

        return redirect()->route('dashboard.district.index')->with('success', 'Kecamatan berhasil ditambahkan');
    }

    public function destroy(District $district)
    {
        $district->delete();
        return redirect()->route('dashboard.district.index')->with('success', 'Kecamatan berhasil dihapus');
    }

    public function storeSubDistrict(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'fee' => 'required|numeric',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        SubDistrict::create($request->all());

        return redirect()->route('dashboard.district.index')->with('success', 'Sub Kecamatan berhasil ditambahkan');
    }

    public function destroySubDistrict(SubDistrict $subdistrict)
    {
        $subdistrict->delete();
        return redirect()->route('dashboard.district.index')->with('success', 'Sub Kecamatan berhasil dihapus');
    }

    public function update(Request $request, District $district)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $district->update($request->all());

        return redirect()->route('dashboard.district.index')->with('success', 'Kecamatan berhasil diperbarui');
    }

    public function updateFeeAll(Request $request)
    {
        $request->validate([
            'new_fee' => 'required|numeric|min:0',
        ]);

        $newFee = $request->new_fee;

        DB::transaction(function () use ($newFee) {
            SubDistrict::query()->update([
                'fee' => $newFee
            ]);
        });

        return redirect()->route('dashboard.district.index')->with('success', 'Fee semua Sub Kecamatan berhasil diupdate');
    }

    public function updateSubDistrict(Request $request, SubDistrict $subdistrict)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'fee' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $subdistrict->update($request->all());

        return redirect()->route('dashboard.district.index')->with('success', 'Sub Kecamatan berhasil diperbarui');
    }
}
