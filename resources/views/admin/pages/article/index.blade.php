@extends('admin/template-base')

@section('page-title', 'List of Articles')

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
                    <h3 class="card-header">List of Articles</h3>
                </div>
                <div class="p-2">
                    <a class="btn btn-primary" href="{{ route('admin.article.add') }}">
                        <span class="tf-icons bx bx-plus"></span>&nbsp;
                        Add New Article
                    </a>
                </div>

            </div>

            {{-- SECOND ROW,  FOR DISPLAY PER PAGE AND SEARCH FORM --}}
            <div class="d-flex justify-content-between">

                {{-- OPTION TO SHOW LIST PER PAGE --}}
                <div class="p-2 bd-highlight">
                    @include('admin.components.paginator.perpageform')
                </div>

                {{-- SEARCH AND FILTER FORMS --}}
                <div class="p-2 d-flex align-items-center gap-2">
                    {{-- CATEGORY FILTER --}}
                    <form action="{{ url()->full() }}" method="get" class="d-flex align-items-center">
                        <select class="form-select" name="category" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            <option value="pembinaan" {{ request('category') == 'pembinaan' ? 'selected' : '' }}>Pembinaan</option>
                            <option value="berita" {{ request('category') == 'berita' ? 'selected' : '' }}>Berita</option>
                        </select>
                        <input type="hidden" name="sort_order" value="{{ request()->input('sort_order') }}" />
                        <input type="hidden" name="sort_field" value="{{ request()->input('sort_field') }}" />
                        <input type="hidden" name="per_page" value="{{ request()->input('per_page') }}" />
                        <input type="hidden" name="status" value="{{ request()->input('status') }}" />
                    </form>

                    {{-- STATUS FILTER --}}
                    <form action="{{ url()->full() }}" method="get" class="d-flex align-items-center">
                        <select class="form-select" name="status" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        <input type="hidden" name="sort_order" value="{{ request()->input('sort_order') }}" />
                        <input type="hidden" name="sort_field" value="{{ request()->input('sort_field') }}" />
                        <input type="hidden" name="per_page" value="{{ request()->input('per_page') }}" />
                        <input type="hidden" name="category" value="{{ request()->input('category') }}" />
                    </form>

                    {{-- SEARCH FORM --}}
                    <form action="{{ url()->full() }}" method="get" class="d-flex align-items-center">
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input type="text" class="form-control border-1 shadow-none bg-light bg-gradient"
                            placeholder="Search title or content.." aria-label="Search title or content..." name="keyword"
                            value="{{ isset($keyword) ? $keyword : '' }}" />
                        <input type="hidden" name="sort_order" value="{{ request()->input('sort_order') }}" />
                        <input type="hidden" name="sort_field" value="{{ request()->input('sort_field') }}" />
                        <input type="hidden" name="per_page" value="{{ request()->input('per_page') }}" />
                        <input type="hidden" name="category" value="{{ request()->input('category') }}" />
                        <input type="hidden" name="status" value="{{ request()->input('status') }}" />
                    </form>
                </div>

            </div>

            {{-- THIRD ROW, FOR THE MAIN DATA PART --}}
            {{-- //to display any error if any --}}
            @if (isset($alerts))
                @include('admin.components.notification.general', $alerts)
            @endif

            <div class="table-responsive text-nowrap">
                <!-- Table data with Striped Rows -->
                <table class="table table-striped table-hover align-middle">

                    {{-- TABLE HEADER --}}
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.article.index', [
                                        'sort_field' => 'title',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                        'category' => $category,
                                        'status' => $status,
                                    ]) }}">
                                    Title
                                    @include('components.arrow-sort', [
                                        'field' => 'title',
                                        'sortField' => $sortField,
                                        'sortOrder' => $sortOrder,
                                    ])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.article.index', [
                                        'sort_field' => 'category',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                        'category' => $category,
                                        'status' => $status,
                                    ]) }}">
                                    Category
                                    @include('components.arrow-sort', ['field' => 'category', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.article.index', [
                                        'sort_field' => 'status',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                        'category' => $category,
                                        'status' => $status,
                                    ]) }}">
                                    Status
                                    @include('components.arrow-sort', ['field' => 'status', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ route('admin.article.index', [
                                        'sort_field' => 'published_at',
                                        'sort_order' => $sortOrder == 'asc' ? 'desc' : 'asc',
                                        'keyword' => $keyword,
                                        'category' => $category,
                                        'status' => $status,
                                    ]) }}">
                                    Published Date
                                    @include('components.arrow-sort', ['field' => 'published_at', 'sortField' => $sortField, 'sortOrder' => $sortOrder])
                                </a>
                            </th>
                            <th>Author</th>
                            <th>Views</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $startNumber = $perPage * ($page - 1) + 1;
                        @endphp
                        @foreach ($articles as $article)
                            <tr>
                                <td>{{ $startNumber++ }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($article->featured_image)
                                            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Featured Image" class="rounded" width="40" height="40" style="object-fit: cover; margin-right: 10px;">
                                        @endif
                                        <div>
                                            <strong>{{ Str::limit($article->title, 50) }}</strong>
                                            @if($article->is_featured)
                                                <span class="badge bg-warning ms-1">Featured</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $article->category == 'pembinaan' ? 'info' : 'success' }}">
                                        {{ ucfirst($article->category) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($article->status == 'published')
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>{{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</td>
                                <td>{{ $article->author->name ?? 'Unknown' }}</td>
                                <td>{{ number_format($article->view_count) }}</td>

                                {{-- ============ CRUD LINK ICON =============  --}}
                                <td>
                                    <a class="action-icon" href="{{ route('admin.article.detail', ['id' => $article->id]) }}"
                                        title="detail">
                                        <i class='bx bx-search'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.article.edit', ['id' => $article->id]) }}"
                                        title="edit">
                                        <i class='bx bx-pencil'></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="action-icon" href="{{ route('admin.article.delete', ['id' => $article->id]) }}"
                                        title="delete">
                                        <i class='bx bx-trash'></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
                <br />

                <div class="row">
                    <div class="col-md-10 mx-auto">
                        {{ $articles->onEachSide(5)->links('admin.components.paginator.default') }}
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
