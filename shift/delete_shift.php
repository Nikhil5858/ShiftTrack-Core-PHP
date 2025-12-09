<?php
include '../config.php';
include ROOT_PATH . "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST['delete_id'];

    try {
        $query = $connection->prepare("DELETE FROM shifts WHERE id = :id");
        $query->execute([':id' => $id]);

        header("Location: shifts.php");
        exit;

    } catch (PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }
}
?>
