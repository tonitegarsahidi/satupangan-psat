@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Detail of Early Warning')

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
                    <h3 class="card-header">Detail of Early Warning with id : {{ $data->id }}</h3>
                </div>

            </div>

            <div class="row m-2">

                <div class="col-md-8 col-xs-12">
                    <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;" scope="col" class="bg-dark text-white">Judul</th>
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
                                    <td class="text-break word-wrap">{!! nl2br($data->content) !!}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Produk terkait</th>
                                    <td>{{ $data->related_product ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Tindakan yang disarankan</th>
                                    <td class="text-break word-wrap">{!! nl2br($data->preventive_steps ?: '-') !!}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Link terkait</th>
                                    <td>
                                        @if ($data->url)
                                            <a href="{{ $data->url }}" target="_blank">{{ $data->url }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Lampiran</th>
                                    <td>
                                        @if ($data->attachment_path)
                                            <a href="{{ asset($data->attachment_path) }}" target="_blank">View Attachment</a>
                                        @else
                                            -
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
                <a class="btn btn-primary me-2" href="{{ route('early-warning.edit', ['id' => $data->id]) }}"
                    title="update this early warning">
                    <i class='tf-icons bx bx-pencil me-2'></i>Edit</a>
                <a class="btn btn-danger me-2" href="{{ route('early-warning.delete-confirm', ['id' => $data->id]) }}"
                    title="delete early warning">
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
