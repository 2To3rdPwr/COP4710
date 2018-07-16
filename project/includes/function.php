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
        $event_date = $row['date'];
        $phpdate = strtotime($event_date);
        $event_date = date( 'Y-m-d', $phpdate );
        $time_in_12_hour_format = date("g:i a", $phpdate);
        $dateArray = dateToChar($event_date);
        $year = $dateArray[0];
        $month = $dateArray[1];
        $day = $dateArray[2];

        $test = intMonthToChar($month);
    }
    echo '  <div class="eventheader"><h1>' . $event_name . '</h1></div>';
    echo '  <div class="information">
                <p class ="eventlocation">
                    Location: '
                    . $event_location . 
                '</p>
                <p style="margin-top: -25px;">
                    Date: ' . $test .' ' . $day . ', ' . $year . '  

                </p>
        <p style="margin-top: -25px;">                         Time: at ' . $time_in_12_hour_format . '</p>
                <p style="margin-top: -25px;">
                Description:
                </p>
                <p style="margin-top: -25px;">' . $event_description . '</p>
            </div>';
    
}

function getFormattedEvent($user_id)
{
    include 'dbh.inc.php';
    $university_id = $_GET['value_key'];
    
    $sql = "SELECT university_id from user WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $user_university_id = $row['university_id'];
    
    // if the user is a student at this university
    if($university_id == $user_university_id)
    {
        $sql = "SELECT * FROM event WHERE university_id = $university_id AND rso_id IS NULL AND approved =1";
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
                $event_date = $row['date'];
                $phpdate = strtotime($event_date);
                $event_date = date( 'Y-m-d', $phpdate );
                $time_in_12_hour_format = date("g:i a", $phpdate);
                $dateArray = dateToChar($event_date);
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
                                    at ' . $time_in_12_hour_format . '
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
    else
    {
        $sql = "SELECT * FROM event WHERE university_id = $university_id AND rso_id IS NULL AND approved = 1 AND privacy ='0'";
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
                $event_date = $row['date'];
                $phpdate = strtotime($event_date);
                $event_date = date( 'Y-m-d', $phpdate );
                $event_date = date( 'Y-m-d', $phpdate );
                $time_in_12_hour_format = date("g:i a", $phpdate);
                $dateArray = dateToChar($event_date);
                
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
                                    at ' . $time_in_12_hour_format .'
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
        
            
    
    
}

function getHomePageEventFeed($university_id, $user_id)
{
    include 'dbh.inc.php';
 	// First part of union gets any event that is approved, apart of the user's university, and user's rso
    // Second part of the union gets any event that at users university that is approved
    // third gets any public event
	$sql = "SELECT DISTINCT E.event_id, E.university_id, E.name, E.location, E.description, E.date, E.approved 
            FROM event E, user U, rso_membership M
            WHERE E.approved = '1' 
            AND (E.privacy = '0'
				OR (E.privacy = '1' 
					AND E.university_id = U.university_id
					AND U.user_id = '$user_id')
				OR (E.privacy = '2'
					AND E.rso_id = M.rso_id
					AND M.user_id = '$user_id'))
            ORDER BY E.date ASC";     
    

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
            $phpdate = strtotime($event_date);
            $event_date = date( 'Y-m-d', $phpdate );
            $time_in_12_hour_format = date("g:i a", $phpdate);
            $dateArray = dateToChar($event_date);
            
            $year = $dateArray[0];
            $month = $dateArray[1];
            $day = $dateArray[2];

            $test = intMonthToChar($month);
            
            $sql1 = "SELECT name FROM university WHERE university_id = $university_id";
            $result1= mysqli_query($conn, $sql1);
            $row = mysqli_fetch_assoc($result1);
            $university_name = $row['name'];
            
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
                        . $university_name . ' - '. $event_name .
                        '</p>
                        <p class ="eventlocation">
                            <img class = "icons" src=img/location.png>'
                            . $event_location . 
                        '</p>
                        <p class ="time">
                            <img class = "icons" src ="img/clock.png">
                                at ' . $time_in_12_hour_format . '
                        </p>
                        <p class = "eventdescription">'
                        . $event_description .
                        '</p>';
                
            $sql1 = "SELECT user_id FROM attendance WHERE event_id = '$event_id'";
            $result1 = mysqli_query($conn, $sql1) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
            $resultcheck1=mysqli_num_rows($result1);
            if($resultcheck1 > 0)
            {
                echo '<p class="eventdescription"><a style = "color: red" href="includes/leaveevent.php?event_key=' . $event_id . '">Leave Event</a></p>';
            }
            else
            {
                echo '<p class="eventdescription"><a style = "color: Green" href="includes/attendevent.php?event_key=' . $event_id . '">Attend This Event</a></p>';
            }
            echo '</div>
            </div>
            </a>';    
        }
    }
	
}

function getAdminApprovePage($university_id, $user_id, $privilege)
{
    include 'dbh.inc.php';

    if($privilege != '1')
    {
        header("Location: homepage.php?error=notadmin");
    }
    else
    {
        $sql = "SELECT * FROM event WHERE approved = '0'";
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
            $phpdate = strtotime($event_date);
            $event_date = date( 'Y-m-d', $phpdate );
            $time_in_12_hour_format = date("g:i a", $phpdate);
            $dateArray = dateToChar($event_date);
            
            $year = $dateArray[0];
            $month = $dateArray[1];
            $day = $dateArray[2];

            $test = intMonthToChar($month);
            
            $sql1 = "SELECT name FROM university WHERE university_id = $university_id";
            $result1= mysqli_query($conn, $sql1);
            $row = mysqli_fetch_assoc($result1);
            $university_name = $row['name'];
            
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
                        . $university_name . ' - '. $event_name .
                        '</p>
                        <p class ="eventlocation">
                            <img class = "icons" src=img/location.png>'
                            . $event_location . 
                        '</p>
                        <p class ="time">
                            <img class = "icons" src ="img/clock.png">
                                at ' . $time_in_12_hour_format . '
                        </p>
                        <p class = "eventdescription">'
                        . $event_description .
                        '</p>
                        <p class = "eventdescription">
                        <a style="color:Green" href="includes/approve.php?event_key=' . $event_id . '">Approve</a>
                        <a style="color: red" href="includes/refuse.php?event_key=' . $event_id . '">Refuse</a>                        
                        </p>
                            </div>
            </div>
            </a>';    
        }
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

function getUniversityRSO($user_id)
{
    include 'dbh.inc.php';
    $university_id = $_GET['value_key'];
    
    $sql = "SELECT name, description, active, rso_id FROM rso WHERE university_id = '$university_id' ORDER BY active DESC, name ASC";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    
    $checkUserRSO = "SELECT rso_id FROM rso_membership WHERE user_id = '$user_id'";
    $result1 = mysqli_query($conn, $checkUserRSO);
    $result1check =mysqli_num_rows($result1);
    
    if($resultcheck == 0)
    {
        echo '<p>There are no RSOs for this university</p>';
    }
    else
    {
        // loops through all rso
        while($row = mysqli_fetch_assoc($result))
        {
            $name = $row['name'];
            $description = $row['description'];
            $active = $row['active'];
            $rso_id = $row['rso_id'];
            $flag = 0;
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
                    
            echo  '</p>';
            // result1check returns rso_id of any rso the user is in
            // enters if he is in one
            
            $sql2 = "SELECT rso_id FROM rso_membership WHERE user_id = $user_id AND rso_id = $rso_id";
            $result2 = mysqli_query($conn, $sql2);
            $result2check = mysqli_num_rows($result2);
            
            // user is in this rso
            if($result2check > 0)
            {
                echo '<p class = "join-leave"><a href="includes/leaverso.php?value_key=' . $university_id . '&rso_key=' . $rso_id .'"><b>Leave RSO</b></a></p>'; 
            }
            else
            {
                echo '<p class = "join-leave"><a href="includes/joinrso.php?value_key=' . $university_id . '&rso_key=' . $rso_id .'"><b>Join RSO</b></a></p>';
            }

                    echo '</div>';
            
            
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
            
			echo $commentBody[$i] . '<br><br>';
			$i++;
		}
	}
}




























