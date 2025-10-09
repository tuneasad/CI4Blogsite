<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Create New Post</h2>

        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('admin/posts/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= old('title') ?>" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?= old('content') ?></textarea>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category->id ?>"><?= esc($category->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Published">Published</option>
                    <option value="Draft" selected>Draft</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Featured Image</label>
                <div class="input-group">
                    <input type="file" class="form-control" id="image" name="image">
                    <button class="btn btn-outline-secondary" type="button" id="fetch-random-image">Fetch Random Image</button>
                </div>
                <input type="hidden" name="image_url" id="image_url">
                <div id="image-preview" class="mt-2"></div>
            </div>

            <button type="submit" class="btn btn-primary">Create Post</button>
            <a href="<?= site_url('admin/posts') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('fetch-random-image').addEventListener('click', function() {
            fetch('<?= site_url('admin/posts/fetch-random-image') ?>')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('image_url').value = data.url;
                        let preview = document.getElementById('image-preview');
                        preview.innerHTML = `<img src="${data.url}" class="img-fluid" style="max-height: 200px;">`;
                        document.getElementById('image').value = ''; // Clear file input
                    } else {
                        alert(data.message || 'Failed to fetch image.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching random image:', error);
                    alert('An error occurred while fetching the image.');
                });
        });
    </script>
</body>
</html>