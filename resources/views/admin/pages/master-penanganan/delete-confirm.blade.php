@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Confirm Delete Master Penanganan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="card">
            <div class="d-flex justify-content-between">
                <div class="bd-highlight">
                    <h3 class="card-header">Are you sure want to delete this Master Penanganan?</h3>
                </div>
            </div>

            <div class="m-4">
                <form action="{{ route('admin.master-penanganan.delete', $data->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <a onclick="goBack()" class="btn btn-outline-secondary me-2"><i
                        class="tf-icons bx bx-left-arrow-alt me-2"></i>Back</a>
                    <button type="submit" class="btn btn-danger me-2"
                        title="delete penanganan">
                        <i class='tf-icons bx bx-trash me-2'></i>Confirm Delete
                    </button>
                </form>
            </div>

            <div class="row m-2">
                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;" scope="col" class="bg-dark text-white">Nama Penanganan</th>
                                    <td>{{ $data->nama_penanganan }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if (config('constant.CRUD.DISPLAY_TIMESTAMPS'))
                            @include('components.crud-timestamps', $data)
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-code')
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
