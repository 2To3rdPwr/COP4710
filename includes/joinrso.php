<?php
    session_start();
    include 'dbh.inc.php';
    $university_id = $_GET['value_key'];
    $rso_id = $_GET['rso_key'];
    $user_id = $_SESSION['u_id'];
    $user_university = $_SESSION['university_id'];

    $sql = "SELECT university_id FROM rso WHERE rso_id = $rso_id";
    $result =mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $rso_university = $row['university_id'];

    if($user_university != $rso_university)
    {
        header("Location: ../university.php?value_key=$university_id&error=notstudent");
        
    }
    else
    {
        $sql = "INSERT INTO rso_membership (rso_id, user_id, admin) VALUES ($rso_id, $user_id, '0')";
        mysqli_query($conn, $sql);
        header("Location:../university.php?value_key=$university_id&success=joinedRSO");
    }