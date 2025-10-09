<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PostModel;

class Posts extends ResourceController
{
    protected $modelName = 'App\Models\PostModel';
    protected $format    = 'json';

    /**
     * List all published posts
     */
    public function index()
    {
        $posts = $this->model->where('status', 'Published')
                             ->orderBy('published_at', 'DESC')
                             ->findAll();
        return $this->respond($posts);
    }

    /**
     * Get a single post by ID
     */
    public function show($id = null)
    {
        $post = $this->model->where('id', $id)->where('status', 'Published')->first();
        if ($post) {
            return $this->respond($post);
        }
        return $this->failNotFound('Post not found');
    }

    /**
     * Create a new post
     */
    public function create()
    {
        $rules = [
            'title'       => 'required',
            'content'     => 'required',
            'category_id' => 'required|integer',
            'image_base64' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $imageName = null;
        if ($this->request->getVar('image_base64')) {
            $base64Image = $this->request->getVar('image_base64');
            $imageName = $this->saveBase64Image($base64Image);
            if ($imageName === false) {
                return $this->fail('Invalid base64 image data.');
            }
        }

        $data = [
            'title'       => $this->request->getVar('title'),
            'content'     => $this->request->getVar('content'),
            'category_id' => $this->request->getVar('category_id'),
            'author_id'   => auth()->id(),
            'status'      => $this->request->getVar('status') ?? 'Draft',
            'image'       => $imageName,
            'published_at' => ($this->request->getVar('status') === 'Published') ? date('Y-m-d H:i:s') : null,
        ];

        $postId = $this->model->insert($data);

        if ($this->model->errors()) {
            return $this->fail($this->model->errors());
        }

        $post = $this->model->find($postId);

        return $this->respondCreated($post, 'Post created successfully');
    }

    /**
     * Update a post
     */
    public function update($id = null)
    {
        $post = $this->model->find($id);
        if (!$post) {
            return $this->failNotFound('Post not found');
        }

        $rules = [
            'title'       => 'required',
            'content'     => 'required',
            'category_id' => 'required|integer',
            'image_base64' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $imageName = $post->image;
        if ($this->request->getVar('image_base64')) {
            $base64Image = $this->request->getVar('image_base64');
            $newImageName = $this->saveBase64Image($base64Image);
            if ($newImageName === false) {
                return $this->fail('Invalid base64 image data.');
            }
            // Delete old image if it exists
            if ($imageName && file_exists(WRITEPATH . 'uploads/blogs/' . $imageName)) {
                unlink(WRITEPATH . 'uploads/blogs/' . $imageName);
            }
            $imageName = $newImageName;
        }

        $data = [
            'title'       => $this->request->getVar('title'),
            'content'     => $this->request->getVar('content'),
            'category_id' => $this->request->getVar('category_id'),
            'status'      => $this->request->getVar('status') ?? $post->status,
            'image'       => $imageName,
        ];

        $this->model->update($id, $data);

        $updatedPost = $this->model->find($id);

        return $this->respond($updatedPost, 200, 'Post updated successfully');
    }

    /**
     * Delete a post
     */
    public function delete($id = null)
    {
        $post = $this->model->find($id);
        if ($post) {
            // Delete image file
            if ($post->image && file_exists(WRITEPATH . 'uploads/blogs/' . $post->image)) {
                unlink(WRITEPATH . 'uploads/blogs/' . $post->image);
            }
            $this->model->delete($id);
            return $this->respondDeleted(['id' => $id], 'Post deleted successfully');
        }
        return $this->failNotFound('Post not found');
    }

    /**
     * Saves a base64 encoded image to the uploads directory.
     * @return string|false The name of the saved file or false on failure.
     */
    private function saveBase64Image(string $base64Image)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png', 'webp'])) {
                return false;
            }

            $image_data = base64_decode($base64Image);

            if ($image_data === false) {
                return false;
            }

            $imageName = uniqid() . '.' . $type;
            $uploadPath = WRITEPATH . 'uploads/blogs/' . $imageName;

            file_put_contents($uploadPath, $image_data);

            return $imageName;
        }

        return false;
    }
}