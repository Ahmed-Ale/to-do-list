<?php
// Handle editing a task in the database
if(isset($_POST["task"]) && isset($_GET["id"]) && !empty($_POST["task"])) {
    $taskId = $_GET["id"];
    $task = $_POST["task"];
    require_once("database.php");
    $sql = "UPDATE tasks SET task = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $task, $taskId);
        mysqli_stmt_execute($stmt);
    }
    mysqli_close($conn);
    header("Location: index.php");
}

// Retrieve the task for editing
if(isset($_GET["id"])) {
    $taskId = $_GET["id"];
    require_once("database.php");
    $sql = "SELECT * FROM tasks WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $taskId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $task = $row['task'];
        $taskId = $_GET['id'];
// Use $taskId to fetch the specific task from the database for editing

    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Existing head content -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css"> -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Existing form content -->
        <form action="edit.php?id=<?php echo $taskId; ?>" method="post">
            <input type="text" name="task" value="<?php echo $task; ?>">
            <button type="submit">Update Task</button>
        </form>
    </div>
</body>
</html>
