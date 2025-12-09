<?php
include '../config.php';
include ROOT_PATH . "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST['id'];
    $name = $_POST['shift_name'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $grace = $_POST['grace_minutes'];

    try {
        $query = $connection->prepare("
            UPDATE shifts 
            SET name = :name, start_time = :start, end_time = :end, grace_minutes = :grace
            WHERE id = :id
        ");

        $query->execute([
            ':name' => $name,
            ':start' => $start,
            ':end' => $end,
            ':grace' => $grace,
            ':id' => $id
        ]);

        header("Location: shifts.php");
        exit;

    } catch (PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }
}
?>
