@extends('admin/template-base')

@section('page-title', 'Detail Batas Cemaran Pestisida')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">

            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Detail Batas Cemaran Pestisida</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.batas-cemaran-pestisida.edit', $data->id) }}" class="btn btn-warning">
                                <i class="bx bx-edit me-1"></i> Edit
                            </a>
                            <a href="{{ route('admin.batas-cemaran-pestisida.index') }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back me-1"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jenis Pangan</label>
                                    <p class="form-control-plaintext">{{ $data->jenisPangan->nama_jenis_pangan ?? '-' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Cemaran Pestisida</label>
                                    <p class="form-control-plaintext">{{ $data->cemaranPestisida->nama_cemaran_pestisida ?? '-' }}</p>
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

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Created By</label>
                                                    <p class="form-control-plaintext">{{ $data->created_by ?? '-' }}</p>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Created At</label>
                                                    <p class="form-control-plaintext">{{ $data->created_at ? date('d-m-Y H:i:s', strtotime($data->created_at)) : '-' }}</p>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Updated By</label>
                                                    <p class="form-control-plaintext">{{ $data->updated_by ?? '-' }}</p>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Updated At</label>
                                                    <p class="form-control-plaintext">{{ $data->updated_at ? date('d-m-Y H:i:s', strtotime($data->updated_at)) : '-' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
