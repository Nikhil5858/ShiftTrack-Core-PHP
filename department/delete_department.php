<?php 
include '../config.php';
include ROOT_PATH . "database.php";

if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    $request = $connection->prepare("DELETE FROM Departments WHERE id = :id");

    try {
        $request ->execute(['id'=>$id]);
        header("Location: departments.php");

    } catch (PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }
}
?>