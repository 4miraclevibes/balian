@extends('layouts.dashboard.main')

@section('content')

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
<h1>Selamat datang {{ Auth::user()->name }}</h1>
</div>

{{-- <form action="{{ route('dashboard.send-whatsapp-notification') }}" method="post">
    @csrf
    <input type="text" name="message">
    <button type="submit">Send</button>
</form> --}}

<!-- / Content -->


@endsection
