<?php

include 'dbh.inc.php';
session_start();
$user_id = $_SESSION['u_id'];
$event_id =$_GET['event_key'];
$university_id = $_GET['value_key'];

$body = $_POST['edit'];

$sql = "UPDATE comment set body = '$body' WHERE user_id = $user_id AND event_id = $event_id";
mysqli_query($conn, $sql);

header("Location: ../eventpage.php?value_key=$university_id&event_key=$event_id");