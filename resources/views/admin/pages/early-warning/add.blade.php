@extends('admin/template-base')

@section('page-title', 'Add New Early Warning')


@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        @if(session('alerts'))
            @foreach(session('alerts') as $alert)
                <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show" role="alert">
                    {{ $alert['message'] }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif

        <div class="row">


            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Add Early Warning</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('early-warning.store') }}">
                            @csrf

                            {{-- TITLE FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="title">Judul<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'title'])

                                    {{-- input form --}}
                                    <input type="text" name="title" class="form-control" id="title"
                                        placeholder="Enter title for the early warning" value="{{ old('title') }}">
                                </div>
                            </div>


                            {{-- URGENCY LEVEL FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="urgency_level">Tingkat Keparahan<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'urgency_level'])

                                    {{-- input form --}}
                                    <select name="urgency_level" id="urgency_level" class="form-select">
                                        <option value="Info" {{ old('urgency_level') == 'Info' ? 'selected' : '' }}>Info</option>
                                        <option value="Warning" {{ old('urgency_level') == 'Warning' ? 'selected' : '' }}>Warning</option>
                                        <option value="Danger" {{ old('urgency_level') == 'Danger' ? 'selected' : '' }}>Danger</option>
                                    </select>
                                </div>
                            </div>

                            {{-- CONTENT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="content">Isi Peringatan<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'content'])

                                    {{-- input form --}}
                                    <textarea name="content" id="content" class="form-control" rows="5" placeholder="Enter content for the early warning">{{ old('content') }}</textarea>
                                </div>
                            </div>

                            {{-- RELATED PRODUCT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="related_product">Produk terkait</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'related_product'])

                                    {{-- input form --}}
                                    <input type="text" name="related_product" class="form-control" id="related_product"
                                        placeholder="Enter related product name" value="{{ old('related_product') }}">
                                </div>
                            </div>

                            {{-- PREVENTIVE STEPS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="preventive_steps">Tindakan yang disarankan</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'preventive_steps'])

                                    {{-- input form --}}
                                    <textarea name="preventive_steps" id="preventive_steps" class="form-control" rows="3" placeholder="Enter preventive steps">{{ old('preventive_steps') }}</textarea>
                                </div>
                            </div>

                            {{-- URL FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="url">Link terkait</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'url'])

                                    {{-- input form --}}
                                    <input type="text" name="url" class="form-control" id="url"
                                        placeholder="Enter URL (optional)" value="{{ old('url') }}">
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" name="status" value="Draft" class="btn btn-secondary">Simpan Sebagai Draft</button>
                                    <button type="submit" name="status" value="Approved" class="btn btn-primary">Simpan & Publikasikan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
