<?php
// Handle adding a new task to the database
if(isset($_POST["task"]) && !empty($_POST["task"])) {
    $task = $_POST["task"];
    require_once("database.php");
    $sql = "INSERT INTO tasks (task) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $task);
        mysqli_stmt_execute($stmt);
    }
    mysqli_close($conn);
}
header("Location: index.php");
?>
