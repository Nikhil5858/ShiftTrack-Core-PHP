<?php
include '../config.php'; 
include ROOT_PATH . 'database.php';

$employee_id = $_POST['employee_id'];
$date = date('Y-m-d');
$time = date('H:i:s');

$stmt = $connection->prepare("
    INSERT INTO attendance (employee_id, date, check_in, status)
    VALUES (:id, :date, :time, 'Present')
");
$stmt->execute([
    'id' => $employee_id,
    'date' => $date,
    'time' => $time
]);

header("Location: attendances.php?date=$date");
exit;
