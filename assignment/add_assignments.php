<?php
include '../config.php';
include ROOT_PATH . 'database.php';

if ($_SERVER['REQUEST_METHOD']=='POST') {

    $employee = $_POST['employee'];
    $shift = $_POST['shift'];
    $from = $_POST['effective_from'];
    $to = $_POST['effective_to'] ?: NULL;

try {

    $query = $connection->prepare("
    INSERT INTO employee_shifts (employee_id, shift_id, effective_from, effective_to)
    VALUES (:employee, :shift, :effective_from, :effective_to)
    ");

    $query->execute([
        ':employee' => $employee,
        ':shift' => $shift,
        ':effective_from' => $from,
        ':effective_to' => $to
    ]);
    header('Location: assignments.php');
    exit;
    
} catch (PDOException $e) {
    echo "Error " . $e->getMessage();
}
}   
?>