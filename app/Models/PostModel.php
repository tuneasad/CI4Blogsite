<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table            = 'posts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'slug',
        'content',
        'category_id',
        'image',
        'author_id',
        'status',
        'published_at',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'title'       => 'required|min_length[3]|max_length[255]',
        'content'     => 'required',
        'category_id' => 'required|integer',
        'status'      => 'required|in_list[Published,Draft]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateSlug'];
    protected $beforeUpdate   = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        if (!isset($data['data']['title'])) {
            return $data;
        }

        $slug = url_title($data['data']['title'], '-', true);
        $data['data']['slug'] = $this->getUniqueSlug($slug, $data['id'][0] ?? null);

        return $data;
    }

    private function getUniqueSlug(string $slug, int $ignoreId = null): string
    {
        $builder = $this->where('slug', $slug);
        if ($ignoreId) {
            $builder->where('id !=', $ignoreId);
        }

        $count = $builder->countAllResults();
        if ($count > 0) {
            return $slug . '-' . ($count + 1);
        }

        return $slug;
    }
}