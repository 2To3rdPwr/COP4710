<?php

include 'dbh.inc.php';
session_start();
$user_id = $_SESSION['u_id'];

$event_id = $_GET['event_key'];

    $sql = "DELETE FROM attendance WHERE user_id = $user_id AND event_id = $event_id";
    mysqli_query($conn, $sql);
header("Location: ../homepage.php?success=eventleft$event_id");