<?php


if(isset($_POST['submit']))
{
    session_start();
    include_once 'dbh.inc.php';
    include_once 'function.php';
    $user_id = $_SESSION['u_id'];
    $current_email = $_SESSION['email'];
    
    $pass = $_POST['password'];
    $confirmpass = $_POST['confirm_password'];
    
    $first = mysqli_real_escape_string($conn, $_POST['first']);
    $last = mysqli_real_escape_string($conn, $_POST['last']);
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
            header("Location: ../profile.php?edit=first");
            exit();
        }
        else
        {
            // Checks for valid email
            if (!filter_var($email,FILTER_VALIDATE_EMAIL))
            {
                header("Location: ../profile.php?edit=email");
                exit();
            }
            else
            {
                // Checks if email is already taken
                $sql = "SELECT * FROM user WHERE email='$email'";
                $result = mysqli_query($conn, $sql);
                $resultcheck = mysqli_num_rows($result);
                
                if($resultcheck > 0){
                    $row = mysqli_fetch_assoc($result);
                    $check_email = $row['email'];
                }
                
                if($current_email != $check_email)
                {
                    header("Location: ../profile.php?edit=emailtaken");
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
                        header("Location: ../profile.php?edit=errorcollege&");
                        exit();
                    }
                    else
                    {
                        if($pass != $confirmpass)
                        {
                            header("Location: ../profile.php?edit=retypepassword");
                            exit();
                        }
                        else
                        {
                            // hash password
                            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
                            

                            $sql = "UPDATE user
                                    SET firstname = '$first', lastname = '$last', email = '$email', university_id = '$university_id', password = '$hashedpassword'
                                    WHERE user_id = '$user_id';";
                            mysqli_query($conn, $sql);
                            header("Location: ../profile.php?edit=success");
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