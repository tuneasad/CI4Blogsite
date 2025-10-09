<?php

namespace Tests\Feature;

use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;

class AuthControllerTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate = true;
    protected $seed = 'DatabaseSeeder';
    protected $namespace = 'App';

    public function testUnauthenticatedUserIsRedirected()
    {
        $result = $this->get('/admin/dashboard');

        $result->assertStatus(302);
        $result->assertRedirectTo(site_url('login'));
    }

    public function testSuperAdminCanAccessDashboard()
    {
        // Find the superadmin user
        $user = model(UserModel::class)->findById(1);

        $result = $this->actingAs($user)->get('/admin/dashboard');

        $result->assertStatus(200);
        $result->assertSee('Welcome to the Admin Dashboard');
    }

    public function testEditorCanAccessDashboard()
    {
        // Find the editor user
        $user = model(UserModel::class)->findById(2);

        $result = $this->actingAs($user)->get('/admin/dashboard');

        $result->assertStatus(200);
        $result->assertSee('Welcome to the Admin Dashboard');
    }

    public function testViewerCannotAccessDashboard()
    {
        // Find the viewer user
        $user = model(UserModel::class)->findById(3);

        $result = $this->actingAs($user)->get('/admin/dashboard');

        $result->assertStatus(403); // Forbidden
    }

    public function testEditorCannotAccessUserManagement()
    {
        // Find the editor user
        $user = model(UserModel::class)->findById(2);

        $result = $this->actingAs($user)->get('/admin/users');

        $result->assertStatus(403);
    }

    public function testSuperAdminCanAccessUserManagement()
    {
        // Find the superadmin user
        $user = model(UserModel::class)->findById(1);

        $result = $this->actingAs($user)->get('/admin/users');

        $result->assertStatus(200);
        $result->assertSee('Manage Users');
    }
}