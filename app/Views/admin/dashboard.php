<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
	<h1 class="h3 mb-0"><i class="fas fa-tachometer-alt me-2 text-primary"></i>Admin Dashboard</h1>
	<a href="/admin/posts" class="btn btn-primary"><i class="fas fa-newspaper me-2"></i>Manage Posts</a>
</div>

<div class="row g-3">
	<div class="col-md-4">
		<div class="card shadow-sm">
			<div class="card-body">
				<h5 class="card-title mb-2">Welcome, <?= esc(session('username')) ?></h5>
				<p class="text-muted mb-0">Use the navigation to manage your blog posts.</p>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>
