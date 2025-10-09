<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="d-flex align-items-center mb-4">
	<a href="/admin/posts" class="btn btn-outline-secondary me-3">
		<i class="fas fa-arrow-left"></i>
	</a>
	<div>
		<h1 class="h3 mb-0">
			<i class="fas fa-plus me-2 text-primary"></i>Create New Post
		</h1>
		<p class="text-muted mb-0">Write and publish a new blog post</p>
	</div>
</div>

<div class="row">
	<div class="col-lg-8">
		<div class="card shadow-sm">
			<div class="card-body">
				<?php if (session('error') || !empty($error)): ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<i class="fas fa-exclamation-circle me-2"></i><?= esc(session('error') ?? $error) ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
				<?php endif; ?>
				<form method="post" action="<?= site_url('admin/posts/create') ?>">
					<?= csrf_field() ?>
					<div class="mb-4">
						<label class="form-label fw-semibold">
							<i class="fas fa-heading me-2"></i>Post Title
						</label>
						<input name="title" class="form-control form-control-lg <?= isset($validation) && $validation->hasError('title') ? 'is-invalid' : '' ?>" 
							   value="<?= esc($form['title'] ?? old('title')) ?>" 
							   placeholder="Enter post title..." required autofocus>
						<?php if (isset($validation) && $validation->hasError('title')): ?>
							<div class="invalid-feedback">
								<?= esc($validation->getError('title')) ?>
							</div>
						<?php endif; ?>
						<div class="form-text">Choose a compelling title for your post</div>
					</div>

					<div class="mb-4">
						<label class="form-label fw-semibold">
							<i class="fas fa-link me-2"></i>URL Slug
						</label>
						<input name="slug" class="form-control <?= isset($validation) && $validation->hasError('slug') ? 'is-invalid' : '' ?>" 
							   value="<?= esc($form['slug'] ?? old('slug')) ?>" 
							   placeholder="url-friendly-slug" required>
						<?php if (isset($validation) && $validation->hasError('slug')): ?>
							<div class="invalid-feedback">
								<?= esc($validation->getError('slug')) ?>
							</div>
						<?php endif; ?>
						<div class="form-text">URL-friendly version of the title (lowercase, hyphens only)</div>
					</div>

					<div class="mb-4">
						<label class="form-label fw-semibold">
							<i class="fas fa-align-left me-2"></i>Content
						</label>
						<textarea name="content" class="form-control <?= isset($validation) && $validation->hasError('content') ? 'is-invalid' : '' ?>" rows="12" 
								  placeholder="Write your post content here..." required><?= esc($form['content'] ?? old('content')) ?></textarea>
						<?php if (isset($validation) && $validation->hasError('content')): ?>
							<div class="invalid-feedback">
								<?= esc($validation->getError('content')) ?>
							</div>
						<?php endif; ?>
						<div class="form-text">Write the main content of your blog post</div>
					</div>

					<div class="row g-3 mb-4">
						<div class="col-md-6">
							<label class="form-label fw-semibold">
								<i class="fas fa-tag me-2"></i>Status
							</label>
							<?php $sel = $form['status'] ?? old('status'); ?>
							<select name="status" class="form-select <?= isset($validation) && $validation->hasError('status') ? 'is-invalid' : '' ?>" required>
								<option value="draft" <?= $sel==='draft'?'selected':'' ?>>Draft</option>
								<option value="published" <?= $sel==='published'?'selected':'' ?>>Published</option>
							</select>
							<?php if (isset($validation) && $validation->hasError('status')): ?>
								<div class="invalid-feedback">
									<?= esc($validation->getError('status')) ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="col-md-6">
							<label class="form-label fw-semibold">
								<i class="fas fa-calendar me-2"></i>Publish Date
							</label>
							<?php 
							$val = $form['published_at'] ?? old('published_at');
							$dt = $val ? date('Y-m-d\TH:i', strtotime($val)) : '';
							?>
							<input type="datetime-local" name="published_at" class="form-control" value="<?= esc($dt) ?>">
							<div class="form-text">Leave empty for immediate publishing</div>
						</div>
					</div>

					<div class="mb-4">
						<label class="form-label fw-semibold">
							<i class="fas fa-image me-2"></i>Post Image
						</label>
						<div class="alert alert-info">
							<i class="fas fa-info-circle me-2"></i>
							<strong>Automatic Image Assignment:</strong> A random dog image will be automatically assigned to this post from the Dog CEO API when you save it.
						</div>
					</div>

					<div class="d-flex gap-2">
						<button type="submit" class="btn btn-primary btn-lg">
							<i class="fas fa-save me-2"></i>Create Post
						</button>
						<a href="/admin/posts" class="btn btn-outline-secondary btn-lg">
							<i class="fas fa-times me-2"></i>Cancel
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="col-lg-4">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h6 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Tips</h6>
			</div>
			<div class="card-body">
				<ul class="list-unstyled mb-0">
					<li class="mb-2">
						<i class="fas fa-check text-success me-2"></i>
						<strong>Title:</strong> Make it catchy and descriptive
					</li>
					<li class="mb-2">
						<i class="fas fa-check text-success me-2"></i>
						<strong>Slug:</strong> Use lowercase letters and hyphens
					</li>
					<li class="mb-2">
						<i class="fas fa-check text-success me-2"></i>
						<strong>Content:</strong> Write engaging and valuable content
					</li>
					<li class="mb-2">
						<i class="fas fa-check text-success me-2"></i>
						<strong>Status:</strong> Save as draft to preview before publishing
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>
