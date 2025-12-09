<?php
include '../config.php';
include ROOT_PATH . 'database.php';

if ($_SERVER['REQUEST_METHOD']=='POST') {

    $id = $_POST['id'];
    $check_in = $_POST['check_in'] ?: NULL;
    $check_out = $_POST['check_out'] ?: NULL;
    $status = $_POST['status'];

    try {
        $q = $connection->prepare("
            UPDATE attendance 
            SET check_in = :check_in,
                check_out = :check_out,
                status = :status
            WHERE id = :id
        ");

        $q->execute([
            ':check_in' => $check_in,
            ':check_out' => $check_out,
            ':status' => $status,
            ':id' => $id
        ]);

        header("Location: attendances.php");
        exit;

    } catch (PDOException $e) {
        echo "Error " . $e->getMessage();
    }
}
?>
