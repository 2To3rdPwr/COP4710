<?php



function alert($message) {
    echo "<script>
alert('Error, could not retrieve event information');
window.location.href='homepage.php';
</script>";
}

function getProfilePage($user_id)
{
    include 'dbh.inc.php';
    $sql = "SELECT university_id, email, firstname, lastname, permission_level FROM user WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    
    if($resultcheck != 1)
    {
        echo '<p>Error Getting User ID</p>';
        exit();
    }
    else
    {
        $row = mysqli_fetch_assoc($result);
        $first = $row['firstname'];
        $last = $row['lastname'];
        $email = $row['email'];
        $university = $row['university_id'];
        $permission = $row['permission_level'];
        
        $sql = "SELECT name from university WHERE university_id = '$university'";
        $result = mysqli_query($conn, $sql);
        $resultcheck = mysqli_num_rows($result);
        
            echo '<p class="profile-information">Full Name: ' . $first . ' ' . $last . '</p>';
        echo '<p class="profile-information">E-mail Address: ' . $email . '</p>';
        
        if($resultcheck == 0)
        {
            echo '<p class="profile-information">University: None</p>';
        }
        else
        {        
            $row = mysqli_fetch_assoc($result);
            $university_name = $row['name'];
            echo '<p class="profile-information">University: ' . $university_name . '</p>';
        }
        
        $sql = "SELECT R.name, R.active 
        from rso R, rso_membership R1 
        WHERE R.rso_id = R1.rso_id AND R1.user_id ='$user_id'";
        
        $result = mysqli_query($conn, $sql);
        $resultcheck = mysqli_num_rows($result);
        
        if($resultcheck == 0)
            echo '<p class="profile-information">Affiliated RSOs: None</p>';
        else
        {   
            echo '<p class="profile-information">Affiliated RSOs: </p>';
            echo '<ul class="profile-rso">';
            while($row = mysqli_fetch_assoc($result))
            {
                $rso = $row['name'];
                $rso_active = $row['active'];
                
                if($rso_active == 0)
                {
                    echo '<li>' . $rso . '<br><i>Not active</i></li>';
                }
                else
                    echo '<li>' . $rso . '<br><i>Active</i></li>';
            }
            echo '</ul>';
        }
        
    }
    
}

function getEvent($university_id)
{
    include 'dbh.inc.php';
    $sql = "SELECT * FROM event WHERE university_id = $university_id";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    
    if($row = mysqli_fetch_assoc($result))
    {
        echo $row['event_id'];
        echo $row['name'];
        echo $row['location'];
        echo $row['description'];
        echo $row['date'];
        echo '<br>';
    }
    $dateArray = dateToChar($row['date']);
    $year = $dateArray[0];
    $month = $dateArray[1];
    $day = $dateArray[2];
    
    $test = intMonthToChar($month);
    
    echo '<br>';
    echo $test;

}

// Used to get rso's the user is a part of
function getUserAssociatedRSOs($user_id)
{
    include 'dbh.inc.php';
    
    $sql = "SELECT R.name 
            FROM rso R, rso_membership M 
            WHERE R.active = '1' AND M.rso_id = R.rso_id 
            AND M.user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    
    if($resultcheck == 0)
    {
        return;
    }
    else
    {
        while($row= mysqli_fetch_assoc($result))
        {
            $rso_name = $row['name'];
            echo '<option>' . $rso_name . '</option>';
        }
    }

}

//get event comments
function getEventComments()
{
	include 'dbh.inc.php';
	$event_id = $_GET['event_key'];
	
	$sql = "SELECT C.*
			FROM comment C, event E
			WHERE E.event_id = '$event_id'
			ORDER BY C.date DESC";
			
	$result = mysqli_query($conn, $sql);
	$resultcheck = mysqli_num_rows($result);
	if($resultcheck == 0)
	{
		return;
	}
	else
	{
		$i = 0;
		$commentTitle = array();
		$commentBody = array();
		$commentRating = array();
		$commentDate = array();
		while($row = mysqli_fetch_assoc($result))
		{
			$commentTitle[$i] = $row['title'];
			$commentBody[$i] = $row['body'];
			$commentRating[$i] = $row['rating'];
			$commentDate[$i] = $row['date'];
			echo $commentTitle[$i] . '	Rating: ' . $commentRating[$i] . ' Stars <br>';
			echo $commentBody[$i] . '<br><br>';
			$i++;
		}
	}
}

function getEventPage()
{
    include 'dbh.inc.php';
    $university_id = $_GET['value_key'];
    $event_id = $_GET['event_key'];
    
    $sql = "SELECT * FROM event WHERE university_id = $university_id AND event_id= $event_id";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    
    
    if($resultcheck == 0)
    {
        alert();
        exit();
    }
    elseif($row=mysqli_fetch_assoc($result))
    {
        $event_name = $row['name'];
        $event_location = $row['location'];
        $event_description = $row['description'];    
    }
    echo '  <div class="eventheader"><h1>' . $event_name . '</h1></div>';
    echo '  <div class="information">
                <p class ="eventlocation">
                    <img class = "icons" src=img/location.png>'
                    . $event_location . 
                '</p>
                <p class ="time">
                    <img class = "icons" src ="img/clock.png">
                        at 7:00pm
                </p>
                <p class = "eventdescription">'
                . $event_description .
                '</p>
            </div>';
    
}

function getFormattedEvent()
{
    include 'dbh.inc.php';
    $university_id = $_GET['value_key'];
    
    $sql = "SELECT * FROM event WHERE university_id = $university_id AND rso_id IS NULL";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    
    
    
    if($resultcheck == 0)
    {
        echo 'No Events';
        return;
    }
    else
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $university_id = $row['university_id'];
            $event_id = $row['event_id'];
            $event_name = $row['name'];
            $event_location = $row['location'];
            $event_description = $row['description'];   

            $dateArray = dateToChar($row['date']);
            $year = $dateArray[0];
            $month = $dateArray[1];
            $day = $dateArray[2];

            $test = intMonthToChar($month);

            echo    '<a href="eventpage.php?value_key=';
                    echo $university_id . '&event_key=' . $event_id;
                    echo '">
                    <div class="eventfeed">
                    <div class="date">
                    <h1 class = "day">';
            echo    $day  ;          
            echo    '</h1>';
            echo    '<p class="headerfont">' ;
            echo    $test . ' ' . $year ;
            echo   '</p>
                    </div>
                    <div class="information">
                        <p class ="eventname">'
                            . $event_name .
                        '</p>
                        <p class ="eventlocation">
                            <img class = "icons" src=img/location.png>'
                            . $event_location . 
                        '</p>
                        <p class ="time">
                            <img class = "icons" src ="img/clock.png">
                                at 7:00pm
                        </p>
                        <p class = "eventdescription">'
                        . $event_description .
                        '</p>
                            </div>
            </div>
            </a>';            
        }     
    }
            
    
    
}

function getHomePageEventFeed($university_id, $user_id)
{
    include 'dbh.inc.php';
 	
	$sql = "SELECT E.event_id, E.university_id, E.name, E.location, E.description, E.date, E.approved 
            FROM event E
            WHERE (E.approved = '1') 
            AND (E.university_id = '$university_id') 
            AND (E.rso_id IN (SELECT R.rso_id
            FROM rso_membership R
            WHERE user_id = '$user_id'))
            UNION
            SELECT E.event_id, E.university_id, E.name, E.location, E.description, E.date, E.approved 
            FROM event E
            WHERE (E.approved = '1') 
            AND (E.university_id = '1')
            AND (E.rso_id IS NULL)
            ORDER BY date";
    

	$result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
	$resultcheck = mysqli_num_rows($result);

	if($resultcheck == 0)
    {
        
    }
    else
    {
        while($row=mysqli_fetch_assoc($result))
        {
            $event_id = $row['event_id'];
            $university_id = $row['university_id'];
            $event_name = $row['name'];
            $event_location = $row['location'];
            $event_description = $row['description'];
            $event_date = $row['date'];
            $event_approval = $row['approved'];
            
            $dateArray = dateToChar($row['date']);
            $year = $dateArray[0];
            $month = $dateArray[1];
            $day = $dateArray[2];

            $test = intMonthToChar($month);
            
            echo    '<a href="eventpage.php?value_key=';
            echo $university_id . '&event_key=' . $event_id;
            echo '">
            <div class="eventfeed">
            <div class="date">
            <h1 class = "day">';
            echo    $day  ;          
            echo    '</h1>';
            echo    '<p class="headerfont">' ;
            echo    $test . ' ' . $year ;
            echo   '</p>
                    </div>
                    <div class="information">
                        <p class ="eventname">'
                            . $event_name .
                        '</p>
                        <p class ="eventlocation">
                            <img class = "icons" src=img/location.png>'
                            . $event_location . 
                        '</p>
                        <p class ="time">
                            <img class = "icons" src ="img/clock.png">
                                at 7:00pm
                        </p>
                        <p class = "eventdescription">'
                        . $event_description .
                        '</p>
                            </div>
            </div>
            </a>';    
        }
    }
	
}

function getFormattedUniversityProfile()
{
    include 'dbh.inc.php';
    $university_id = $_GET['value_key'];
    
    $sql = "select * FROM university WHERE university_id = $university_id";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    
    if($resultcheck == 0)
    {
        echo '<p class="university-profile-information">Error No College Information</p>';
    }
    elseif($row = mysqli_fetch_assoc($result))
    {
        $university_name = $row['name'];
        $university_description = $row['description'];
        $university_location = $row['location'];
        $university_website = $row['website'];
        
        echo '<h1 class="university-profile-header">' . $university_name .
        '</h1><p class="university-profile-information"><img src="img/location.png">' . $university_location . '</p><p class="university-profile-information"><img src="img/website.png"><a href="https://' . $university_website . '" target="_blank">' . $university_website . '</a></p><p class="university-profile-information">' . $university_description . '</p>';
    }
}

function getUniversityRSO()
{
    include 'dbh.inc.php';
    $university_id = $_GET['value_key'];
    
    $sql = "SELECT name, description, active FROM rso WHERE university_id = '$university_id' ORDER BY active DESC, name ASC";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    
    if($resultcheck == 0)
    {
        echo '<p>There are no RSOs for this university</p>';
    }
    else
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $name = $row['name'];
            $description = $row['description'];
            $active = $row['active'];
            echo '  <div class="eventfeed">
                    <p class ="rso-details rso-name">'
                    . $name .
                '</p>
                <p class ="rso-details">'

                    . $description . 
                '</p>
                <p class ="rso-details">';
            if($active == '0')
            {
                echo 'Not Active';
            }
            else
            {
                echo 'Active';
            }
                    
            echo  ' </p>

                    </div>';
            
            
        }
    }
    
}

function intMonthToChar($month)
{
    if($month == '01')
        return 'Jan';
    if($month == '02')
    return 'Feb';
    if($month == '03')
    return 'Mar';
    if($month == '04')
    return 'Apr';
    if($month == '05')
    return 'May';
    if($month == '06')
    return 'Jun';
    if($month == '07')
    return 'Jul';
    if($month == '08')
    return 'Aug';
    if($month == '09')
    return 'Sep';
    if($month == '10')
    return 'Oct';
    if($month == '11')
    return 'Nov';
    if($month == '12')
    return 'Dec';
}

function dateToChar($date)
{
    $dateArray = explode("-", $date);
    
    return $dateArray;
}

function listUniversities()
{
    include 'dbh.inc.php';
    $sql = "SELECT * FROM university ORDER BY name ASC";
    $result = mysqli_query($conn, $sql);

    
    if(mysqli_num_rows($result) == 0)
    {
        echo '<p> No Universities Available</p>';
    }
    else
    {
        // runs through query of everything from university
        while($row = mysqli_fetch_assoc($result))
        {
            $university_name = $row['name'];
            $university_id = $row['university_id'];
            echo '<p class ="university-list"> <a href="university.php?value_key=';
            echo $university_id;
            echo '">';
            echo $university_name;
            echo '</a></p>';

        }
        

    }
}

function formatSignUpUniversity()
{
    include 'dbh.inc.php';
    
    $sql = "SELECT university_id, name FROM university";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    
    if($resultcheck == 0)
    {
        return;
    }
    else
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $university_name = $row['name'];
            $university_id = $row['university_id'];
            echo '<option>' . $university_name . '</option>';
        }
    }
    
}





























