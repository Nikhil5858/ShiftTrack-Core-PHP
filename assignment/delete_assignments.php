<?php
include '../config.php';
include ROOT_PATH . 'database.php';

if ($_SERVER['REQUEST_METHOD']== "POST") {
    $id = $_POST['id'];
    try {
        $query = $connection->prepare("DELETE FROM employee_shifts WHERE id = :id");
        $query->execute([':id'=>$id]);
        header('Location: assignments.php');
        exit;
    } catch (PDOException $e) {
        echo 'Error ' . $e->getMessage();
    }
}

?>