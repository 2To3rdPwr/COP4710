<?php
include 'dbh.inc.php';
session_start();
$user_id = $_SESSION['u_id'];

$event_id = $_GET['event_key'];

$sql = "INSERT INTO attendance (user_id, event_id) VALUES ($user_id, $event_id)";
mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
header("Location: ../homepage.php?success=eventattended$event_id");