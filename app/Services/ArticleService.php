<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleService
{
    /**
     * =============================================
     *  list all articles along with filter, sort, etc
     * =============================================
     */
    public function listAllArticles($perPage, string $sortField = null, string $sortOrder = null, string $keyword = null, string $category = null, string $status = null): LengthAwarePaginator
    {
        $perPage = !is_null($perPage) ? $perPage : config('constant.CRUD.PER_PAGE');

        $query = Article::query()->with('author:id,name');

        // Apply search filter
        if (!empty($keyword)) {
            $query->search($keyword);
        }

        // Apply category filter
        if (!empty($category)) {
            $query->where('category', $category);
        }

        // Apply status filter
        if (!empty($status)) {
            $query->where('status', $status);
        }

        // Apply sorting
        $sortField = in_array($sortField, Article::getModel()->sortable) ? $sortField : 'id';
        $sortOrder = $sortOrder === 'desc' ? 'desc' : 'asc';

        $query->orderBy($sortField, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * =============================================
     * get single article data
     * =============================================
     */
    public function getArticleDetail($articleId): ?Article
    {
        return Article::with('author:id,name')->find($articleId);
    }

    /**
     * =============================================
     * Check if certain slug is exists or not
     * =============================================
     */
    public function checkArticleSlugExist(string $slug): bool
    {
        return Article::where('slug', $slug)->exists();
    }

    /**
     * =============================================
     * process add new article to database
     * =============================================
     */
    public function addNewArticle(array $validatedData)
    {
        DB::beginTransaction();
        try {
            // Set the author_id to current user
            $validatedData['author_id'] = Auth::id();

            // Generate slug if not provided
            if (empty($validatedData['slug'])) {
                $validatedData['slug'] = Str::slug($validatedData['title']);
            }

            // Set published_at if status is published
            if ($validatedData['status'] === 'published' && empty($validatedData['published_at'])) {
                $validatedData['published_at'] = now();
            }

            $article = Article::create($validatedData);

            DB::commit();
            return $article;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to save new article to database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process update article data
     * =============================================
     */
    public function updateArticle(array $validatedData, $id)
    {
        DB::beginTransaction();
        try {
            $article = Article::findOrFail($id);

            // Generate slug if not provided and title changed
            if (empty($validatedData['slug']) || $article->title !== $validatedData['title']) {
                $validatedData['slug'] = Str::slug($validatedData['title']);
            }

            // Set published_at if status is published and not set
            if ($validatedData['status'] === 'published' && empty($article->published_at)) {
                $validatedData['published_at'] = now();
            }

            $article->update($validatedData);

            DB::commit();
            return $article;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to update article in the database: {$exception->getMessage()}");
            return null;
        }
    }

    /**
     * =============================================
     * process delete article
     * =============================================
     */
    public function deleteArticle($articleId): ?bool
    {
        DB::beginTransaction();
        try {
            Article::destroy($articleId);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("Failed to delete article with id $articleId: {$exception->getMessage()}");
            return false;
        }
    }

    /**
     * =============================================
     * Search articles by keyword (title, content, excerpt)
     * =============================================
     */
    public function searchArticles(string $keyword)
    {
        return Article::search($keyword)
            ->select('id', 'title', 'category', 'status')
            ->limit(50)
            ->get();
    }

    /**
     * =============================================
     * Get articles by category
     * =============================================
     */
    public function getArticlesByCategory(string $category, int $limit = 10)
    {
        return Article::published()
            ->category($category)
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * =============================================
     * Get featured articles
     * =============================================
     */
    public function getFeaturedArticles(int $limit = 5)
    {
        return Article::published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * =============================================
     * Get recent articles
     * =============================================
     */
    public function getRecentArticles(int $limit = 10)
    {
        return Article::published()
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
