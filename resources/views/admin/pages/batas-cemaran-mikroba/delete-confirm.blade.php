@extends('admin/template-base')

@section('page-title', 'Delete Batas Cemaran Mikroba')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">

            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Delete Batas Cemaran Mikroba</h5>
                        <a href="{{ route('admin.batas-cemaran-mikroba.index') }}" class="btn btn-secondary">
                            <i class="bx bx-arrow-back me-1"></i> Back
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="bx bx-error-circle me-2"></i>
                            <strong>Warning:</strong> Are you sure you want to delete this record? This action cannot be undone.
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jenis Pangan</label>
                                    <p class="form-control-plaintext">{{ $data->jenisPangan->nama_jenis_pangan ?? '-' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Cemaran Mikroba</label>
                                    <p class="form-control-plaintext">{{ $data->cemaranMikroba->nama_cemaran_mikroba ?? '-' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Minimum Value</label>
                                    <p class="form-control-plaintext">{{ $data->value_min }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Maximum Value</label>
                                    <p class="form-control-plaintext">{{ $data->value_max }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Satuan</label>
                                    <p class="form-control-plaintext">{{ $data->satuan }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Metode</label>
                                    <p class="form-control-plaintext">{{ $data->metode }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Keterangan</label>
                                    <p class="form-control-plaintext">{{ $data->keterangan ?? '-' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <p class="form-control-plaintext">
                                        @if($data->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.batas-cemaran-mikroba.destroy', $data->id) }}">
                            @csrf
                            @method('DELETE')

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('admin.batas-cemaran-mikroba.index') }}" class="btn btn-secondary">
                                    <i class="bx bx-x me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-danger">
                                    <i class="bx bx-trash me-1"></i> Delete
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
