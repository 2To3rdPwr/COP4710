<?php
session_start();
if(isset($_POST['rso-submit']))
{
    include 'dbh.inc.php';
    
    $rso_name =mysqli_real_escape_string($conn, $_POST['rso-name']);
    $description =mysqli_real_escape_string($conn, $_POST['description']);
    $university_id = $_GET['university_id'];
    $user_privilege = $_SESSION['privilege'];
    
    
    $sql = "SELECT * FROM rso WHERE name='$rso_name'"; 
    
    $result = mysqli_query($conn, $sql);
    
    $resultcheck = mysqli_num_rows($result);
    
    if($resultcheck > 0)
    {
        header("Location: ../university.php?value_key=$university_id&error=nametaken");
        exit();
    }
    else
    {
        $sql = "INSERT INTO rso (university_id, name, description) VALUES ('$university_id', '$rso_name', '$description')";
        mysqli_query($conn, $sql);
        
        $sql = "SELECT rso_id from rso WHERE name = '$rso_name'";
        $result = mysqli_query($conn, $sql);
        $row =mysqli_fetch_assoc($result);
        $rso_id = $row['rso_id'];
        $user_id = $_SESSION['u_id'];
        
        $sql = "INSERT INTO rso_membership (rso_id, user_id, admin) VALUES ('$rso_id', '$user_id', '1')";
        $result = mysqli_query($conn, $sql);
        
        if($user_privilege == 1 || $user_privilege == 2)
        {
            continue;
        }
        else
        {
            $sql = "UPDATE user SET permission_level = '2' WHERE user_id = $user_id";
            mysqli_query($conn, $sql);
        }
        
        if(!result)
        {
            echo 'error result ';
        }
        
        header("Location: ../university.php?value_key=$university_id&success=rsocreated");
    }
}
else
{
    header("Location: ../universitylist.php");
}
