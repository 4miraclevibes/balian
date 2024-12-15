@extends('layouts.landing.main')

@section('style')
<style>
    .address-card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    .address-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    .address-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .address-type {
        font-size: 0.8em;
        padding: 3px 8px;
        border-radius: 12px;
        font-weight: bold;
    }
    .address-type.home { background-color: #e6f7ff; color: #0066cc; }
    .address-type.office { background-color: #fff2e6; color: #ff6600; }
    .address-type.other { background-color: #e6ffe6; color: #009933; }
    .address-body p {
        margin-bottom: 5px;
        color: #666;
    }
    .address-body i {
        margin-right: 5px;
        color: #999;
    }
    .address-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
    }
    .status-badge {
        font-size: 0.8em;
        padding: 3px 8px;
        border-radius: 12px;
    }
    .status-badge.active { background-color: #e6ffe6; color: #009933; }
    .status-badge.inactive { background-color: #ffe6e6; color: #cc0000; }
    .edit-btn {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9em;
        transition: background-color 0.3s ease;
    }
    .edit-btn:hover {
        background-color: #45a049;
    }
    .add-address-btn {
        display: block;
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 1em;
        font-weight: bold;
        margin-top: 20px;
        width: 100%;
        text-align: center;
    }
    .add-address-btn:hover {
        background-color: #45a049;
    }   
</style>
@endsection

@section('content')
<div class="container mt-3">
    <div class="bg-white mb-3">
        <div class="d-flex align-items-center">
            <a href="{{ route('home') }}" class="text-success bg-success bg-opacity-10 rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-chevron-left"></i>
            </a>
            <p class="fs-3 m-auto mb-0">Alamat Saya</p>
        </div>
    </div>

    @forelse($userAddresses as $address)
        <div class="address-card">
            <div class="address-header">
                <h5 class="mb-0">{{ $address->receiver_name }}</h5>
                <span class="address-type {{ $address->type }}">{{ ucfirst($address->type) }}</span>
            </div>
            <div class="address-body">
                <p class="phone mb-2"><i class="bi bi-telephone"></i> {{ $address->receiver_phone }}</p>
                <p class="location mb-2"><i class="bi bi-geo-alt"></i> {{ $address->address }}, {{ $address->subDistrict->name }}, {{ $address->subDistrict->district->name }}</p>
            </div>
            <div class="address-footer">
                <span class="status-badge {{ $address->status }}">{{ ucfirst($address->status) }}</span>
                <a href="{{ route('user.addresses.edit', $address->id) }}" class="edit-btn"><i class="bi bi-pencil"></i> Edit</a>
            </div>
        </div>
    @empty
        <p>Anda belum memiliki alamat tersimpan.</p>
    @endforelse

    <a href="{{ route('user.addresses.add') }}" class="add-address-btn">
        <i class="bi bi-plus"></i> Tambah Alamat Baru
    </a>
</div>
@endsection

@section('scripts')
@endsection