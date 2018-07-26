<?php
    session_start();
    include 'dbh.inc.php';
    include 'function.php';

    if(isset($_POST['submit']))
    {
        $user_privilege = $_SESSION['privilege'];
        $user_id = $_SESSION['u_id'];
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $university_name = mysqli_real_escape_string($conn, $_POST['university']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $time = mysqli_real_escape_string($conn, $_POST['time']);
        $privacy = mysqli_real_escape_string($conn, $_POST['privacy']);
        $rso_name = mysqli_real_escape_string($conn, $_POST['rso-name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
        
        if($privacy == 'Public')
        {
            $privacy = '0';
        }
        elseif($privacy == 'Private')
        {
            $privacy = '1';
        }
        else
        {
            $privacy = '2';
        }
        
        // gets an event described above to check if location is occupied
        $sql = "SELECT * FROM event WHERE location = '$location' AND date = '$combinedDT' AND (university_id IN (SELECT university_id FROM university where name = '$university_name'))";
        $result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
        $resultcheck = mysqli_num_rows($result);
        
        if($resultcheck > 0)
        {
            header("Location: ../homepage.php?error=eventlocationoccupied");
        }
        else
        {
            // if selected public/private and didnt select none for rso, error
            if(($privacy == '0' || $privacy == '1') && $rso_name != 'None')
            {
                header("Location: ../homepage.php?selectedpublicprivate");
            }
            // if select rso and rso_name = none, error
            elseif($privacy == '2' && $rso_name == 'None')
            {
                header("Location: ../homepage.php?selectedrso");
            }
            // case for students 
            else
            {
                $sql = "SELECT university_id from university WHERE name = '$university_name'";
                $result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
                $resultcheck = mysqli_num_rows($result);

                
                // university does not exist
                if($resultcheck == 0)
                {
                    header("Location: ../homepage.php?error=invaliduniversity");
                }
                // university exists
                else
                {
                    $row= mysqli_fetch_assoc($result);
                    // if the given university name
                    if($_SESSION['university_id'] != $row['university_id'])
                    {
                        header("Location: ../homepage.php?error=notstudent");
                    }
                    else
                    {
                        $university_id = $_SESSION['university_id'];
                        
                        // Creating Event with no RSO
                        if($rso_name == 'None')
                        {

                            if($user_privilege == '0')
                            {
                                $university_id = $_SESSION['university_id'];
                                $sql = "INSERT INTO event (university_id, name, location, description, date, approved, privacy) VALUES ('$university_id', '$name', '$location', '$description', '$combinedDT', '0' , $privacy)";
                                mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
                                header("Location: ../homepage.php?success=eventToAdmin0");
                            }
                            else
                            {
                                $sql = "INSERT INTO event (university_id, name, location, description, date, approved, privacy) VALUES ('$university_id', '$name', '$location', '$description', '$combinedDT', '1', $privacy )";
                                mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
                                header("Location: ../homepage.php?success=eventCreated1");
                            }
                        }
                        // Creating Event with RSO
                        else
                        {
                            $sql = "SELECT * FROM rso WHERE name = '$rso_name'";
                            $result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
                            $row = mysqli_fetch_assoc($result);
                            $rso_id = $row['name'];
                            
                            if($user_privilege == '1')
                            {
                                $sql = "INSERT INTO event (university_id, name, location, description, date, rso_id, approved, privacy) VALUES ('$university_id', '$name', '$location', '$description', '$combinedDT', '$rso_id', '1', $privacy)";
                                mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
                                header("Location: ../homepage.php?success=eventCreated");
                            }
                            elseif($user_privilege == '2')
                            {
                                $sql = "SELECT admin FROM rso_membership WHERE rso_id = $rso_id AND user_id = $user_id AND admin = '1'";
                                $result = mysqli_query($conn, $sql);
                                $resultcheck = mysqli_num_rows($result);
                                if($resultcheck > 0)
                                {
                                    $sql = "INSERT INTO event (university_id, name, location, description, date, rso_id, approved, privacy) VALUES ('$university_id', '$name', '$location', '$description', '$combinedDT', '$rso_id', '1', $privacy)";
                                    mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
                                    header("Location: ../homepage.php?success=eventCreated");
                                }
                                else
                                {
                                    header("Location: ../homepage.php?error=notRSOadmin");
                                }
                            }
                            elseif($user_privilege == '0')
                            {
                                header("Location: ../homepage.php?error=notRSOadmin");
                            }

                        }
                        

                    }
                }

            }
        }
    }
    else
    {
        header("Location: ../homepage.php?error");
    }