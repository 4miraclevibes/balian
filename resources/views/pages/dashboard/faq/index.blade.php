@extends('layouts.dashboard.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createFaqModal">
                Tambah FAQ
            </button>
        </div>
    </div>

    <div class="card mt-2">
        <h5 class="card-header">Tabel FAQ</h5>
        <div class="table-responsive text-nowrap p-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <table class="table" id="example">
                <thead>
                    <tr class="text-nowrap table-dark">
                        <th class="text-white">No</th>
                        <th class="text-white">Pertanyaan</th>
                        <th class="text-white">Jawaban</th>
                        <th class="text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faqs as $faq)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $faq->question }}</td>
                        <td>{{ Str::limit($faq->answer, 100) }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editFaqModal{{ $faq->id }}">
                                Edit
                            </button>
                            <form action="{{ route('dashboard.faq.destroy', $faq->id) }}" 
                                  method="POST" 
                                  style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- / Content -->

<!-- Modal Create -->
<div class="modal fade" id="createFaqModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah FAQ Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.faq.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pertanyaan</label>
                        <input type="text" class="form-control" name="question" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jawaban</label>
                        <textarea class="form-control" name="answer" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
@foreach($faqs as $faq)
<div class="modal fade" id="editFaqModal{{ $faq->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.faq.update', $faq->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pertanyaan</label>
                        <input type="text" 
                               class="form-control" 
                               name="question" 
                               value="{{ $faq->question }}" 
                               required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jawaban</label>
                        <textarea class="form-control" 
                                  name="answer" 
                                  rows="4" 
                                  required>{{ $faq->answer }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection