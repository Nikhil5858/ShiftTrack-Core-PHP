<?php
include '../config.php';
include ROOT_PATH . 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['shift_name'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $grace = $_POST['grace_minutes'];

    try {
        $query = $connection->prepare("
            INSERT INTO shifts (name, start_time, end_time, grace_minutes)
            VALUES (:name, :start, :end, :grace)
        ");

        $query->execute([
            ':name' => $name,
            ':start' => $start,
            ':end' => $end,
            ':grace' => $grace
        ]);

        header("Location: shifts.php");
        exit;

    } catch (PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }
}
?>
