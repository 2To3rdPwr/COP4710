<?php
	include 'dbh.inc.php';
session_start();
	$body = $_POST['comment'];
	$user_id=$_SESSION['u_id'];
	$event_id = $_GET['event_key'];
	$value = $_GET['value_key'];
	
	$sql = "INSERT INTO comment (user_id, event_id, body, date) VALUES ('$user_id', '$event_id', '$body', CURRENT_TIMESTAMP)";
	mysqli_query($conn, $sql);
	header("Location: ../eventpage.php?value_key=$value&event_key=$event_id&success");