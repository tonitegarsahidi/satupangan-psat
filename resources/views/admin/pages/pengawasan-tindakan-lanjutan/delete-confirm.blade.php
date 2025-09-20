@extends('admin/template-base')

@section('page-title', 'Delete Pengawasan Tindakan Lanjutan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE --}}
            <div class="d-flex justify-content-between">

                <div class="bd-highlight">
                    <h3 class="card-header">Delete Pengawasan Tindakan Lanjutan</h3>
                </div>

            </div>

            <div class="row m-2">

                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;" scope="col" class="bg-dark text-white">Tindakan Asal</th>
                                    <td>
                                        @if ($data->tindakan)
                                            {{ $data->tindakan->tindak_lanjut ?: '-' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">PIC Tindakan Lanjutan</th>
                                    <td>
                                        @if ($data->pic)
                                            {{ $data->pic->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Arah Tindak Lanjut</th>
                                    <td>{{ $data->arahan_tindak_lanjut ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Status</th>
                                    <td>
                                        <span class="badge rounded-pill bg-info">{{ $data->getStatusLabel() }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Aktif</th>
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
                    </div>

                </div>

            </div>

            {{-- DELETE CONFIRMATION MESSAGE --}}
            <div class="alert alert-warning m-4" role="alert">
                <h4 class="alert-heading">Warning!</h4>
                <p>Are you sure you want to delete this Pengawasan Tindakan Lanjutan? This action cannot be undone.</p>
                <hr>
                <p class="mb-0">Please confirm if you want to proceed with the deletion.</p>
            </div>

            {{-- ROW FOR DELETE BUTTON --}}
            <div class="m-4">
                <form action="{{ route('pengawasan-tindakan-lanjutan.destroy', $data->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger me-2">
                        <i class='tf-icons bx bx-trash me-2'></i>Confirm Delete
                    </button>
                    <a onclick="goBack()" class="btn btn-outline-secondary">
                        <i class='tf-icons bx bx-left-arrow-alt me-2'></i>Cancel
                    </a>
                </form>
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
