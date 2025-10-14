@extends('admin/template-base')

@section('page-title', 'Edit Article')


@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="row">


            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Article</h5>
                        <small class="text-muted float-end">* : must be filled</small>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('admin.article.update', $article->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- TITLE FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="title">Title*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'title'])


                                    {{-- input form --}}
                                    <input type="text" name="title" class="form-control" id="title"
                                        placeholder="Enter article title" value="{{ old('title', $article->title) }}" required>
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
                                        placeholder="URL-friendly-slug" value="{{ old('slug', $article->slug) }}">
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
                                        <option value="pembinaan" {{ old('category', $article->category) == 'pembinaan' ? 'selected' : '' }}>Pembinaan</option>
                                        <option value="berita" {{ old('category', $article->category) == 'berita' ? 'selected' : '' }}>Berita</option>
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
                                        <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published</option>
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
                                        rows="3" placeholder="Brief description of the article">{{ old('excerpt', $article->excerpt) }}</textarea>
                                    <div class="form-text">Short summary for preview (max 500 characters)</div>
                                </div>
                            </div>

                            {{-- CONTENT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="content">Content*</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'content'])

                                    {{-- Quill Editor container --}}
                                    <div id="content" style="min-height: 200px;">{{ old('content', $article->content) }}</div>

                                    {{-- Hidden input to store Quill content --}}
                                    <textarea id="content-hidden" name="content" required style="display: none;"></textarea>
                                </div>
                            </div>

                            <br/>
                            <br/>
                            <br/>
                            {{-- PUBLISHED AT FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="published_at">Published Date</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'published_at'])

                                    {{-- input form --}}
                                    <input type="datetime-local" class="form-control" id="published_at" name="published_at"
                                        value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}">
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
                                            {{ old('is_featured', $article->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Featured Article
                                        </label>
                                    </div>
                                    <div class="form-text">Featured articles appear prominently on the site</div>
                                </div>
                            </div>

                            {{-- CURRENT FEATURED IMAGE --}}
                            @if($article->featured_image)
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Current Image</label>
                                    <div class="col-sm-10">
                                        <img src="{{ asset($article->featured_image) }}" alt="Current Featured Image" class="img-thumbnail" style="max-width: 200px; max-height: 200px;" />
                                        <div class="form-text">Current featured image will be replaced if you upload a new one</div>
                                    </div>
                                </div>
                            @endif

                            {{-- FEATURED IMAGE FIELD --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="featured_image">{{ $article->featured_image ? 'Replace ' : '' }}Featured Image</label>
                                <div class="col-sm-10">
                                    {{-- form validation error --}}
                                    @include('admin.components.notification.error-validation', ['field' => 'featured_image'])

                                    {{-- input form --}}
                                    <input type="file" class="form-control" id="featured_image" name="featured_image"
                                        accept="image/*">
                                    <div class="form-text">JPG, PNG or GIF. Max size 2MB</div>

                                    {{-- IMAGE PREVIEW --}}
                                    <div class="mb-3" id="image-preview" style="display: none;">
                                        <label class="form-label">New Image Preview</label>
                                        <div>
                                            <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ARTICLE STATS --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Article Statistics</label>
                                <div class="col-sm-10">
                                    <div class="border rounded p-3 bg-light">
                                        <div class="row text-sm">
                                            <div class="col-6">
                                                <strong>Views:</strong> {{ number_format($article->view_count) }}
                                            </div>
                                            <div class="col-6">
                                                <strong>Author:</strong> {{ $article->author->name ?? 'Unknown' }}
                                            </div>
                                            <div class="col-6">
                                                <strong>Created:</strong><br>
                                                {{ $article->created_at->format('d M Y H:i') }}
                                            </div>
                                            <div class="col-6">
                                                <strong>Updated:</strong><br>
                                                {{ $article->updated_at->format('d M Y H:i') }}
                                            </div>
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

// Initialize Quill Editor
document.addEventListener('DOMContentLoaded', function() {
    var quill = new Quill('#content', {
        theme: 'snow',
        placeholder: 'Write your article content here...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                ['link'],
                ['blockquote', 'code-block'],
                ['clean']
            ]
        }
    });

    // Set initial content from article data
    var articleContent = @json($article->content ?? '');
    if (articleContent) {
        quill.root.innerHTML = articleContent;
        document.getElementById('content-hidden').value = articleContent;
    }

    // Update hidden input on content change
    quill.on('text-change', function() {
        document.getElementById('content-hidden').value = quill.root.innerHTML;
    });
});
</script>
@endpush
