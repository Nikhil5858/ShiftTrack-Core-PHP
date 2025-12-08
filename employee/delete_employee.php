<?php 
include '../config.php';
include ROOT_PATH . "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];

    try {
        $query = $connection->prepare("DELETE FROM employees WHERE id = :id");
        $query->execute([':id' => $id]);

        header("Location: employees.php");
        exit;
    } catch (PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }
}

?>