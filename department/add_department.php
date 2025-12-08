<?php 
include '../config.php';
include ROOT_PATH . "database.php";

if (isset($_POST['department_name'])) {

    $name = $_POST['department_name'];

    if ($name === "") {
        header("Location: departments.php");
        exit;
    }

    try {
        $request = $connection->prepare("INSERT INTO departments (name) VALUES (:name)");
        $request->execute([':name' => $name]);

        header("Location: departments.php");
        exit;

    } catch (PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }
}
?>
