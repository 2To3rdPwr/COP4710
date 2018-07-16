<?php
                    include 'includes/function.php';

    session_start();
    if(!isset($_SESSION['u_id'])){
        
       header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>College Event Manager</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Cabin:700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="css/homepage.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
      
                  <script type="text/javascript">
        function toggle_visibility(id, container) {
            var e = document.getElementById(id);
            var container = document.getElementById(container);
            if(e.style.display == 'block')
            {
                e.style.display = 'none';
                container.style.filter = 'blur(0px)';
            }
            else{
                e.style.display = 'block';
                container.style.filter = 'blur(3px)';
            }
        }

    </script>
    <script>
        window.addEventListener('mouseup', function(event)
        {
            var box = document.getElementById('box1');
            var toggle = document.getElementById('toggle');
            var container = document.getElementById('container');
            if(event.target == box && event.target.parentNode != box)
                {
                    box.style.display= 'none';
                    container.style.filter ='blur(0px)';
                }
                                });

    </script>
      
    <style>
                ::-webkit-scrollbar
        {
            border-radius: 10px;
            width: 15px;
            background-color:rgba(77,77,77,0.75);
        }
        ::-webkit-scrollbar-thumb
        {
            border-radius:10px;
            background-color:rgba(255,255,255,0.15);
        }

        .practicecontainer
        {
        position:relative;
        margin: auto;
        padding: 20px;
        width: 80%;
        height: 1000px;
        padding-top: 100px;
        filter: blur(0px);
        }
        .event
        {
        float: left;
        padding: 20px;
        width: 100%;
        height:800px;
        background-color: rgba(77,77,77,0.75);
        border-radius:25px;
        }
        .eventheader
        {
            width: 100%;
            height:auto;
        }
        .eventfeed
        {
            height:auto;
            width: auto;
            overflow:auto;
        }
        
        .practicecontainer3
        {
            float: right;
            padding: 20px;
            width: 50%;
            height: 435px;
            background-color: black;
        }
        
        .practicecontainer4
        {
            float: right;
            padding: 20px;
            width: 50%;
            height: 435px;
            background-color: purple;
        }
        .profile-information
        {
            color: black;
        }
        .profile-rso
        {
            margin-top: -30px;
            margin-left: 20px;
            color: black;
        }
        .add
        {
            float: right;
            padding-top: 8px;
        }
        .popupBoxWrapper
        {
            width: 750px;
            height: 500px;
            margin: 250px auto; 
            text-align: Center;
            margin-top: 100px;
        }
        .background
        {
            top: 0; 
            left: 0; 
            position: fixed; 
            float: left;
            width: 100%; 
            height: 100%; 
            background-color: rgba(0,0,0,0.7); 
            display: none;
            z-index: 2;
        }
        .rso-information
        {
            float: left;
            margin-bottom: 0px;
        }
        .rso-profile
        {
            border: black 1px;
            width: 100%;
            border-radius: 25px;
            float: left;
            background-color: red;
        }
        .rso-details
        {

            font-size: 20px;
            color: black;
            padding-top: 5px;
            padding-left: 10px;
            margin-bottom: 5px;
        }
        .rso-name
        {
            font-weight: bold;
        }
        .details
        {
            background-color: white;
        }
        .rso-form
        {
            margin-bottom: -10px;
        }
        .edit-info
        {
            height: 750px;
            overflow-y: auto;
        }



    </style>
      


  </head>

  <body id="page-top">
      

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="homepage.php">Event Manager</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">About</a>
            </li>
                          <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="universitylist.php">University</a>
            </li>
                          <?php
              $permission = $_SESSION['privilege'];
              if($permission == '1')
              {
                echo '<li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="admin.php">Admin</a>
                </li>';
              }
              else
              {
                  ;
              }
            ?>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="profile.php">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="includes/logout.inc.php">LogOut</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Intro Header -->
    <header class="masthead">

    </header>
      
             <div id ="box1" class="background">
            <div class="popupBoxWrapper">
                <div id="toggle" class="rso-form">
                    <div class="form">
                  
                    <div class="tab-content">
                    <div id="login" class="edit-info">   
                        <h1>Edit Profile Information</h1>

                        <form id = "myForm" action="includes/edit.inc.php" method="post">
                            <div class="field-wrap">
                                <p class="rso-information">First Name</p>
                                <?php
                                    include_once 'includes/dbh.inc.php';
                                    $user_id = $_SESSION['u_id'];
                                    $sql = "SELECT firstname from user where user_id = '$user_id'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $first = $row['firstname'];
                                    echo '<input class="rso-form" name ="first" value ="' . $first . '" autocomplete="off"/>';
                                ?>       
                            </div>
                            
                            <div class="field-wrap">
                                <p class="rso-information">Last Name</p>
                                <?php
                                    include_once 'includes/dbh.inc.php';
                                    $user_id = $_SESSION['u_id'];
                                    $sql = "SELECT lastname from user where user_id = '$user_id'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $last = $row['lastname'];
                                    echo '<input class="rso-form" name ="last" value ="' . $last . '" autocomplete="off"/>';
                                ?>   
                            </div>
                            
                            <div class="field-wrap">
                                <p class="rso-information">E-mail</p>
                                <?php
                                    include_once 'includes/dbh.inc.php';
                                    $user_id = $_SESSION['u_id'];
                                    $sql = "SELECT email from user where user_id = '$user_id'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $email= $row['email'];
                                    echo '<input class="rso-form" name ="email" type="email" value ="' . $email . '" autocomplete="off"/>';
                                ?>   
                            </div>

                            <div class="field-wrap">
                                <p class="rso-information">University</p>
                                <?php
                                    include_once 'includes/dbh.inc.php';
                                    $user_id = $_SESSION['u_id'];
                                    $sql = "SELECT U.name from university U, user U1 where U.university_id = U1.university_id AND user_id = '$user_id'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $university_name= $row['name'];
                                    echo '<input class="rso-form" name ="university" type="text" list ="universities" value ="' . $university_name . '" autocomplete="off"/>';
                                ?>  
                                <datalist id="universities">
                                    <option>Not Listed</option>
                                    <?php
                                        formatSignUpUniversity();
                                    ?>
                                </datalist>
                            </div>
                            
                            <div class="field-wrap">
                                <p class="rso-information">Password</p>
                                <input type="password"autocomplete="off" name="password"/>
                            </div>

                            <div class="field-wrap">
                                <p class="rso-information">Retype Password</p>
                                <input type="password" autocomplete="off" name="confirm_password"/>
                            </div>
                            

                            <input class = "button button-block" type="submit" name = "submit" value = "SUBMIT">
                        </form>
                    </div>
                    <?php
                        $fullurl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    
                        if(strpos($fullurl, "error=nametaken") == true)
                        {
                            echo "<script type ='text/javascript'>                            
                            toggle_visbility('box1', 'container');</script>";
                            echo '<p style= "color:red">This University Profile has already been made</p>';
                        }
                    ?>
                    
                    <div id="signup">   
                          <h1>Sign Up for Free</h1>

                          <form action="includes/register.inc.php" method="POST">
                              <div class="top-row">
                                <div class="field-wrap">
                                  <label>
                                    First Name<span class="req"></span>
                                  </label>
                                  <input type="text" required autocomplete="off" name="firstname" />
                                </div>

                                <div class="field-wrap">
                                  <label>
                                    Last Name<span class="req"></span>
                                  </label>
                                  <input type="text"required autocomplete="off" name ="lastname"/>
                                </div>
                              </div>

                              <div class="field-wrap">
                                <label>
                                  Email Address<span class="req"></span>
                                </label>
                                <input type="email"required autocomplete="off"/ name ="email">
                              </div>                              

                              <div class="field-wrap">
                                <label>
                                  Password<span class="req"></span>
                                </label>
                                <input type="password"required autocomplete="off" name="password"/>
                              </div>
                              
                              <div class="field-wrap">
                                <label>
                                  Retype Password<span class="req"></span>
                                </label>
                                <input type="password"required autocomplete="off" name="confirm_password"/>
                              </div>
                              
                              <p class="forgot">Already have an account? <a href="index.php">Log In</a></p>

                              <input class = "button button-block" type="submit" name = "register" value = "SIGN UP">
                          </form>
                        

                    </div>
                </div><!-- tab-content -->
              </div> <!-- /form -->
            </div>
        </div>
    </div>
    
    <div class="practicecontainer" id ="container">

        <div class="event">
            <div class ="eventheader">
                <h1 style = "color: black">Profile
                <a href="#"><img class ="add" src="img/edit.png " onclick="toggle_visibility('box1', 'container')"></a>
                </h1>
            </div>
            
            <div class="eventfeed">
                <?php
                    $user_id = $_SESSION['u_id'];
                    getProfilePage($user_id);
                ?>

            </div>
        </div>


    </div>


    <!-- Map Section 
    <div id="map"></div>

    -->

      
    <!-- Footer -->
    <footer>
      <div class="container text-center">
        <p>Copyright &copy; College Event Manager 2018</p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Google Maps API Key - Use your own API key to enable the map feature. More information on the Google Maps API can be found at https://developers.google.com/maps/ -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRngKslUGJTlibkQ3FkfTxj3Xss1UlZDA&sensor=false"></script>

    <!-- Custom scripts for this template -->
    <script src="js/grayscale.min.js"></script>
    <script src="js/login.js"></script>

  </body>

</html>
