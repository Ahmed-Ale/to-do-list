<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "todolist";
$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Could not connect to the database");
}

if (isset($_GET["updateid"])) {
    $id = $_GET["updateid"];

    // Get the task from the database
    $sql = "SELECT * FROM tasks WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $task = $row["task"];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
        input[type="text"] {
            width: 300px; /* Adjust the width as per your preference */
        }
.container {
    max-width: 600px;
    margin: 40px auto;
    padding: 20px;
    background-color: #f2f2f2;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
h1 {
    text-align: center;
}
button {
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 0 5px 5px 0;
    cursor: pointer;
}
.btn-green {
    background-color: green;
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Update Task</h1>

        <form action="update.php?updateid=<?php echo $id; ?>" method="post">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <input type="text" name="task" value="<?php echo $task; ?>" class="form-control">
                </div>
                <div class="col-md-4">
                    <button type="submit" name="update" class="btn btn-primary btn-block btn-green">Update</button>
                </div>
            </div>
        </form>
    </div>

    <?php
    if (isset($_POST["update"])) {
        $task = $_POST["task"];

        // Update the task in the database
        $sql = "UPDATE tasks SET task='$task' WHERE id=$id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: index.php");
        } else {
            echo "Error updating task";
        }
    }
    ?>
</body>
</html>
