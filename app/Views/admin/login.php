<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
	<div class="col-md-5 col-lg-4">
		<div class="card shadow">
			<div class="card-body p-5">
				<div class="text-center mb-4">
					<h2 class="h4 text-primary">Admin Login</h2>
					<p class="text-muted">Access the blog admin panel</p>
				</div>
				
				<?php if (!empty($error)): ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<i class="fas fa-exclamation-circle me-2"></i><?= esc($error) ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
				<?php endif; ?>
				
				<?php if (session('error')): ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<i class="fas fa-exclamation-circle me-2"></i><?= esc(session('error')) ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
				<?php endif; ?>
				
				<?php if (session('success')): ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<i class="fas fa-check-circle me-2"></i><?= esc(session('success')) ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
				<?php endif; ?>
				
				<form method="post" action="<?= site_url('admin/login') ?>">
					<div class="mb-3">
						<label class="form-label fw-semibold">Username</label>
						<input name="username" class="form-control form-control-lg <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>" 
							   value="<?= esc($form['username'] ?? old('username')) ?>" 
							   placeholder="Enter your username" required autofocus>
						<?php if (isset($validation) && $validation->hasError('username')): ?>
							<div class="invalid-feedback">
								<?= esc($validation->getError('username')) ?>
							</div>
						<?php endif; ?>
					</div>
					<div class="mb-4">
						<label class="form-label fw-semibold">Password</label>
						<input type="password" name="password" class="form-control form-control-lg <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
							   placeholder="Enter your password" required>
						<?php if (isset($validation) && $validation->hasError('password')): ?>
							<div class="invalid-feedback">
								<?= esc($validation->getError('password')) ?>
							</div>
						<?php endif; ?>
					</div>
					<button type="submit" class="btn btn-primary btn-lg w-100">
						<i class="fas fa-sign-in-alt me-2"></i>Login to Admin
					</button>
				</form>
				
				<div class="text-center mt-4">
					<small class="text-muted">
						Default credentials: <strong>admin</strong> / <strong>Admin@123</strong>
					</small>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>
