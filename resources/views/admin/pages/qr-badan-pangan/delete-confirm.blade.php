@extends('admin/template-base')

@section('page-title', 'Delete QR Badan Pangan')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Delete QR Badan Pangan</h4>
                        <p class="card-subtitle mb-4">Are you sure you want to delete this QR Badan Pangan?</p>

                        <div class="alert alert-danger">
                            <h5>Warning!</h5>
                            <p>This action cannot be undone. This will permanently delete the QR Badan Pangan and all its associated data.</p>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <strong>Nama Komoditas:</strong> {{ $qrBadanPangan->nama_komoditas }}
                            </div>
                            <div class="col-md-6">
                                <strong>Merk Dagang:</strong> {{ $qrBadanPangan->merk_dagang }}
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <strong>Nama Latin:</strong> {{ $qrBadanPangan->nama_latin }}
                            </div>
                            <div class="col-md-6">
                                <strong>Status:</strong>
                                @if($qrBadanPangan->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($qrBadanPangan->status == 'reviewed')
                                    <span class="badge bg-info">Reviewed</span>
                                @elseif($qrBadanPangan->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($qrBadanPangan->status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <strong>Business:</strong> {{ $qrBadanPangan->business->nama_perusahaan ?? 'N/A' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Published:</strong> {{ $qrBadanPangan->is_published ? 'Yes' : 'No' }}
                            </div>
                        </div>

                        <form action="{{ route('qr-badan-pangan.destroy', ['id' => $qrBadanPangan->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-danger me-2">Delete</button>
                                    <a href="{{ route('qr-badan-pangan.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
