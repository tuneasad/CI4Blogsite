<?= $this->extend('frontend/layout') ?>

<?= $this->section('title') ?>
Blog
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <h1>All Blog Posts</h1>

        <?php foreach ($posts as $post) : ?>
            <div class="card mb-4">
                <?php if ($post->image) : ?>
                    <img src="<?= site_url('images/' . $post->image) ?>" class="card-img-top" alt="<?= esc($post->title) ?>">
                <?php endif; ?>
                <div class="card-body">
                    <h2 class="card-title"><?= esc($post->title) ?></h2>
                    <p class="card-text"><?= word_limiter(esc($post->content), 50) ?></p>
                    <a href="<?= site_url('post/' . $post->slug) ?>" class="btn btn-primary">Read More &rarr;</a>
                </div>
                <div class="card-footer text-muted">
                    Posted on <?= date('F j, Y', strtotime($post->published_at)) ?> by
                    <?= esc($post->author_name) ?>
                </div>
            </div>
        <?php endforeach; ?>

        <?= $pager->links() ?>

    </div>
    <div class="col-md-4">
        <!-- Sidebar Widgets -->
        <div class="card my-4">
            <h5 class="card-header">Search</h5>
            <div class="card-body">
                <form action="<?= site_url('search') ?>" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="Search for...">
                        <button class="btn btn-secondary" type="submit">Go!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>