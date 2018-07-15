<?php

session_start();

if(isset($_POST['login']))
{
    include 'dbh.inc.php';
    
    $email =mysqli_real_escape_string($conn, $_POST['email']);
    $password =mysqli_real_escape_string($conn, $_POST['password']);
    
    //Error Handlers
    //check for empty inputs
    if(empty($email) || empty($password))
    {
        header("Location: ../index.php?login=empty");
        exit();
    }
    else
    {

        $sql = "SELECT * FROM user WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $resultcheck = mysqli_num_rows($result);
        
        // checks if email is in database, if not, error
        if($resultcheck < 1)
        {
            header("Location: ../index.php?login=error");
            exit();
        }
        // if email is inside database
        else
        {
            // 
            if($row = mysqli_fetch_assoc($result))
            {
                $hashedpasswordcheck = password_verify($password, $row['password']);
                if($hashedpasswordcheck == false)
                {
                    header("Location: ../index.php?login=error");
                    exit();
                }
                elseif($hashedpasswordcheck == true)
                {
                    //Login user
                    $_SESSION['u_id'] =$row['user_id'];
                    $_SESSION['first'] =$row['firstname'];
                    $_SESSION['last'] =$row['lastname'];
                    $_SESSION['email'] =$row['email'];
                    $_SESSION['privilege'] = $row['permission_level'];
                    $_SESSION['university_id']=$row['university_id'];
                    
                    header("Location: ../homepage.php?login=success");
                    exit();
                    
                }
            }
        }
    }
    
}
else
{
    header("Location: ../index.php?login=error");
}