<?php
if(isset($_POST['register']))
{
    include_once 'dbh.inc.php';
    include_once 'function.php';
    
    $pass = $_POST['password'];
    $confirmpass = $_POST['confirm_password'];
    
    $first = mysqli_real_escape_string($conn, $_POST['firstname']);
    $last = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $university = mysqli_real_escape_string($conn, $_POST['university']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmpassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);


    
    // Error Handlers
    // Checks if any forms are empty
    if (empty($first) || empty($last) || empty($email) || empty($university) || empty($password) || empty($confirmpassword))
    {
        header("Location: ../index.php?signup=empty");
        exit();
    }
    else
    {
        // Checks if valid input characters
        if(!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last))
        {
            header("Location: ../index.php?signup=invalid");
            exit();
        }
        else
        {
            // Checks for valid email
            if (!filter_var($email,FILTER_VALIDATE_EMAIL))
            {
                header("Location: ../index.php?signup=email");
                exit();
            }
            else
            {
                // Checks if email is already taken
                $sql = "SELECT * FROM user WHERE email='$email'";
                $result = mysqli_query($conn, $sql);
                $resultcheck = mysqli_num_rows($result);
                
                if($resultcheck > 0)
                {
                    header("Location: ../index.php?signup=emailtaken");
                    exit();
                }
                else
                {
                    
                    $sql = "SELECT university_id FROM university WHERE name = '$university'";
                    $result = mysqli_query($conn, $sql);
                    $resultcheck = mysqli_num_rows($result);
                    $row= mysqli_fetch_assoc($result);
                    $university_id = $row['university_id'];
                    
                    
                    if(!$result)
                    {
                        $message = mysqli_error($conn);
                        alert($message);
                        header("Location: ../index.php?signup=errorcollege&");
                        exit();
                    }
                    else
                    {
                        if($pass != $confirmpass)
                        {
                            header("Location: ../index.php?signup=retypepassword");
                            exit();
                        }
                        else
                        {
                            // hash password
                            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);


                            $sql = "INSERT INTO user (firstname, lastname, email, university_id, password) VALUES ('$first', '$last', '$email', '$university_id', '$hashedpassword');";

                            mysqli_query($conn, $sql);
                            header("Location: ../index.php?signup=success");
                            exit();
                        }
                    }
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