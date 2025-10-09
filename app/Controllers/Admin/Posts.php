<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;
use CodeIgniter\HTTP\RedirectResponse;

class Posts extends BaseController
{
	public function index()
	{
		$model = new PostModel();
		$posts = $model->orderBy('created_at', 'desc')->paginate(10);
		return view('admin/posts/index', ['posts' => $posts, 'pager' => $model->pager]);
	}

	public function create()
	{
		return view('admin/posts/create');
	}

	public function store(): RedirectResponse
	{
		$data = $this->getValidatedData();
		if ($data === null) {
			return redirect()->back()->withInput()->with('validation', $this->validator);
		}

		$model = new PostModel();
		$model->insert($data);
		return redirect()->to('/admin/posts')->with('message', 'Post created');
	}

	public function edit($id)
	{
		$model = new PostModel();
		$post = $model->find($id);
		if (!$post) {
			return redirect()->to('/admin/posts')->with('error', 'Post not found');
		}
		
		$validation = session()->getFlashdata('validation');
		
		return view('admin/posts/edit', [
			'post' => $post,
			'validation' => $validation,
			'form' => []
		]);
	}

	public function update($id): RedirectResponse
	{
		$data = $this->getValidatedData($id);
		if ($data === null) {
			return redirect()->back()->withInput()->with('validation', $this->validator);
		}

		$status = strtolower(trim($this->request->getPost('status')));
		if (in_array($status, ['draft', 'published'])) {
			$data['status'] = $status;
		}

		$data['published_at'] = $this->request->getPost('published_at') ?: null;

		$model = new PostModel();

		$model->update($id, $data);

		return redirect()
			->to('/admin/posts')
			->with('message', 'Post updated successfully!');
	}



	public function delete($id): RedirectResponse
	{
		$model = new PostModel();
		$model->delete($id);
		return redirect()->to('/admin/posts')->with('message', 'Post deleted');
	}

	public function getDogImage()
	{
		$client = \Config\Services::curlrequest();
		$response = $client->get('https://dog.ceo/api/breeds/image/random');
		
		if ($response->getStatusCode() === 200) {
			$data = json_decode($response->getBody(), true);
			if ($data['status'] === 'success') {
				return $data['message'];
			}
		}
		
		return null;
	}

	public function apiPosts()
	{
		$model = new PostModel();
		$posts = $model->getPublishedPostsForApi();
		
		if (empty($posts)) {
			return $this->response->setJSON([
				'status' => 'success',
				'message' => 'No published posts found',
				'data' => [],
				'count' => 0
			]);
		}
		
		return $this->response->setJSON([
			'status' => 'success',
			'data' => $posts,
			'count' => count($posts)
		]);
	}

	private function getValidatedData(?int $id = null): ?array
	{
		$rules = [
			'title'   => 'required|min_length[3]|max_length[200]',
			'slug'    => 'required|min_length[3]|max_length[200]' . ($id ? "|is_unique[posts.slug,id,{$id}]" : '|is_unique[posts.slug]'),
			'content' => 'required',
			'status'  => 'required|in_list[draft,published]',
			'published_at' => 'permit_empty',
		];

		if (!$this->validate($rules)) {
			return null;
		}

		$publishedAt = $this->request->getPost('published_at');
		if ($publishedAt) {
			$publishedAt = date('Y-m-d H:i:s', strtotime($publishedAt));
		}

		// Get random dog image from API
		$imageUrl = $this->getDogImage();

		return [
			'user_id' => (int) session()->get('user_id'),
			'title' => (string) $this->request->getPost('title'),
			'slug' => (string) $this->request->getPost('slug'),
			'content' => (string) $this->request->getPost('content'),
			'status' => (string) $this->request->getPost('status'),
			'published_at' => $publishedAt,
			'image_url' => $imageUrl,
		];
	}
}
