<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
	<div class="col-lg-12">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<h1 class="h3 mb-0">
				<i class="fas fa-newspaper me-2 text-primary"></i>Latest Blog Posts
			</h1>
			<!-- <?php if (session()->get('user_id')): ?>
				<a href="/admin/posts/create" class="btn btn-primary">
					<i class="fas fa-plus me-1"></i>New Post
				</a>
			<?php endif; ?> -->
		</div>

		<!-- Search and Filter -->
		<div class="card mb-4">
			<div class="card-body">
				<form method="get" class="row g-3">
					<div class="col-md-4">
						<div class="input-group">
							<span class="input-group-text"><i class="fas fa-search"></i></span>
							<input name="q" class="form-control" placeholder="Search posts..." value="<?= esc($q) ?>">
						</div>
					</div>
					<div class="col-md-3">
						<select name="sort" class="form-select">
							<option value="published_at" <?= $sort==='published_at'?'selected':'' ?>>
								<i class="fas fa-calendar"></i> Published Date
							</option>
							<option value="created_at" <?= $sort==='created_at'?'selected':'' ?>>
								<i class="fas fa-clock"></i> Created Date
							</option>
							<option value="title" <?= $sort==='title'?'selected':'' ?>>
								<i class="fas fa-font"></i> Title
							</option>
						</select>
					</div>
					<div class="col-md-3">
						<select name="direction" class="form-select">
							<option value="desc" <?= $direction==='desc'?'selected':'' ?>>
								<i class="fas fa-sort-down"></i> Newest First
							</option>
							<option value="asc" <?= $direction==='asc'?'selected':'' ?>>
								<i class="fas fa-sort-up"></i> Oldest First
							</option>
						</select>
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-outline-primary w-100">
							<i class="fas fa-filter me-1"></i>Filter
						</button>
					</div>
				</form>
			</div>
		</div>

		<!-- Posts List -->
		<?php if (empty($posts)): ?>
			<div class="text-center py-5">
				<i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
				<h4 class="text-muted">No posts found</h4>
				<p class="text-muted">Try adjusting your search criteria or check back later for new content.</p>
			</div>
		<?php endif; ?>

		<div class="album py-5 bg-light">
			<div class="container">
				<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
					<?php foreach ($posts as $post): ?>
						<div class="col">
							<div class="card shadow-sm h-100">

								<?php if (!empty($post['image_url'])): ?>
									<img src="<?= esc($post['image_url']) ?>" alt="<?= esc($post['title']) ?>" class="card-img-top" style="height:225px; object-fit:cover;">
								<?php else: ?>
									<svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="No image" preserveAspectRatio="xMidYMid slice" focusable="false">
										<title>No image</title>
										<rect width="100%" height="100%" fill="#e9ecef"></rect>
										<text x="50%" y="50%" fill="#6c757d" dy=".3em" text-anchor="middle">No image</text>
									</svg>
								<?php endif; ?>

								<div class="card-body d-flex flex-column">
									<h5 class="card-title mb-2">
										<a href="/post/<?= esc($post['slug']) ?>" class="text-decoration-none text-dark"><?= esc($post['title']) ?></a>
									</h5>
									<p class="card-text text-muted mb-3">
										<?= esc(strlen($post['content']) > 120 ? substr($post['content'], 0, 120) . '...' : $post['content']) ?>
									</p>

									<div class="mt-auto d-flex justify-content-between align-items-center">
										<a href="/post/<?= esc($post['slug']) ?>" class="btn btn-sm btn-outline-primary">
											<i class="fas fa-arrow-right me-1"></i> Read
										</a>
										<small class="text-muted"><?= date('M j, Y', strtotime($post['published_at'])) ?></small>
									</div>
								</div>

							</div>
						</div>
					<?php endforeach; ?>

				</div>
			</div>
		</div>

		<!-- Pagination -->
		<?php if ($pager->getPageCount() > 1): ?>
			<nav aria-label="Posts pagination" class="mt-4">
				<?= $pager->links() ?>
			</nav>
		<?php endif; ?>
	</div>
	
	<!-- Sidebar -->
	<!-- <div class="col-lg-4">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>About This Blog</h5>
			</div>
			<div class="card-body">
				<p class="card-text">Welcome to our CodeIgniter 4 blog! Here you'll find the latest posts and updates.</p>
				<?php if (!session()->get('user_id')): ?>
					<a href="/admin/login" class="btn btn-primary btn-sm">
						<i class="fas fa-sign-in-alt me-1"></i>Admin Login
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div> -->
</div>

<?= $this->endSection() ?>
