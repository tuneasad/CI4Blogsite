<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Manage Categories</h2>
        <a href="<?= site_url('admin/categories/create') ?>" class="btn btn-primary mb-3">Create New Category</a>

        <?php if (session()->getFlashdata('message')) : ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category) : ?>
                    <tr>
                        <td><?= $category->id ?></td>
                        <td><?= esc($category->name) ?></td>
                        <td><?= esc($category->slug) ?></td>
                        <td><?= $category->created_at ?></td>
                        <td>
                            <a href="<?= site_url('admin/categories/edit/' . $category->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= site_url('admin/categories/delete/' . $category->id) ?>" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>