@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Confirm Delete Early Warning')

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
                    <h3 class="card-header">Are you sure want to delete this Early Warning?</h3>
                </div>

            </div>



            {{-- ROW FOR ADDITIONAL FUNCTIONALITY BUTTON --}}
            <div class="m-4">

                <form action="{{ route('early-warning.destroy', $data->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <a onclick="goBack()" class="btn btn-outline-secondary me-2"><i
                        class="tf-icons bx bx-left-arrow-alt me-2"></i>Back</a>

                    <button type="submit" class="btn btn-danger me-2"
                        title="delete early warning">
                        <i class='tf-icons bx bx-trash me-2'></i>Confirm Delete
                    </button>
                </form>
            </div>

            {{-- DETAIL OF THE DATA WHICH WANT TO BE DELETED --}}
            <div class="row m-2">

                <div class="col-md-8 col-xs-12">
                    <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Judul</th>
                                    <td>{{ $data->title }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Status</th>
                                    <td>
                                        @if ($data->status == 'Published')
                                            <span class="badge rounded-pill bg-success">{{ $data->status }}</span>
                                        @elseif ($data->status == 'Approved')
                                            <span class="badge rounded-pill bg-primary">{{ $data->status }}</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">{{ $data->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Tingkat Keparahan</th>
                                    <td>
                                        @if ($data->urgency_level == 'Danger')
                                            <span class="badge rounded-pill bg-danger">{{ $data->urgency_level }}</span>
                                        @elseif ($data->urgency_level == 'Warning')
                                            <span class="badge rounded-pill bg-warning text-dark">{{ $data->urgency_level }}</span>
                                        @else
                                            <span class="badge rounded-pill bg-info text-dark">{{ $data->urgency_level }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Isi Peringatan</th>
                                    <td class="text-break word-wrap">{!! Str::limit($data->content, 200) !!}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Produk terkait</th>
                                    <td>{{ $data->related_product ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Tindakan yang disarankan</th>
                                    <td class="text-break word-wrap">{!! Str::limit($data->preventive_steps, 200) ?: '-' !!}</td>
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
