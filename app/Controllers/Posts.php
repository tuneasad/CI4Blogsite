<?php

namespace App\Controllers;

use App\Models\PostModel;
use CodeIgniter\Controller;

class Posts extends Controller
{
	public function index()
	{
		$sort = (string) $this->request->getGet('sort');
		$direction = (string) $this->request->getGet('direction');
		$q = (string) $this->request->getGet('q');

		$model = new PostModel();
		$builder = $model->listPublic($sort ?: 'published_at', $direction ?: 'desc', $q ?: null);
		$posts = $builder->paginate(10);

		return view('posts/index', [
			'posts' => $posts,
			'pager' => $model->pager,
			'sort' => $sort,
			'direction' => $direction,
			'q' => $q,
		]);
	}

	public function show($slug)
	{
		$model = new PostModel();
		$post = $model->where('slug', $slug)->where('status', 'published')->first();
		if (!$post) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
		return view('posts/show', ['post' => $post]);
	}
}
