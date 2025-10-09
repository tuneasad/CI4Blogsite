<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Manage Posts</h2>
        <a href="<?= site_url('admin/posts/create') ?>" class="btn btn-primary mb-3">Create New Post</a>

        <?php if (session()->getFlashdata('message')) : ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post) : ?>
                    <tr>
                        <td><?= $post->id ?></td>
                        <td><?= esc($post->title) ?></td>
                        <td><?= esc($post->category_name) ?></td>
                        <td><?= esc($post->status) ?></td>
                        <td><?= $post->created_at ?></td>
                        <td>
                            <a href="<?= site_url('admin/posts/edit/' . $post->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?= site_url('admin/posts/delete/' . $post->id) ?>" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
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