<?php

session_start();

include_once('config.php');

$user_id=$_SESSION['id'];
$movie_id=$_SESSION['movie_id'];

$nr_tickets=$_POST['nr_tickets'];
$date=$_POST['date'];
$time=$_POST['time'];

$sql="INSERT INTO bookings(user_id,movie_id,nr_tickets,date,time) VALUES (:user_id,:movie_id,:nr_tickets,:date,:time)";

$insertBooking=$conn->prepare($sql);

$insertBooking->bindParam(":user_id,$user_id");
$insertBooking->bindParam(":movie_id,$movie_id");
$insertBooking->bindParam(":nr_tickets,$nr_tickets");
$insertBooking->bindParam(":date,$date");
$insertBooking->bindParam(":time,$time");

$insertBooking->execute();

header('Location:home.php')