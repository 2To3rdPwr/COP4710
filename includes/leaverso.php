<?php

    session_start();
    include 'dbh.inc.php';
    $university_id = $_GET['value_key'];
    $rso_id = $_GET['rso_key'];
    $user_id = $_SESSION['u_id'];
    $user_university = $_SESSION['university_id'];

    
    $sql = "DELETE FROM rso_membership WHERE rso_id=$rso_id AND user_id = $user_id";
    mysqli_query($conn, $sql);

    header("Location: ../university.php?value_key=$university_id&succes-leftRSO");