<?php 
include '../config.php';
include ROOT_PATH . "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];

    if ($name === "" || $email === ""|| $phone === ""|| $department === ""|| $id === "") {
        header("Location: employees.php");
        exit;
    }

    try {
        $query = $connection->prepare("
            UPDATE employees SET name = :name,email = :email,phone = :phone,department_id = :department
            WHERE id = :id             
        ");

        $query->execute([
            ':name'=> $name,
            ':email'=> $email,
            ':phone'=> $phone,
            ':department' => $department,
            ':id'=> $id
        ]);
        header("Location: employees.php");
        exit;

    } catch (PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }
}

?>