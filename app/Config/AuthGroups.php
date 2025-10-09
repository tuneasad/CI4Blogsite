<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * --------------------------------------------------------------------
     * Default Group
     * --------------------------------------------------------------------
     * The group that a newly registered user is added to.
     */
    public string $defaultGroup = 'Viewer';

    /**
     * --------------------------------------------------------------------
     * Groups
     * --------------------------------------------------------------------
     * An associative array of the available groups in the system, where the keys
     * are the group names and the values are arrays of the group info.
     */
    public array $groups = [
        'SuperAdmin' => [
            'title'       => 'Super Admin',
            'description' => 'Complete control of the site.',
        ],
        'Editor' => [
            'title'       => 'Editor',
            'description' => 'Can create, edit, and publish blog posts.',
        ],
        'Viewer' => [
            'title'       => 'Viewer',
            'description' => 'Can read blog posts and manage their own profile.',
        ],
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system.
     */
    public array $permissions = [
        'admin.access'        => 'Can access the admin area',
        'admin.settings'      => 'Can access the main site settings',
        'posts.create'        => 'Can create new blog posts',
        'posts.edit'          => 'Can edit existing blog posts',
        'posts.delete'        => 'Can delete existing blog posts',
        'users.manage'        => 'Can manage all users',
        'categories.manage'   => 'Can manage categories',
        'tags.manage'         => 'Can manage tags',
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions Matrix
     * --------------------------------------------------------------------
     * Maps permissions to groups.
     */
    public array $matrix = [
        'SuperAdmin' => [
            'admin.*',
            'posts.*',
            'users.*',
            'categories.*',
            'tags.*',
        ],
        'Editor' => [
            'admin.access',
            'posts.create',
            'posts.edit',
            'posts.delete',
            'categories.manage',
            'tags.manage',
        ],
        'Viewer' => [],
    ];
}