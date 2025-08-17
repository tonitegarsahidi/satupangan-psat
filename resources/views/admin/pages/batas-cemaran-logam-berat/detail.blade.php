@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Detail of Batas Cemaran Logam Berat')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE AND ADD BUTTON --}}
            <div class="d-flex justify-content-between">

                <div class="bd-highlight">
                    <h3 class="card-header">Detail of Batas Cemaran Logam Berat with id : {{ $data->id }}</h3>
                </div>

            </div>

            <div class="row m-2">

                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;" scope="col" class="bg-dark text-white">Jenis Pangan</th>
                                    <td>{{ $data->jenisPangan->nama_jenis_pangan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Cemaran Logam Berat</th>
                                    <td>{{ $data->cemaranLogamBerat->nama_cemaran_logam_berat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Minimum Value</th>
                                    <td>{{ $data->value_min }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Maximum Value</th>
                                    <td>{{ $data->value_max }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Satuan</th>
                                    <td>{{ $data->satuan }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Metode</th>
                                    <td>{{ $data->metode }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Keterangan</th>
                                    <td>{{ $data->keterangan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Is Active</th>
                                    <td>
                                        @if ($data->is_active)
                                            <span class="badge rounded-pill bg-success"> Yes </span>
                                        @else
                                            <span class="badge rounded-pill bg-danger"> No </span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        @if (config('constant.CRUD.DISPLAY_TIMESTAMPS'))
                            @include('components.crud-timestamps', $data)
                        @endif

                    </div>

                </div>

            </div>





            {{-- ROW FOR ADDITIONAL FUNCTIONALITY BUTTON --}}
            <div class="m-4">
                <a onclick="goBack()" class="btn btn-outline-secondary me-2"><i
                        class="tf-icons bx bx-left-arrow-alt me-2"></i>Back</a>
                <a class="btn btn-primary me-2" href="{{ route('admin.batas-cemaran-logam-berat.edit', ['id' => $data->id]) }}"
                    title="update this batas cemaran logam berat">
                    <i class='tf-icons bx bx-pencil me-2'></i>Edit</a>
                <a class="btn btn-danger me-2" href="{{ route('admin.batas-cemaran-logam-berat.delete', ['id' => $data->id]) }}"
                    title="delete batas cemaran logam berat">
                    <i class='tf-icons bx bx-trash me-2'></i>Delete</a>
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
