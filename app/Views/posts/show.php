<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
	<div class="col-lg-8">
		<article class="card shadow-sm border-0 rounded-4 overflow-hidden">
	<!-- Post Image -->
	<?php if (!empty($post['image_url'])): ?>
		<img src="<?= esc($post['image_url']) ?>" 
			 alt="<?= esc($post['title']) ?>" 
			 class="card-img-top img-fluid" 
			 style="max-height:350px; object-fit:cover;">
	<?php else: ?>
		<div class="bg-light d-flex justify-content-center align-items-center" style="height:350px;">
			<svg width="80" height="80" fill="#adb5bd" viewBox="0 0 16 16">
				<path d="M4.502 9a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
				<path d="M14 14H2V2h12v12zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2z"/>
			</svg>
			<span class="text-muted ms-2">No image available</span>
		</div>
	<?php endif; ?>

	<div class="card-body p-4">
		<!-- Breadcrumb -->
		<nav aria-label="breadcrumb" class="mb-4">
			<ol class="breadcrumb bg-transparent p-0 mb-0">
				<li class="breadcrumb-item"><a href="/" class="text-decoration-none text-primary">Home</a></li>
				<li class="breadcrumb-item"><a href="/posts" class="text-decoration-none text-primary">Posts</a></li>
				<li class="breadcrumb-item active text-dark fw-semibold" aria-current="page"><?= esc($post['title']) ?></li>
			</ol>
		</nav>

		<!-- Post Header -->
		<header class="mb-4">
			<h1 class="display-6 fw-bold text-dark"><?= esc($post['title']) ?></h1>
			<div class="d-flex align-items-center text-muted small">
				<i class="fas fa-calendar-alt me-2"></i><?= date('F j, Y', strtotime($post['published_at'])) ?>
				<span class="mx-2">|</span>
				<i class="fas fa-clock me-2"></i><?= date('g:i A', strtotime($post['published_at'])) ?>
			</div>
		</header>

		<!-- Post Content -->
		<div class="post-content fs-6 lh-base text-secondary">
			<?= nl2br(esc($post['content'])) ?>
		</div>

		<!-- Post Footer -->
		<footer class="mt-5 pt-4 border-top">
			<a href="/posts" class="btn btn-outline-secondary rounded-pill px-4">
				<i class="fas fa-arrow-left me-2"></i>Back to Posts
			</a>
		</footer>
	</div>
</article>

	</div>
	
	<!-- Sidebar -->
	<div class="col-lg-4">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Post Information</h5>
			</div>
			<div class="card-body">
				<div class="mb-3">
					<strong>Published:</strong><br>
					<?= date('F j, Y \a\t g:i A', strtotime($post['published_at'])) ?>
				</div>
				<div class="mb-3">
					<strong>Status:</strong><br>
					<span class="badge bg-success"><?= ucfirst($post['status']) ?></span>
				</div>
				<?php if (!session()->get('user_id')): ?>
					<div class="mt-4">
						<a href="/admin/login" class="btn btn-primary btn-sm">
							<i class="fas fa-sign-in-alt me-1"></i>Admin Login
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
		
		<div class="card mt-3">
			<div class="card-header">
				<h6 class="mb-0"><i class="fas fa-share-alt me-2"></i>Share This Post</h6>
			</div>
			<div class="card-body">
				<p class="text-muted small">Share this post with your friends and colleagues!</p>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>
