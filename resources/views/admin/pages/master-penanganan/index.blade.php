@extends('admin/template-base')

@section('page-title', 'List of Master Penanganan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="card">

            <div class="d-flex justify-content-between">
                <div class="p-2 bd-highlight">
                    <h3 class="card-header">List of Master Penanganan</h3>
                </div>
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('admin.master-penanganan.add') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Penanganan
                    </a>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <div class="p-2 bd-highlight">
                    @include('admin.components.paginator.perpageform')
                </div>
                <div class="p-2 d-flex align-items-center">
                    <form action="{{ url()->full() }}" method="get" class="d-flex align-items-center">
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input type="text" class="form-control border-1 shadow-none bg-light bg-gradient"
                            placeholder="Search nama penanganan.." aria-label="Search nama_penanganan..." name="keyword"
                            value="{{ isset($keyword) ? $keyword : '' }}" />
                        <input type="hidden" name="sort_order" value="{{ request()->input('sort_order') }}" />
                        <input type="hidden" name="sort_field" value="{{ request()->input('sort_field') }}" />
                        <input type="hidden" name="per_page" value="{{ request()->input('per_page') }}" />
                    </form>
                </div>
            </div>

            @if (isset($alerts))
                @include('admin.components.notification.general', $alerts)
            @endif

            <div class="table-responsive text-nowrap">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>
                                <a href="{{ route('admin.master-penanganan.index', [
                                    'sort_field' => 'nama_penanganan',
                                    'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                    'keyword' => $keyword,
                                ]) }}">
                                    Nama Penanganan
                                    @include('components.arrow-sort', ['field' => 'nama_penanganan', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $startNumber = $perPage * ($page - 1) + 1;
                        @endphp
                        @foreach ($penanganans as $penanganan)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>{{ $penanganan->nama_penanganan }}</td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.master-penanganan.detail', ['id' => $penanganan->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.master-penanganan.edit', ['id' => $penanganan->id]) }}"
                                        title="edit">
                                        <i class='bx bx-pencil'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.master-penanganan.delete', ['id' => $penanganan->id]) }}"
                                        title="delete">
                                        <i class='bx bx-trash'></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
                <br />

                <div class="row">
                    <div class="col-md-10 mx-auto">
                        {{ $penanganans->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
