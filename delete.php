<?php
// Handle deleting a task from the database
if(isset($_GET["id"])) {
    $taskId = $_GET["id"];
    require_once("database.php");
    $sql = "DELETE FROM tasks WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $taskId);
        mysqli_stmt_execute($stmt);
    }
    $taskId = $_GET['id'];
// Use $taskId to delete the specific task from the database

    mysqli_close($conn);
    header("Location: index.php");
}
?>
