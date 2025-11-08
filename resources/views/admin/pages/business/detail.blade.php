@extends('admin/template-base')

@section('page-title', 'Business Detail')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Business Detail</h5>
                        <div>
                            <a href="{{ route('business.edit', $data->id) }}" class="btn btn-primary me-2">
                                <i class='bx bx-pencil'></i> Edit
                            </a>
                            <a href="{{ route('business.index') }}" class="btn btn-secondary">
                                <i class='bx bx-arrow-back'></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="card-title">Business Information</h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 30%">Nama Perusahaan</th>
                                        <td>{{ $data->nama_perusahaan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Perusahaan</th>
                                        <td>{{ $data->alamat_perusahaan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan Perusahaan</th>
                                        <td>{{ $data->jabatan_perusahaan }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIB</th>
                                        <td>{{ $data->nib }}</td>
                                    </tr>
                                    <tr>
                                        <th>UMKM</th>
                                        <td>{{ $data->is_umkm ? 'Ya' : 'Tidak' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if ($data->is_active)
                                                <span class="badge rounded-pill bg-success">Aktif</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>

                                @if (config('constant.CRUD.DISPLAY_TIMESTAMPS'))
                                    @include('components.crud-timestamps', $data)
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6 class="card-title">Location Information</h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 30%">Provinsi</th>
                                        <td>{{ $data->provinsi ? $data->provinsi->nama_provinsi : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kota</th>
                                        <td>{{ $data->kota ? $data->kota->nama_kota : '-' }}</td>
                                    </tr>
                                </table>

                                <h6 class="card-title mt-4">Jenis PSAT</h6>
                                @if ($data->jenispsats && $data->jenispsats->count() > 0)
                                    <div class="row">
                                        @foreach ($data->jenispsats as $jenispsat)
                                            <div class="col-md-6 mb-2">
                                                <span class="badge bg-info">{{ $jenispsat->nama_jenis_pangan_segar }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">No jenis PSAT selected</p>
                                @endif

                                <h6 class="card-title mt-4">User Information</h6>
                                @if ($data->user)
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 30%">Nama User</th>
                                            <td>{{ $data->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $data->user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Role</th>
                                            <td>
                                                @if ($data->user->roles && $data->user->roles->count() > 0)
                                                    @foreach ($data->user->roles as $role)
                                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">No roles assigned</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                @else
                                    <p class="text-muted">No user associated with this business</p>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <a href="{{ route('business.delete', $data->id) }}" class="btn btn-danger">
                                    <i class='bx bx-trash'></i> Delete Business
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
