<?php
include '../config.php';
include ROOT_PATH . 'database.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id = $_POST['edit_id'];
    $name = $_POST['holiday_name'];
    $date = $_POST['holiday_date'];

    try {
        $query = $connection->prepare("
            UPDATE holidays 
            SET name = :name, date = :date
            WHERE id = :id
        ");

        $query->execute([
            ':name' => $name,
            ':date' => $date,
            ':id'   => $id
        ]);

        header("Location: holidays.php");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
