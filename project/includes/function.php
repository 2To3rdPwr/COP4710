<?php


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

function getFormattedEvent()
{
    include 'dbh.inc.php';
    $university_id = $_GET['value_key'];
    $sql = "SELECT * FROM event WHERE university_id = $university_id";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    
    if($resultcheck == 0)
    {
        echo 'No Events';
        exit();
    }
    elseif($row = mysqli_fetch_assoc($result))
    {
        
        $university_id = $row['university_id'];
        $event_name = $row['name'];
        $event_location = $row['location'];
        $event_description = $row['description'];        
    }
    
    $dateArray = dateToChar($row['date']);
    $year = $dateArray[0];
    $month = $dateArray[1];
    $day = $dateArray[2];
    
    $test = intMonthToChar($month);
    
    
    echo    '<a href="#">
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
    </a>
    '
        
        ;
    
            
    $sql = "select name FROM university WHERE university_id = $university_id";
    $result = mysqli_query($conn, $sql);
    
    
    if($row = mysqli_fetch_assoc($result))
    {
        $event_university = $row['name'];
        
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
        echo '<ul class ="university-list">';
        // runs through query of everything from university
        while($row = mysqli_fetch_assoc($result))
        {
            $university_name = $row['name'];
            $university_id = $row['university_id'];
            echo '<li> <a href="university.php?value_key=';
            echo $university_id;
            echo '">';
            echo $university_name;
            echo '</a></li>';

        }
        
        echo '</ul>';
    }
}





























