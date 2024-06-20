<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM tasks WHERE user_id='$user_id'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <div class="header-links">
            <a href="add_task.php">Add New Task</a>
            <a href="logout.php">Logout</a>
        </div>
        <ul class="task-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='task-item'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>" . $row['description'] . "</p>";
                    echo "<p>Due Date: " . $row['due_date'] . "</p>";
                    echo "<p>Status: " . $row['status'] . "</p>";
                    echo "<div class='task-actions'>";
                    echo "<a class='edit' href='edit_task.php?id=" . $row['id'] . "'>Edit</a>";
                    echo "<a class='delete' href='delete_task.php?id=" . $row['id'] . "'>Delete</a>";
                    echo "</div>";
                    echo "</li>";
                }
            } else {
                echo "<p>No tasks found.</p>";
            }
            ?>
        </ul>
    </div>
</body>
</html>
