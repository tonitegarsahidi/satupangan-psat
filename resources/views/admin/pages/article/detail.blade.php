@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Detail of Article')

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
                    <h3 class="card-header">Detail of Article with id : {{ $data->id }}</h3>
                </div>

            </div>

            <div class="row m-2">

                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 250px;" scope="col" class="bg-dark text-white">Title</th>
                                    <td>{{ $data->title }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Slug</th>
                                    <td><code>{{ $data->slug }}</code></td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Category</th>
                                    <td>
                                        <span class="badge bg-{{ $data->category == 'pembinaan' ? 'info' : 'primary' }}">
                                            {{ ucfirst($data->category) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Status</th>
                                    <td>
                                        @if ($data->status == 'published')
                                            <span class="badge rounded-pill bg-success"> Published </span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary"> Draft </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Author</th>
                                    <td>{{ $data->author->name ?? 'Unknown' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Views</th>
                                    <td>{{ number_format($data->view_count) }}</td>
                                </tr>
                                @if($data->excerpt)
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Excerpt</th>
                                    <td>{{ $data->excerpt }}</td>
                                </tr>
                                @endif
                                @if($data->published_at)
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Published Date</th>
                                    <td>{{ $data->published_at->format('l, d F Y \a\t H:i') }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Featured</th>
                                    <td>
                                        @if($data->is_featured)
                                            <span class="badge rounded-pill bg-warning"> Yes </span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary"> No </span>
                                        @endif
                                    </td>
                                </tr>
                                @if($data->featured_image)
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Featured Image</th>
                                    <td>
                                        <img src="{{ asset('storage/' . $data->featured_image) }}" alt="Featured Image" class="img-thumbnail" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Content</th>
                                    <td>{!! nl2br(e($data->content)) !!}</td>
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
                <a class="btn btn-primary me-2" href="{{ route('admin.article.edit', ['id' => $data->id]) }}"
                    title="update this article">
                    <i class='tf-icons bx bx-pencil me-2'></i>Edit</a>
                <a class="btn btn-danger me-2" href="{{ route('admin.article.delete', ['id' => $data->id]) }}"
                    title="delete article">
                    <i class='tf-icons bx bx-trash me-2'></i>Delete</a>
            </div>

        </div>
    </div>

@endsection

@push('styles')
<style>
    /* Force table to stay within container bounds */
    .table-responsive {
        overflow-x: auto;
        max-width: 100%;
    }

    /* Fixed table layout to prevent column expansion */
    .table {
        table-layout: fixed;
        width: 100%;
        max-width: 100%;
    }

    /* Header column width */
    .table th:first-child {
        width: 200px;
        min-width: 200px;
        max-width: 200px;
    }

    /* Data column takes remaining space */
    .table td:last-child {
        width: auto;
        max-width: none;
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: normal;
    }

    /* All table cells */
    .table td {
        vertical-align: top;
        padding: 12px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: normal;
        max-width: 400px;
    }

    .table th {
        vertical-align: top;
        white-space: nowrap;
        background-color: #212529;
        color: white;
    }

    /* Specific handling for content fields */
    .table td pre,
    .table td code {
        white-space: pre-wrap;
        word-wrap: break-word;
        overflow-wrap: break-word;
        max-width: 100%;
    }

    /* Handle long URLs and slugs */
    .table td code {
        word-break: break-all;
        overflow-wrap: break-word;
    }

    /* Ensure images don't cause overflow */
    .table td img {
        max-width: 100%;
        height: auto;
    }
</style>
@endpush

@section('footer-code')

    <script>
        function goBack() {
            window.history.back();
        }
    </script>

@endsection
