<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Libraries\JobService;

class Posts extends BaseController
{
    public function index()
    {
        $postModel = new PostModel();
        $data['posts'] = $postModel->select('posts.*, categories.name as category_name')
            ->join('categories', 'categories.id = posts.category_id', 'left')
            ->findAll();

        return view('admin/posts/index', $data);
    }

    public function create()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();
        return view('admin/posts/create', $data);
    }

    public function store()
    {
        $postModel = new PostModel();
        $validationRules = [
            'title'       => 'required|min_length[3]|max_length[255]',
            'content'     => 'required',
            'category_id' => 'required|integer',
            'status'      => 'required|in_list[Published,Draft]',
        ];

        $imageUrl = $this->request->getPost('image_url');
        $imageFile = $this->request->getFile('image');

        if (empty($imageUrl) && (!$imageFile || !$imageFile->isValid())) {
            $validationRules['image'] = 'uploaded[image]';
        }
        if ($imageFile && $imageFile->isValid()) {
            $validationRules['image'] = 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]';
        }

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageName = null;
        if (!empty($imageUrl)) {
            $imageName = $this->downloadImage($imageUrl);
            if ($imageName === null) {
                return redirect()->back()->withInput()->with('errors', ['image_url' => 'Failed to download image from URL.']);
            }
        } elseif ($imageFile->isValid()) {
            $imageName = $imageFile->getRandomName();
            $imageFile->move(WRITEPATH . 'uploads/blogs', $imageName);
        }

        $data = [
            'title'        => $this->request->getPost('title'),
            'content'      => $this->request->getPost('content'),
            'category_id'  => $this->request->getPost('category_id'),
            'author_id'    => auth()->id(),
            'status'       => $this->request->getPost('status'),
            'image'        => $imageName,
            'published_at' => ($this->request->getPost('status') === 'Published') ? date('Y-m-d H:i:s') : null,
        ];

        $postModel->save($data);
        $postId = $postModel->getInsertID();
        $post = $postModel->find($postId);

        if ($post->status === 'Published') {
            $jobService = new JobService();
            // In a real app, you would loop through subscribers
            $jobService->addJob('send_email', [
                'to'      => 'subscriber@example.com', // Dummy recipient
                'subject' => 'New Post Published: ' . $post->title,
                'view'    => 'emails/new_post_notification',
                'data'    => ['post' => $post],
            ]);
        }

        return redirect()->to('/admin/posts')->with('message', 'Post created successfully.');
    }

    public function edit($id)
    {
        $postModel = new PostModel();
        $categoryModel = new CategoryModel();
        $data['post'] = $postModel->find($id);
        $data['categories'] = $categoryModel->findAll();

        return view('admin/posts/edit', $data);
    }

    public function update($id)
    {
        $postModel = new PostModel();
        $validationRules = [
            'title'       => 'required|min_length[3]|max_length[255]',
            'content'     => 'required',
            'category_id' => 'required|integer',
            'status'      => 'required|in_list[Published,Draft]',
        ];

        $imageUrl = $this->request->getPost('image_url');
        $imageFile = $this->request->getFile('image');

        if ($imageFile && $imageFile->isValid()) {
            $validationRules['image'] = 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]';
        }

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $post = $postModel->find($id);
        $oldStatus = $post->status;
        $imageName = $post->image;

        if (!empty($imageUrl)) {
            $newImageName = $this->downloadImage($imageUrl);
            if ($newImageName) {
                if ($imageName && file_exists(WRITEPATH . 'uploads/blogs/' . $imageName)) {
                    unlink(WRITEPATH . 'uploads/blogs/' . $imageName);
                }
                $imageName = $newImageName;
            }
        } elseif ($imageFile && $imageFile->isValid()) {
            $newImageName = $imageFile->getRandomName();
            $imageFile->move(WRITEPATH . 'uploads/blogs', $newImageName);
            if ($imageName && file_exists(WRITEPATH . 'uploads/blogs/' . $imageName)) {
                unlink(WRITEPATH . 'uploads/blogs/' . $imageName);
            }
            $imageName = $newImageName;
        }

        $newStatus = $this->request->getPost('status');

        $data = [
            'title'        => $this->request->getPost('title'),
            'content'      => $this->request->getPost('content'),
            'category_id'  => $this->request->getPost('category_id'),
            'status'       => $newStatus,
            'image'        => $imageName,
            'published_at' => ($newStatus === 'Published' && is_null($post->published_at)) ? date('Y-m-d H:i:s') : $post->published_at,
        ];

        $postModel->update($id, $data);

        if ($oldStatus === 'Draft' && $newStatus === 'Published') {
            $updatedPost = $postModel->find($id);
            $jobService = new JobService();
            // In a real app, you would loop through subscribers
            $jobService->addJob('send_email', [
                'to'      => 'subscriber@example.com', // Dummy recipient
                'subject' => 'New Post Published: ' . $updatedPost->title,
                'view'    => 'emails/new_post_notification',
                'data'    => ['post' => $updatedPost],
            ]);
        }

        return redirect()->to('/admin/posts')->with('message', 'Post updated successfully.');
    }

    public function delete($id)
    {
        $postModel = new PostModel();
        $post = $postModel->find($id);

        if ($post->image && file_exists(WRITEPATH . 'uploads/blogs/' . $post->image)) {
            unlink(WRITEPATH . 'uploads/blogs/' . $post->image);
        }

        $postModel->delete($id);

        return redirect()->to('/admin/posts')->with('message', 'Post deleted successfully.');
    }

    public function fetchRandomImage()
    {
        $client = \Config\Services::curlrequest();

        try {
            $response = $client->request('GET', 'https://dog.ceo/api/breeds/image/random');
            $body = json_decode($response->getBody());

            if ($response->getStatusCode() === 200 && $body->status === 'success') {
                return $this->response->setJSON(['success' => true, 'url' => $body->message]);
            }
        } catch (\Exception $e) {
            // Log the error
            log_message('error', '[ERROR] Dog API fetch failed: ' . $e->getMessage());
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to fetch random image.'])->setStatusCode(500);
    }

    private function downloadImage(string $url): ?string
    {
        $client = \Config\Services::curlrequest([
            'timeout' => 5,
        ]);

        try {
            $response = $client->get($url);
            if ($response->getStatusCode() === 200) {
                $contentType = $response->getHeaderLine('Content-Type');
                $extension = 'jpg';
                if (strpos($contentType, 'jpeg') !== false) {
                    $extension = 'jpg';
                } elseif (strpos($contentType, 'png') !== false) {
                    $extension = 'png';
                } elseif (strpos($contentType, 'gif') !== false) {
                    $extension = 'gif';
                } elseif (strpos($contentType, 'webp') !== false) {
                    $extension = 'webp';
                }
                $imageName = uniqid() . '.' . $extension;

                $path = WRITEPATH . 'uploads/blogs/' . $imageName;
                if (write_file($path, $response->getBody())) {
                    return $imageName;
                }
            }
        } catch (\Exception $e) {
            log_message('error', '[ERROR] Image download failed from URL ' . $url . ': ' . $e->getMessage());
        }

        return null;
    }
}