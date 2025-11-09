@extends('admin/template-base')

@section('page-title', $data->is_active ? 'Deactivate Business' : 'Activate Business')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ $data->is_active ? 'Deactivate Business' : 'Activate Business' }}</h5>
                        <small class="text-muted float-end">Are you sure you want to {{ $data->is_active ? 'deactivate' : 'activate' }} this business?</small>
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
                                        @foreach($data->jenispsats as $jenispsat)
                                            <div class="col-md-6 mb-2">
                                                <span class="badge bg-info">{{ $jenispsat->nama_jenis_pangan_segar }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">No jenis PSAT selected</p>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <form action="{{ route('business.toggle-status', $data->id) }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    @if ($data->is_active)
                                        <button type="submit" class="btn btn-danger me-2">
                                            <i class='bx bx-power-off'></i> Deactivate Business
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-success me-2">
                                            <i class='bx bx-power-on'></i> Activate Business
                                        </button>
                                    @endif
                                    <a href="{{ route('business.index') }}" class="btn btn-secondary">
                                        <i class='bx bx-x'></i> Cancel
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
