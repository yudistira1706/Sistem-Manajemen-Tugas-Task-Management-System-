<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$task_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM tasks WHERE id='$task_id' AND user_id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $task = $result->fetch_assoc();
} else {
    echo "Task not found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    $sql = "UPDATE tasks SET title='$title', description='$description', due_date='$due_date', status='$status' WHERE id='$task_id' AND user_id='$user_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Task</h1>
        <form method="post" action="">
            <input type="text" name="title" value="<?php echo $task['title']; ?>" required>
            <textarea name="description" required><?php echo $task['description']; ?></textarea>
            <input type="date" name="due_date" value="<?php echo $task['due_date']; ?>" required>
            <select name="status">
                <option value="pending" <?php if ($task['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                <option value="completed" <?php if ($task['status'] == 'completed') echo 'selected'; ?>>Completed</option>
            </select>
            <button type="submit">Update Task</button>
        </form>
    </div>
</body>
</html>
