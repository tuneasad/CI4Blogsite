<?= $this->extend('frontend/layout') ?>

<?= $this->section('title') ?>
<?= esc($post->title) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8">
        <!-- Post content-->
        <article>
            <!-- Post header-->
            <header class="mb-4">
                <!-- Post title-->
                <h1 class="fw-bolder mb-1"><?= esc($post->title) ?></h1>
                <!-- Post meta content-->
                <div class="text-muted fst-italic mb-2">
                    Posted on <?= date('F j, Y', strtotime($post->published_at)) ?> by <?= esc($post->author_name) ?>
                </div>
            </header>
            <!-- Preview image figure-->
            <?php if ($post->image) : ?>
                <figure class="mb-4"><img class="img-fluid rounded" src="<?= site_url('images/' . $post->image) ?>" alt="<?= esc($post->title) ?>"></figure>
            <?php endif; ?>
            <!-- Post content-->
            <section class="mb-5">
                <?= esc($post->content) ?>
            </section>
        </article>
    </div>
    <!-- Side widgets-->
    <div class="col-lg-4">
        <!-- Search widget-->
        <div class="card mb-4">
            <div class="card-header">Search</div>
            <div class="card-body">
                <form action="<?= site_url('search') ?>" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="Search for...">
                        <button class="btn btn-secondary" type="submit">Go!</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Related posts widget-->
        <?php if (!empty($related_posts)) : ?>
        <div class="card mb-4">
            <div class="card-header">Related Posts</div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <?php foreach ($related_posts as $related_post) : ?>
                        <li><a href="<?= site_url('post/' . $related_post->slug) ?>"><?= esc($related_post->title) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>