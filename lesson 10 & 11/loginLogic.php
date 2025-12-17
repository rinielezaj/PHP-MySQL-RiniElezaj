<?php

include_once('config.php');

if(isset($_POST['submit'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    var_dump($username);

    if(empty($username) || empty($password)){
        echo "Fill all the fields";
        header("Location:login.php");

    }else{
        $sql="SELECT * FROM users WHERE username=:username";
        $insertSql=$conn->prepare($sql);
        $insertSql->bindParam(":username",$username);
        $insertSql->execute();

        $data=$insertSql->fetch();
        if(password_verify($password,$data['password'])){
            $_SESSION['username']=$data['username'];
            header('Location:dashboard.php');
        }else{
            echo "Password incorrect";
            header("Location:login.php");
        }
    }
}