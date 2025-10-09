<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Manage Users</h2>
        <a href="<?= site_url('admin/users/create') ?>" class="btn btn-primary mb-3">Create New User</a>

        <?php if (session()->getFlashdata('message')) : ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= esc($user->username) ?></td>
                        <td><?= esc($user->getIdentity('email_password')->secret ?? 'N/A') ?></td>
                        <td><?= implode(', ', $user->getGroups()) ?></td>
                        <td><?= $user->status === 'banned' ? 'Banned' : ($user->active ? 'Active' : 'Inactive') ?></td>
                        <td><?= $user->created_at ?></td>
                        <td>
                            <a href="<?= site_url('admin/users/edit/' . $user->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <?php if ($user->id !== auth()->id()) : ?>
                            <form action="<?= site_url('admin/users/delete/' . $user->id) ?>" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>