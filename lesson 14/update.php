<?php
include_once("config.php");

if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];

    $sql = "UPDATE products SET name = :name WHERE id = :id";

    $prep = $conn->prepare($sql);
    $prep->bindParam(':id', $id, PDO::PARAM_INT);
    $prep->bindParam(':name', $name);

    $prep->execute();

    header("Location: dashboard.php");
    exit;
}
?>
