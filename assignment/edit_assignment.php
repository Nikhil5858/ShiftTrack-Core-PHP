<?php
include '../config.php';
include ROOT_PATH . 'database.php';

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $id = $_POST['id'];
    $employee = $_POST['employee'];
    $shift = $_POST['shift'];
    $from = $_POST['effective_from'];
    $to = $_POST['effective_to'] ?: NULL;

try {

    $query = $connection->prepare("
        UPDATE employee_shifts 
        SET employee_id = :employee, shift_id = :shift, effective_from = :effective_from, effective_to = :effective_to
        WHERE id = :id
    ");

    $query->execute([
        ':employee' => $employee,
        ':shift' => $shift,
        ':effective_from' => $from,
        ':effective_to' => $to,
        ':id' => $id
    ]);
    header('Location: assignments.php');
    exit;
    
} catch (PDOException $e) {
    echo "Error " . $e->getMessage();
}
}   
?>