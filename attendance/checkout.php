<?php
include '../config.php';
include ROOT_PATH . 'database.php';

$attendance_id = $_POST['attendance_id'];
$time = date('H:i:s');

$stmt = $connection->prepare("
    UPDATE attendance SET check_out = :time 
    WHERE id = :id
");

$stmt->execute([
    'time' => $time,
    'id' => $attendance_id
]);

header("Location: attendances.php?date=" . date('Y-m-d'));
exit;
