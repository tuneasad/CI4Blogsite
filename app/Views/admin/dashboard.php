<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('logout') ?>">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="<?= site_url('admin/dashboard') ?>" class="list-group-item list-group-item-action active" aria-current="true">Dashboard</a>
                    <a href="<?= site_url('admin/posts') ?>" class="list-group-item list-group-item-action">Posts</a>
                    <a href="<?= site_url('admin/categories') ?>" class="list-group-item list-group-item-action">Categories</a>
                    <a href="<?= site_url('admin/tags') ?>" class="list-group-item list-group-item-action">Tags</a>
                    <a href="<?= site_url('admin/users') ?>" class="list-group-item list-group-item-action">Users</a>
                </div>
            </div>
            <div class="col-md-9">
                <h1>Welcome to the Admin Dashboard</h1>
                <p>This is a placeholder for the main dashboard content, which will include post statistics and recent activity.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>