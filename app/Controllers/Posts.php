<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;

class Posts extends BaseController
{
    public function index()
    {
        $postModel = new PostModel();
        $data['posts'] = $postModel->select('posts.*, users.username as author_name')
            ->join('users', 'users.id = posts.author_id')
            ->where('posts.status', 'Published')
            ->orderBy('posts.published_at', 'DESC')
            ->paginate(5);
        $data['pager'] = $postModel->pager;

        return view('frontend/posts/index', $data);
    }

    public function show($slug)
    {
        $postModel = new PostModel();
        $data['post'] = $postModel->select('posts.*, users.username as author_name')
            ->join('users', 'users.id = posts.author_id')
            ->where('posts.slug', $slug)
            ->where('posts.status', 'Published')
            ->first();

        if (empty($data['post'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Post not found: ' . $slug);
        }

        // Get related posts (from the same category)
        $data['related_posts'] = $postModel->where('category_id', $data['post']->category_id)
            ->where('id !=', $data['post']->id)
            ->where('status', 'Published')
            ->orderBy('published_at', 'DESC')
            ->limit(3)
            ->findAll();

        return view('frontend/posts/show', $data);
    }

    public function category($slug)
    {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->where('slug', $slug)->first();

        if (empty($category)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Category not found: ' . $slug);
        }

        $postModel = new PostModel();
        $data['posts'] = $postModel->select('posts.*, users.username as author_name')
            ->join('users', 'users.id = posts.author_id')
            ->where('posts.category_id', $category->id)
            ->where('posts.status', 'Published')
            ->orderBy('posts.published_at', 'DESC')
            ->paginate(5);
        $data['category'] = $category;
        $data['pager'] = $postModel->pager;

        return view('frontend/posts/category', $data);
    }

    public function search()
    {
        $query = $this->request->getGet('q');

        if (empty($query)) {
            return redirect()->to('/');
        }

        $postModel = new PostModel();
        $data['posts'] = $postModel->select('posts.*, users.username as author_name')
            ->join('users', 'users.id = posts.author_id')
            ->where('posts.status', 'Published')
            ->groupStart()
                ->like('posts.title', $query)
                ->orLike('posts.content', $query)
            ->groupEnd()
            ->orderBy('posts.published_at', 'DESC')
            ->paginate(5);

        $data['query'] = $query;
        $data['pager'] = $postModel->pager;

        return view('frontend/posts/search', $data);
    }
}