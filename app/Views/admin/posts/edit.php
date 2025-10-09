<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Post</h2>

        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('admin/posts/update/' . $post->id) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= old('title', $post->title) ?>" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?= old('content', $post->content) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category->id ?>" <?= ($category->id == old('category_id', $post->category_id)) ? 'selected' : '' ?>>
                            <?= esc($category->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Published" <?= (old('status', $post->status) === 'Published') ? 'selected' : '' ?>>Published</option>
                    <option value="Draft" <?= (old('status', $post->status) === 'Draft') ? 'selected' : '' ?>>Draft</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Featured Image</label>
                <div class="input-group">
                    <input type="file" class="form-control" id="image" name="image">
                    <button class="btn btn-outline-secondary" type="button" id="fetch-random-image">Fetch Random Image</button>
                </div>
                <input type="hidden" name="image_url" id="image_url">
                <div id="image-preview" class="mt-2">
                    <?php if ($post->image) : ?>
                        <img src="<?= site_url('images/' . $post->image) ?>" alt="<?= esc($post->title) ?>" class="img-fluid" style="max-height: 200px;">
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Post</button>
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