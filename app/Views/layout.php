<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= esc($title ?? 'CI4 Blog') ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
	<style>
		body { background-color: #f8f9fa; }
		.navbar-brand { font-weight: 600; }
		.card { border: none; border-radius: 12px; }
		.btn { border-radius: 8px; font-weight: 500; }
		.form-control, .form-select { border-radius: 8px; border: 1px solid #dee2e6; }
		.form-control:focus, .form-select:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25); }
		.alert { border-radius: 8px; border: none; }
		.table { border-radius: 8px; overflow: hidden; }
		.pagination { justify-content: center; }
		.page-link { border-radius: 6px; margin: 0 2px; }
		.badge { font-size: 0.75em; }
	</style>
</head>
<body>
	<?php
		$uri = service('uri');
		$isHome = $uri->getPath() === '';
	?>

	<?php if (!$isHome): ?>
		<!-- Home Navbar -->
		<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
			<div class="container">
				<a class="navbar-brand text-primary fw-semibold" href="/">
					<i class="fas fa-home me-2"></i>Home
				</a>
				<div class="ms-auto">
					<a href="#" class="btn btn-outline-primary btn-sm me-2">
						<i class="fas fa-info-circle me-1"></i>About
					</a>
					<a href="#" class="btn btn-outline-primary btn-sm me-2">
						<i class="fas fa-newspaper me-1"></i>Services
					</a>
					<a href="#" class="btn btn-outline-primary btn-sm">
						<i class="fas fa-envelope me-1"></i>Contact
					</a>
				</div>
			</div>
		</nav>
	<?php else: ?>

		<!-- Admin Navbar -->
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
			<div class="container">
				<a class="navbar-brand" href="/">
					<i class="fas fa-blog me-2"></i>CI4 Blog
				</a>
				<div class="ms-auto">
					<?php if (session()->get('user_id')): ?>
						<span class="navbar-text me-3">
							<i class="fas fa-user me-1"></i>Welcome, <?= esc(session()->get('username')) ?>
						</span>
						<a href="/admin/posts" class="btn btn-outline-light btn-sm me-2">
							<i class="fas fa-cog me-1"></i>Admin Panel
						</a>
						<a href="/admin/logout" class="btn btn-outline-light btn-sm">
							<i class="fas fa-sign-out-alt me-1"></i>Logout
						</a>
					<?php endif; ?>
				</div>
			</div>
		</nav>
	<?php endif; ?>

	<main class="container">
		<?php if (session('success')): ?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<i class="fas fa-check-circle me-2"></i><?= esc(session('success')) ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
			</div>
		<?php endif; ?>
		
		<?php if (session('error')): ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<i class="fas fa-exclamation-circle me-2"></i><?= esc(session('error')) ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
			</div>
		<?php endif; ?>
		
		<?= $this->renderSection('content') ?>
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
