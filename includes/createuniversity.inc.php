<?php

    include 'dbh.inc.php';
    
    if(isset($_POST['university-submit']))
    {
        $university_name = mysqli_real_escape_string($conn, $_POST['name']);
        $university_description = mysqli_real_escape_string($conn, $_POST['description']);
        $university_location = mysqli_real_escape_string($conn, $_POST['location']);
        $university_website = mysqli_real_escape_string($conn, $_POST['website']);
        
        $sql = "SELECT university_name FROM university WHERE name = '$university_name'";
        $result = mysqli_query($conn, $sql);
        $resulcheck = mysqli_num_rows($result);
        
        if($resultcheck > 0)
        {
            header("Location: ../universitylist.php?error=nametaken");
            echo '<p style= "color:red">This University Profile has already been made</p>';
        }
        else
        {
            $sql = "INSERT INTO university (name, description, location, website) VALUES ('$university_name', '$university_description', '$university_location', '$university_website')";
            mysqli_query($conn, $sql);
            header("Location: ../universitylist.php?success=universitycreated");
        }
        
        
        
    }
    else
    {
        header("Location: ../universitylist.php?error");
    }