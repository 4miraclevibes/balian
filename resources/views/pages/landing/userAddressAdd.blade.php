@extends('layouts.landing.main')

@section('style')
<style>
    .form-group {
        margin-bottom: 15px;
    }
    .form-control {
        border-radius: 8px;
    }
    .btn-submit {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 8px;
        width: 100%;
    }
</style>
@endsection

@section('content')
<div class="container mt-3">
    <div class="bg-white mb-3">
        <div class="d-flex align-items-center">
            <a href="{{ route('user.addresses') }}" class="text-success bg-success bg-opacity-10 rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-chevron-left"></i>
            </a>
            <p class="fs-3 m-auto mb-0">Tambah Alamat Baru</p>
        </div>
    </div>

    <form action="{{ route('user.addresses.store') }}" method="POST" class="mb-3">
        @csrf
        <div class="form-group">
            <label for="receiver_name">Nama Penerima</label>
            <input type="text" class="form-control" id="receiver_name" name="receiver_name" required>
        </div>
        <div class="form-group">
            <label for="receiver_phone">Nomor Telepon Penerima</label>
            <input type="tel" class="form-control" id="receiver_phone" name="receiver_phone" required>
        </div>
        <div class="form-group">
            <label for="district_id">Kecamatan</label>
            <select class="form-control" id="district_id" required>
                <option value="">Pilih Kecamatan</option>
                @foreach($districts as $district)
                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="sub_district_id">Kelurahan</label>
            <select class="form-control" id="sub_district_id" name="sub_district_id" required>
                <option value="">Pilih Kelurahan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="address">Alamat Lengkap</label>
            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="type">Tipe Alamat</label>
            <select class="form-control" id="type" name="type" required>
                <option value="home">Rumah</option>
                <option value="office">Kantor</option>
                <option value="other">Lainnya</option>
            </select>
        </div>
        {{-- <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" class="form-control" id="latitude" name="latitude">
        </div>
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" class="form-control" id="longitude" name="longitude">
        </div> --}}
        <div class="form-group">
            <label for="status">Status Alamat</label>
            <select class="form-control" id="status" name="status" required>
                <option value="active">Aktif</option>
                <option value="inactive">Tidak Aktif</option>
            </select>
        </div>
        <button type="submit" class="btn-submit">Simpan Alamat</button>
    </form>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var districts = @json($districts);

        $('#district_id').change(function() {
            var districtId = $(this).val();
            var subDistricts = districts.find(d => d.id == districtId).subdistricts;
            var subDistrictSelect = $('#sub_district_id');
            
            subDistrictSelect.empty();
            subDistrictSelect.append('<option value="">Pilih Kelurahan</option>');
            
            $.each(subDistricts, function(index, subDistrict) {
                subDistrictSelect.append('<option value="' + subDistrict.id + '">' + subDistrict.name + '</option>');
            });
        });
    });
</script>
@endsection