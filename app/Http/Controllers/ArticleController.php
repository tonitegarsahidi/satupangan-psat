<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleAddRequest;
use App\Http\Requests\ArticleEditRequest;
use App\Http\Requests\ArticleListRequest;
use App\Services\ArticleService;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;

    /**
     * ################################################
     *      THIS IS ARTICLE CONTROLLER
     *  the main purpose of this class is to show functionality
     *  for ULTIMATE CRUD concept in this SamBoilerplate
     *  I use this Article model since it real need
     *  modify as you wish.
     *
     *   ULTIMATE CRUD CONCEPT
     *  - List, search/filter, sort, paging
     *  - See Detail
     *  - Add - Process Add
     *  - Edit - Process Edit
     *  - Delete confirm - Process Delete
     * ################################################
     */
class ArticleController extends Controller
{
    private $articleService;
    private $imageUploadService;
    private $mainBreadcrumbs;

    public function __construct(ArticleService $articleService, ImageUploadService $imageUploadService)
    {
        $this->articleService = $articleService;
        $this->imageUploadService = $imageUploadService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Admin' => route('admin.dashboard'),
            'Article Management' => route('admin.article.index'),
        ];
    }

    // ============================ START OF ULTIMATE CRUD FUNCTIONALITY ===============================



    /**
     * =============================================
     *      list all search and filter/sort things
     * =============================================
     */
    public function index(ArticleListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'id'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'asc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');
        $category = $request->input('category');
        $status = $request->input('status');

        $articles = $this->articleService->listAllArticles($perPage, $sortField, $sortOrder, $keyword, $category, $status);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.article.index', compact('articles', 'breadcrumbs', 'sortField', 'sortOrder', 'perPage', 'page', 'keyword', 'category', 'status', 'alerts'));
    }

    /**
     * =============================================
     *      display "add new article" pages
     * =============================================
     */
    public function create(Request $request)
    {
        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Add' => null]);

        return view('admin.pages.article.add', compact('breadcrumbs'));
    }

    /**
     * =============================================
     *      proses "add new article" from previous form
     * =============================================
     */
    public function store(ArticleAddRequest $request)
    {
        try {
            $validatedData = $request->except(['featured_image']);

            // Handle featured_image upload using ImageUploadService
            if ($request->hasFile('featured_image')) {
                $path = $this->imageUploadService->uploadImage($request->file('featured_image'), "article");
                $validatedData['featured_image'] = $path;
            }

            $result = $this->articleService->addNewArticle($validatedData);

            $alert = $result
                ? AlertHelper::createAlert('success', 'Data ' . $result->title . ' successfully added')
                : AlertHelper::createAlert('danger', 'Data ' . $request->title . ' failed to be added');

        } catch (\Exception $e) {
            // Handle any exceptions (e.g. upload errors)
            $alert = AlertHelper::createAlert('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->route('admin.article.index')->with([
            'alerts'        => [$alert],
            'sort_order'    => 'desc'
        ]);
    }

    /**
     * =============================================
     *      see the detail of single article entity
     * =============================================
     */
    public function detail(Request $request)
    {
        $data = $this->articleService->getArticleDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.article.detail', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *     display "edit article" pages
     * =============================================
     */
    public function edit(Request $request, $id)
    {
        $article = $this->articleService->getArticleDetail($id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Edit' => null]);

        return view('admin.pages.article.edit', compact('breadcrumbs', 'article'));
    }

    /**
     * =============================================
     *      process "edit article" from previous form
     * =============================================
     */
    public function update(ArticleEditRequest $request, $id)
    {
        try {
            // Get existing article data first
            $existingArticle = $this->articleService->getArticleDetail($id);

            $validatedData = $request->except(['featured_image']);

            // Handle featured_image upload using ImageUploadService
            if ($request->hasFile('featured_image')) {
                // Delete old featured image if exists
                if ($existingArticle->featured_image) {
                    try {
                        $this->imageUploadService->deleteImage($existingArticle->featured_image);
                    } catch (\Exception $e) {
                        // Log error but don't stop the update process
                        Log::warning('Failed to delete old featured image: ' . $e->getMessage());
                    }
                }

                // Upload new image
                $path = $this->imageUploadService->uploadImage($request->file('featured_image'), "article");
                $validatedData['featured_image'] = $path;
            } else {
                // Keep existing featured_image if no new file is uploaded
                $validatedData['featured_image'] = $existingArticle->featured_image;
            }

            $result = $this->articleService->updateArticle($validatedData, $id);

            $alert = $result
                ? AlertHelper::createAlert('success', 'Data ' . $result->title . ' successfully updated')
                : AlertHelper::createAlert('danger', 'Data ' . $request->title . ' failed to be updated');

        } catch (\Exception $e) {
            // Handle any exceptions (e.g. upload errors)
            $alert = AlertHelper::createAlert('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->route('admin.article.index')->with([
            'alerts' => [$alert],
            'sort_field' => 'updated_at',
            'sort_order' => 'desc'
        ]);
    }

    /**
     * =============================================
     *    show delete confirmation for article
     *    while showing the details to make sure
     *    it is correct data which they want to delete
     * =============================================
     */
    public function deleteConfirm(ArticleListRequest $request)
    {
        $data = $this->articleService->getArticleDetail($request->id);

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Delete' => null]);

        return view('admin.pages.article.delete-confirm', compact('breadcrumbs', 'data'));
    }

    /**
     * =============================================
     *      process delete data
     * =============================================
     */
    public function destroy(ArticleListRequest $request)
    {
        $article = $this->articleService->getArticleDetail($request->id);
        if (!is_null($article)) {
            $result = $this->articleService->deleteArticle($request->id);
        } else {
            $result = false;
        }

        $alert = $result
            ? AlertHelper::createAlert('success', 'Data ' . $article->title . ' successfully deleted')
            : AlertHelper::createAlert('danger', 'Oops! failed to be deleted');

        return redirect()->route('admin.article.index')->with('alerts', [$alert]);
    }

    /**
     * =============================================
     *      Search articles for Select2
     * =============================================
     */
    public function search(Request $request)
    {
        $search = $request->input('q');
        // Ensure only necessary fields are selected for the AJAX response
        $articles = $this->articleService->searchArticles($search)->map(function($article) {
            return (object)['id' => $article->id, 'title' => $article->title, 'category' => $article->category];
        });

        $formattedArticles = $articles->map(function ($article) {
            return ['id' => $article->id, 'text' => $article->title . ' (' . ucfirst($article->category) . ')'];
        });

        return response()->json($formattedArticles);
    }


    // ============================ END OF ULTIMATE CRUD FUNCTIONALITY ===============================
    /**
     * =============================================
     *      Handle sample pages
     *      which can only be accessed
     *      by this role user
     * =============================================
     */
    public function articleOnlyPage(Request $request)
    {
        return view('admin.pages.article.articleonlypage', ['message' => 'Hello Article, Thanks for using our products']);
    }
}
