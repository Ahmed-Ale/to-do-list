<?php
$host = "localhost";
$user = "root";
$pass ="";
$dbname = "todolist";
$conn = mysqli_connect($host,$user,$pass,$dbname);
if(!$conn) {
    die("Could not connect to the database");
}
if(isset($_GET["deleteid"])) {
    $id = $_GET["deleteid"];
    $sql = "DELETE FROM tasks WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    // Update the ids of the remaining tasks
    $deleted_id = $_GET["deleteid"];
    $sql = "SELECT * FROM tasks";
    $result = mysqli_query($conn, $sql);

    if($result) {
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row["id"];

            // If the id is greater than the deleted id, then decrement it by 1
            if($id > $deleted_id) {
                $sql = "UPDATE tasks SET id=id-1 WHERE id=$id";
                mysqli_query($conn, $sql);
            }
        }
    }
    // Redirect to the index page
    header("location: index.php");
}
?>

