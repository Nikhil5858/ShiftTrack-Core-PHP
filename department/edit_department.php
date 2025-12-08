<?php
include '../config.php';
include ROOT_PATH . "database.php";

if (isset($_POST['dept_id'],$_POST['department_name'])) {
    $id = $_POST['dept_id'];
    $name = $_POST['department_name'];

    if ($name === "") {
        header("Location: departments.php");
        exit;
    }

    $request = $connection->prepare("UPDATE departments SET name = :name,updated_at = NOW() WHERE id = :id");

    try {
        $request->execute(['name'=>$name,'id'=>$id]);
        header("Location: departments.php");
    } catch (PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }
}

?>