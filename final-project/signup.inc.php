<?php

if(isset($_POST['register']))
{
    include_once 'dbh.inc.php';
    
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $uid = $_POST['uid'];
    $pwd = $_POST['pwd'];
    
    $sql = "INSERT INTO user (Fname, Lname, Email, uid, Pword) VALUES (?, ?, ?, ?, ?);";
    
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        echo "SQL Error";
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "sssss", $first, $last, $email, $uid, $pwd);
        mysqli_stmt_execute($stmt);
    }
    
    
    // Error Handlers
    // Empty Fields
    if(empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd) )
    {
        header("Location: ../index.php?signup=empty");
        exit();
    } 
    else
    {
        // Checks if first and last have ONLY letters
        if(!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last))
        {
            header("Location: ../index.php?signup=invalid");
            exit();
        }
        else
        {
            // Check if email is valid
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                header("Location: ../index.php?signup=email");
                exit();
            }
            else
            {
                // Checks if username is available
                $sql = "SELECT * FROM user WHERE uid='$uid'";
                $result = mysqli_query($conn, $sql);
                $resultcheck = mysqli_num_rows($result);
                
                if($resultcheck > 0)
                {
                    header("Location: ../index.php?signup=usertaken");
                    exit();
                }
                else
                {
                    // Hash password
                    $hashedPWD = password_hash($pwd, PASSWORD_DEFAULT);
                    // Insert the user into the database
                    $sql = "INSERT INTO user (Fname, Lname, Email, uid, Pword) VALUES ('$first', '$last', '$email', '$uid', '$hashedPWD');";
                    mysqli_query($conn, $sql);
                    header("Location: ../index.php?signup=success");
                    exit();
                }
            }
        }
    }
}
else
{
    header("Location: ../index.php");
    exit();
}