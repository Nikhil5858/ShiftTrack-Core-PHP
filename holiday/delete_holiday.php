<?php
include '../config.php';
include ROOT_PATH . 'database.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id = $_POST['delete_id'];

    try {
        $query = $connection->prepare("DELETE FROM holidays WHERE id = :id");
        $query->execute([':id' => $id]);

        header("Location: holidays.php");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
