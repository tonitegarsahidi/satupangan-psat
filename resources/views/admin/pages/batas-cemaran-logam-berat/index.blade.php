@extends('admin/template-base')

@section('page-title', 'Batas Cemaran Logam Berat List')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row mb-4">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Batas Cemaran Logam Berat List</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.batas-cemaran-logam-berat.add') }}" class="btn btn-primary">
                                <i class="bx bx-plus me-1"></i> Add New
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('admin.components.notification.general', ['alerts' => $alerts])

                        {{-- Search and Filter --}}
                        <form method="GET" action="{{ route('admin.batas-cemaran-logam-berat.index') }}" class="mb-4">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                                        <input type="text" class="form-control" name="keyword" placeholder="Search..." value="{{ $keyword }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <select name="sort_field" class="form-select">
                                        <option value="id" {{ $sortField == 'id' ? 'selected' : '' }}>ID</option>
                                        <option value="created_at" {{ $sortField == 'created_at' ? 'selected' : '' }}>Created Date</option>
                                        <option value="updated_at" {{ $sortField == 'updated_at' ? 'selected' : '' }}>Updated Date</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="sort_order" class="form-select">
                                        <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Ascending</option>
                                        <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Descending</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="per_page" class="form-select">
                                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bx bx-search me-1"></i> Search
                                    </button>
                                </div>
                            </div>
                        </form>

                        {{-- Data Table --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Jenis Pangan</th>
                                        <th>Cemaran Logam Berat</th>
                                        <th>Min Value</th>
                                        <th>Max Value</th>
                                        <th>Satuan</th>
                                        <th>Metode</th>
                                        <th>Status</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($batasCemaranLogamBerats as $index => $item)
                                        <tr>
                                            <td>{{ ($perPage * ($page - 1)) + $index + 1 }}</td>
                                            <td>{{ $item->jenisPangan->nama_jenis_pangan ?? '-' }}</td>
                                            <td>{{ $item->cemaranLogamBerat->nama_cemaran_logam_berat ?? '-' }}</td>
                                            <td>{{ $item->value_min }}</td>
                                            <td>{{ $item->value_max }}</td>
                                            <td>{{ $item->satuan }}</td>
                                            <td>{{ $item->metode }}</td>
                                            <td>
                                                @if($item->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('admin.batas-cemaran-logam-berat.detail', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="{{ route('admin.batas-cemaran-logam-berat.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.batas-cemaran-logam-berat.delete', $item->id) }}" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="bx bx-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No data available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Showing {{ $batasCemaranLogamBerats->firstItem() }} to {{ $batasCemaranLogamBerats->lastItem() }} of {{ $batasCemaranLogamBerats->total() }} entries
                            </div>
                            <div>
                                {{ $batasCemaranLogamBerats->links('admin.components.paginator.default') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
