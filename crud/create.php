<?php
include 'config.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        if ($stmt->execute([$title, $content])) {
            header("Location: index.php");
            exit;
        } else {
            $message = "<div class='alert alert-danger'>❌ Error adding post.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>❌ Title and content are required.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="mb-3">Add New Post</h3>
                    <?= $message ?? '' ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter post title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content" class="form-control" rows="5" placeholder="Enter post content" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">➕ Add Post</button>
                        <a href="index.php" class="btn btn-secondary">⬅ Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
