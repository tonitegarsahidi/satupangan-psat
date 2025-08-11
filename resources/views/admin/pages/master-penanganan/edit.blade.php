@extends('admin/template-base')

@section('page-title', 'Edit Master Penanganan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Master Penanganan</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.master-penanganan.update', $penanganan->id) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama_penanganan">Nama Penanganan*</label>
                                <div class="col-sm-10">
                                    @include('admin.components.notification.error-validation', ['field' => 'nama_penanganan'])
                                    <input type="text" name="nama_penanganan" class="form-control" id="nama_penanganan"
                                        placeholder="contoh:  Cuci dengan air bersih" value="{{ old('nama_penanganan', $penanganan->nama_penanganan) }}">
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
