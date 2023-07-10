<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function toggleTaskStatus(checkbox) {
            const listItem = checkbox.parentNode.parentNode;
            if (checkbox.checked) {
                listItem.classList.add('checked');
            } else {
                listItem.classList.remove('checked');
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>To-Do List</h1>
        <form action="add.php" method="post">
            <input type="text" name="task" placeholder="Enter a task">
            <button type="submit">Add Task</button>
        </form>
        <ul>
            <!-- Fetch and display tasks from the database -->
            <?php
            require_once("database.php");
            $sql = "SELECT * FROM tasks";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li class='task-item'>";
                echo "<input type='checkbox' onchange='toggleTaskStatus(this)'>";
                echo "<span class='task-text'>" . $row['task'] . "</span>";
                echo "<span class='actions'>";
                echo "<a href='edit.php?id=" . $row['id'] . "'>Edit</a>";
                echo "<a href='delete.php?id=" . $row['id'] . "'>Delete</a>";
                echo "</span>";
                echo "</li>";
            }
            mysqli_close($conn);
            ?>

        </ul>
    </div>
</body>
</html>
