@extends('layouts.dashboard.main')

@section('content')
<div class="card container p-3">
    <h3 class="mb-3 text-center">Create User</h3>
    <form action="{{ route('dashboard.user.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" required>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control form-control-sm" id="email" name="email" required>
            </div>
            <div class="col-md-6">
                <label for="role_id" class="form-label">Role</label>
                <select class="form-select form-select-sm" id="role_id" name="role_id" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control form-control-sm" id="password" name="password" required>
            </div>
            <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" required>
            </div>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Create</button>
        <a href="{{ route('dashboard.user.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
    </form>
</div>
@endsection