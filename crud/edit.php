<?php
include 'config.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get post by ID
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo "<div class='alert alert-danger text-center mt-5'>❌ Post not found. <a href='index.php'>Back</a></div>";
    exit;
}

// Update post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $update = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        if ($update->execute([$title, $content, $id])) {
            header("Location: index.php");
            exit;
        } else {
            $message = "<div class='alert alert-danger'>❌ Error updating post.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>❌ Title and content cannot be empty.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="mb-3">Edit Post</h3>
                    <?= $message ?? '' ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($post['title']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content" class="form-control" rows="5" required><?= htmlspecialchars($post['content']) ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">✔ Update Post</button>
                        <a href="index.php" class="btn btn-secondary">⬅ Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
