<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>To-Do List</h1>
        <?php
        $host = "localhost";
        $user = "root";
        $pass = "";
        $dbname = "todolist";
        $conn = mysqli_connect($host, $user, $pass, $dbname);
        if (!$conn) {
            die("Could not connect to the database");
        }

        if (isset($_POST["add"])) {
            $task = $_POST["task"];
            // Fetch the total number of tasks
            $sql = "SELECT COUNT(*) FROM tasks";
            $result = mysqli_query($conn, $sql);
            $count = mysqli_fetch_row($result)[0];

            // Increment the counter value
            $counter = $count + 1;

            // Insert the new task with the counter value
            $sql = "INSERT INTO tasks (id, task) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "is", $counter, $task);
            mysqli_stmt_execute($stmt);
        }
        ?>
        <form action="" method="post">
            <input type="text" name="task" placeholder="Enter a task" autocomplete="off">
            <button type="submit" name="add">Add Task</button>
        </form>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Tasks</th>
                    <th scope="col" class="text-end">Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM tasks";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row["id"];
                        $task = $row["task"];
                        echo "<tr>
                            <th scope='row'>" . $id . "</th>
                            <td>" . $task . "</td>
                            <td class='text-end'>
                                <button class='btn btn-primary'><a href='update.php?updateid=$id' class='text-light'>Update</a></button>
                                <button class='btn btn-danger'><a href='delete.php?deleteid=$id' class='text-light'>Delete</a></button>
                            </td>
                        </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
