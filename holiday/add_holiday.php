<?php
include '../config.php';
include ROOT_PATH . 'database.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name = $_POST['holiday_name'];
    $date = $_POST['holiday_date'];

    try {
        $query = $connection->prepare("
            INSERT INTO holidays (name, date) 
            VALUES (:name, :date)
        ");

        $query->execute([
            ':name' => $name,
            ':date' => $date
        ]);

        header("Location: holidays.php");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
