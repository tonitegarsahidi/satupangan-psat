@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'View User')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE --}}
            <div class="d-flex justify-content-between">

                <div class="bd-highlight">
                    <h3 class="card-header">View User with id : {{ $data->id }}</h3>
                </div>

            </div>

            <div class="row m-2">

                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;" scope="col" class="bg-dark text-white">Name</th>
                                    <td>{{ $data->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Email</th>
                                    <td>{{ $data->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Phone Number</th>
                                    <td>{{ $data->phone_number }}</td>
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
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Role</th>
                                    <td>
                                        @foreach ($data->listRoles() as $role)
                                            @if (strcasecmp($role, 'ADMINISTRATOR') == 0)
                                                <span class="badge rounded-pill bg-label-danger m-1"> {{ $role }}
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-label-primary m-1"> {{ $role }}
                                                </span>
                                            @endif
                                            <br />
                                        @endforeach
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

            {{-- ROW FOR BACK BUTTON --}}
            <div class="m-4">
                <a onclick="goBack()" class="btn btn-outline-secondary me-2"><i
                        class="tf-icons bx bx-left-arrow-alt me-2"></i>Back</a>
            </div>

        </div>

        {{-- BUSINESS DETAILS CARD --}}
        @if ($data->business)
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Business Details</h4>
                </div>
                <div class="row m-2">
                    <div class="col-md-8 col-xs-12">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th style="width: 250px;" scope="col" class="bg-dark text-white">Company Name</th>
                                        <td>{{ $data->business->nama_perusahaan }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="bg-dark text-white">Address</th>
                                        <td>{{ $data->business->alamat_perusahaan }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="bg-dark text-white">Position</th>
                                        <td>{{ $data->business->jabatan_perusahaan }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="bg-dark text-white">NIB</th>
                                        <td>{{ $data->business->nib }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="bg-dark text-white">Business Type</th>
                                        <td>
                                            @if ($data->business->is_umkm)
                                                <span class="badge rounded-pill bg-success">UMKM</span>
                                            @else
                                                <span class="badge rounded-pill bg-info">Non-UMKM</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="bg-dark text-white">Status</th>
                                        <td>
                                            @if ($data->business->is_active)
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

@endsection

@section('footer-code')

    <script>
        function goBack() {
            window.history.back();
        }
    </script>

@endsection
