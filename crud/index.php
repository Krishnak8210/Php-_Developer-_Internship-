<?php
include 'config.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
        <div>
            <a href="create.php" class="btn btn-success">➕ Add New Post</a>
            <a href="logout.php" class="btn btn-danger">🚪 Logout</a>
        </div>
    </div>

    <h3 class="mb-3">All Posts</h3>

    <?php if (count($posts) > 0): ?>
        <div class="row">
            <?php foreach ($posts as $post): ?>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars(substr($post['content'], 0, 100))) ?>...</p>
                            <p class="text-muted small">Posted on: <?= $post['created_at'] ?></p>
                            <a href="edit.php?id=<?= $post['id'] ?>" class="btn btn-primary btn-sm">✏️ Edit</a>
                            <a href="delete.php?id=<?= $post['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?')">🗑️ Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No posts found.</div>
    <?php endif; ?>
</div>
</body>
</html>
