<?php

include_once("config.php");

$id=$_GET['id'];

$sql="DELETE FROM products where id=:id";
$getProdcuts=$conn->prepare($sql);

$getProdcuts->bindParam(":id",$id);
$getProdcuts->execute();

header("Location:dashboard.php")

?>