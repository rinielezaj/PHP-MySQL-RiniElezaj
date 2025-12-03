<?php
$host="localhost";
$db="test";
$user="root";
$pass="";

try{
    $pdo=new PDO("mysql:host=$host;dbname=$db",$user,$pass);

    // $sql="ALTER TABLE users ADD email varchar(255)";
    $sql="ALTER TABLE users DROP COLUMN username";

    $pdo->exec($sql);
    echo "Column Created Successfully";
}catch(PDOException $e){
    echo "Error:". $e->getMessage();
}

?>