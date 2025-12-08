<?php 
include '../config.php';
include ROOT_PATH . "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];

    if ($name === "" || $email === ""|| $phone === ""|| $department === "") {
        header("Location: employees.php");
        exit;
    }

    try {
        $query = $connection->prepare("
            INSERT INTO employees (name, email, phone, department_id)
            VALUES (:name, :email, :phone, :department)
        ");

        $query->execute([
            ':name'=> $name,
            ':email'=> $email,
            ':phone'=> $phone,
            ':department' => $department
        ]);
        header("Location: employees.php");
        exit;

    } catch (PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }
}

?>