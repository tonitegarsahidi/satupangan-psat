@extends('admin/template-base')

@section('page-title', 'Add New Article')


@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">


            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Add Article</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('admin.article.store') }}" enctype="multipart/form-data">
                            @csrf

                            {{-- TITLE FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="title">Title*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'title'])


                                    {{-- input form --}}
                                    <input type="text" name="title" class="form-control" id="title"
                                        placeholder="Enter article title" value="{{ old('title') }}" required>
                                </div>
                            </div>

                            {{-- SLUG FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="slug">Slug</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'slug'])

                                    {{-- input form --}}
                                    <input type="text" name="slug" class="form-control" id="slug"
                                        placeholder="URL-friendly-slug" value="{{ old('slug') }}">
                                    <div class="form-text">Leave empty to auto-generate from title</div>
                                </div>
                            </div>

                            {{-- CATEGORY FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="category">Category*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'category'])

                                    {{-- input form --}}
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="pembinaan" {{ old('category') == 'pembinaan' ? 'selected' : '' }}>Pembinaan</option>
                                        <option value="berita" {{ old('category') == 'berita' ? 'selected' : '' }}>Berita</option>
                                    </select>
                                </div>
                            </div>

                            {{-- STATUS FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="status">Status*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'status'])

                                    {{-- input form --}}
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                    </select>
                                </div>
                            </div>

                            {{-- EXCERPT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="excerpt">Excerpt</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'excerpt'])

                                    {{-- input form --}}
                                    <textarea class="form-control" id="excerpt" name="excerpt"
                                        rows="3" placeholder="Brief description of the article">{{ old('excerpt') }}</textarea>
                                    <div class="form-text">Short summary for preview (max 500 characters)</div>
                                </div>
                            </div>

                            {{-- CONTENT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="content">Content*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'content'])

                                    {{-- input form --}}
                                    <textarea class="form-control" id="content" name="content"
                                        rows="10" placeholder="Write your article content here" required>{{ old('content') }}</textarea>
                                </div>
                            </div>

                            {{-- PUBLISHED AT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="published_at">Published Date</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'published_at'])

                                    {{-- input form --}}
                                    <input type="datetime-local" class="form-control" id="published_at" name="published_at"
                                        value="{{ old('published_at') }}">
                                    <div class="form-text">Leave empty for current time when publishing</div>
                                </div>
                            </div>

                            {{-- IS FEATURED CHECKBOX --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="is_featured">Featured</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'is_featured'])

                                    {{-- input form --}}
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                                            {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Featured Article
                                        </label>
                                    </div>
                                    <div class="form-text">Featured articles appear prominently on the site</div>
                                </div>
                            </div>

                            {{-- FEATURED IMAGE FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="featured_image">Featured Image</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'featured_image'])

                                    {{-- input form --}}
                                    <input type="file" class="form-control" id="featured_image" name="featured_image"
                                        accept="image/*">
                                    <div class="form-text">JPG, PNG or GIF. Max size 2MB</div>

                                    {{-- IMAGE PREVIEW --}}
                                    <div class="mb-3" id="image-preview" style="display: none;">
                                        <label class="form-label">Image Preview</label>
                                        <div>
                                            <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('scripts')
<script>
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slugField = document.getElementById('slug');

    // Auto-generate slug if field is empty
    if (!slugField.value) {
        slugField.value = title.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
    }
});

document.getElementById('featured_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});
</script>
@endpush
