<?php
session_start();
include "config.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Welcome, <?php echo $_SESSION['user']; ?></h3>
        <div>
            <a href="create.php" class="btn btn-primary">+ New Post</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                <p class="card-text"><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                <small class="text-muted">Posted on: <?php echo $row['created_at']; ?></small><br>
                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm mt-2">Edit</a>
                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Delete this post?');">Delete</a>
            </div>
        </div>
    <?php } ?>
</div>
</body>
</html>
