<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
	protected $table			= 'posts';
	protected $primaryKey		= 'id';
	protected $useTimestamps	= true;
	protected $allowedFields	= ['user_id', 'title', 'slug', 'content', 'status', 'published_at', 'image_url'];

	protected $validationRules = [
		'user_id' => 'required|is_natural_no_zero',
		'title'   => 'required|min_length[3]|max_length[200]',
		'slug'    => 'required|min_length[3]|max_length[200]	',
		'content' => 'required',
		'status' => 'permit_empty|in_list[draft,published]',
	];

	public function listPublic(string $sort = 'published_at', string $direction = 'desc', ?string $q = null)
	{
		$builder = $this->where('status', 'published');
		if ($q) {
			$builder = $builder->groupStart()
				->like('title', $q)
				->orLike('content', $q)
				->groupEnd();
		}
		$direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';
		$sortable = ['published_at', 'created_at', 'title'];
		$sort = in_array($sort, $sortable, true) ? $sort : 'published_at';
		return $builder->orderBy($sort, $direction);
	}

	public function getPublishedPostsForApi()
	{
		return $this->where('status', 'published')
			->orderBy('published_at', 'desc')
			->findAll();
	}
}
