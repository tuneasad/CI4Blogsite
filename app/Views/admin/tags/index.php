<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tags</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Manage Tags</h2>
        <a href="<?= site_url('admin/tags/create') ?>" class="btn btn-primary mb-3">Create New Tag</a>

        <?php if (session()->getFlashdata('message')) : ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tags as $tag) : ?>
                    <tr>
                        <td><?= $tag->id ?></td>
                        <td><?= esc($tag->name) ?></td>
                        <td><?= esc($tag->slug) ?></td>
                        <td>
                            <a href="<?= site_url('admin/tags/edit/' . $tag->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= site_url('admin/tags/delete/' . $tag->id) ?>" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this tag?');">
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