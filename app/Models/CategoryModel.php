<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'slug'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'name' => 'required|min_length[3]|max_length[255]|is_unique[categories.name,id,{id}]',
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
        if (!isset($data['data']['name'])) {
            return $data;
        }

        $slug = url_title($data['data']['name'], '-', true);
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