<?php
include '../config.php';
include ROOT_PATH . "database.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $employee = $_POST['employee'];
    $date = $_POST['date'];
    $check_in = $_POST['check_in'] ?: NULL;
    $check_out = $_POST['check_out'] ?: NULL;
    $status = $_POST['status'];

    try {
        $query = $connection->prepare("
            INSERT INTO attendance (employee_id, date, check_in, check_out, status)
            VALUES (:employee, :date, :check_in, :check_out, :status)
        ");

        $query->execute([
            ':employee' => $employee,
            ':date' => $date,
            ':check_in' => $check_in,
            ':check_out' => $check_out,
            ':status' => $status
        ]);

        header("Location: attendances.php");
        exit;

    } catch (PDOException $e) {
        echo "Error " . $e->getMessage();
    }
}
?>
