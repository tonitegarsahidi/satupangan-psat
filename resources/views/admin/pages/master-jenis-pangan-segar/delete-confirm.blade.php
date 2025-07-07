@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Confirm Delete Jenis Pangan Segar')

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
                    <h3 class="card-header">Are you sure want to delete this Jenis Pangan Segar?</h3>
                </div>

            </div>



            {{-- ROW FOR ADDITIONAL FUNCTIONALITY BUTTON --}}
            <div class="m-4">

                <form action="{{ route('admin.master-jenis-pangan-segar.delete', $data->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <a onclick="goBack()" class="btn btn-outline-secondary me-2"><i
                        class="tf-icons bx bx-left-arrow-alt me-2"></i>Back</a>

                    <button type="submit" class="btn btn-danger me-2"
                        title="delete jenis pangan segar">
                        <i class='tf-icons bx bx-trash me-2'></i>Confirm Delete
                    </button>
                </form>
            </div>

            {{-- DETAIL OF THE DATA WHICH WANT TO BE DELETED --}}
            <div class="row m-2">

                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Kelompok Pangan</th>
                                    <td>{{ $data->kelompok->nama_kelompok_pangan }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Kode Jenis Pangan Segar</th>
                                    <td>{{ $data->kode_jenis_pangan_segar }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Nama Jenis Pangan Segar</th>
                                    <td>{{ $data->nama_jenis_pangan_segar }}</td>
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
