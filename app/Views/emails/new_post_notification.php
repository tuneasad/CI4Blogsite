<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Post Published</title>
</head>
<body>
    <h1>A new post has been published!</h1>
    <p>Hi there,</p>
    <p>A new blog post titled "<?= esc($post->title) ?>" has just been published on our blog. We thought you might be interested in reading it.</p>
    <p>You can view the new post here: <a href="<?= site_url('post/' . $post->slug) ?>">Read More</a></p>
    <p>Thanks,</p>
    <p>The CI4 Blog Team</p>
</body>
</html>