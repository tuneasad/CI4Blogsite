<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
	<div>
		<h1 class="h3 mb-0">
			<i class="fas fa-cogs me-2 text-primary"></i>Manage Posts
		</h1>
		<p class="text-muted mb-0">Create, edit, and manage your blog posts</p>
	</div>
	<a href="/admin/posts/create" class="btn btn-primary">
		<i class="fas fa-plus me-2"></i>New Post
	</a>
</div>

<?php if (empty($posts)): ?>
	<div class="text-center py-5">
		<i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
		<h4 class="text-muted">No posts yet</h4>
		<p class="text-muted">Create your first blog post to get started!</p>
		<a href="/admin/posts/create" class="btn btn-primary">
			<i class="fas fa-plus me-2"></i>Create First Post
		</a>
	</div>
<?php else: ?>
	<div class="card shadow-sm">
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-hover mb-0">
					<thead class="table-light">
						<tr>
							<th class="border-0 ps-4">
								<i class="fas fa-font me-2"></i>Title
							</th>
							<th class="border-0">
								<i class="fas fa-image me-2"></i>Image
							</th>
							<th class="border-0">
								<i class="fas fa-tag me-2"></i>Status
							</th>
							<th class="border-0">
								<i class="fas fa-calendar me-2"></i>Published
							</th>
							<th class="border-0 pe-4">
								<i class="fas fa-cog me-2"></i>Actions
							</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($posts as $post): ?>
						<tr>
							<td class="ps-4">
								<div>
									<h6 class="mb-1"><?= esc($post['title']) ?></h6>
									<small class="text-muted">Slug: <?= esc($post['slug']) ?></small>
								</div>
							</td>
							<td>
								<?php if (!empty($post['image_url'])): ?>
									<img src="<?= esc($post['image_url']) ?>" alt="Post Image" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
								<?php else: ?>
									<span class="text-muted">No image</span>
								<?php endif; ?>
							</td>
							<td>
								<span class="badge bg-<?= $post['status'] === 'published' ? 'success' : 'warning' ?>">
									<i class="fas fa-<?= $post['status'] === 'published' ? 'check-circle' : 'clock' ?> me-1"></i>
									<?= ucfirst($post['status']) ?>
								</span>
							</td>
							<td>
								<?php if ($post['published_at']): ?>
									<div>
										<div><?= date('M j, Y', strtotime($post['published_at'])) ?></div>
										<small class="text-muted"><?= date('g:i A', strtotime($post['published_at'])) ?></small>
									</div>
								<?php else: ?>
									<span class="text-muted">Not published</span>
								<?php endif; ?>
							</td>
							<td class="pe-4">
								<div class="btn-group btn-group-sm" role="group">
									<a href="/admin/posts/edit/<?= esc($post['id']) ?>" 
									   class="btn btn-outline-primary" 
									   title="Edit Post">
										<i class="fas fa-edit"></i>
									</a>
									<?php if ($post['status'] === 'published'): ?>
										<a href="/post/<?= esc($post['slug']) ?>" 
										   class="btn btn-outline-info" 
										   title="View Post" 
										   target="_blank">
											<i class="fas fa-external-link-alt"></i>
										</a>
									<?php endif; ?>
									<button type="button" 
											class="btn btn-outline-danger" 
											title="Delete Post"
											onclick="confirmDelete(<?= esc($post['id']) ?>, '<?= esc($post['title']) ?>')">
										<i class="fas fa-trash"></i>
									</button>
								</div>
								
								<!-- Hidden delete form -->
								<form id="delete-form-<?= esc($post['id']) ?>" 
									  method="post" 
									  action="/admin/posts/delete/<?= esc($post['id']) ?>" 
									  style="display: none;">
								</form>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Pagination -->
	<?php if ($pager->getPageCount() > 1): ?>
		<nav aria-label="Posts pagination" class="mt-4">
			<?= $pager->links() ?>
		</nav>
	<?php endif; ?>
<?php endif; ?>

<script>
function confirmDelete(postId, postTitle) {
	if (confirm(`Are you sure you want to delete "${postTitle}"?\n\nThis action cannot be undone.`)) {
		document.getElementById('delete-form-' + postId).submit();
	}
}
</script>
<?= $this->endSection() ?>
