<?php
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
      
    <style>
        .practicecontainer
        {
        position:relative;
	   z-index:2;
        margin: auto;
        padding: 20px;
        width: 80%;
        height: 1000px;
          padding-top: 100px;

            
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
              <a class="nav-link js-scroll-trigger" href="university.php">University</a>
            </li>
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
    
    <div class="practicecontainer">

          <div class="event">
              <div class ="eventheader">
                    <h1 style = "color: white">Profile</h1>
              </div>
              <div class="eventfeed">
				<?php
				include 'includes/dbh.inc.php';
					$userID = $_SESSION['u_id'];
					//get user info
					$userUniv;
					$userEmail;
					$userFirst;
					$userLast;
					$superAdminStatus;
	   
					$sql = "SELECT user.* FROM user WHERE (user.user_id = $userID)";
					$result = mysqli_query($conn, $sql);
					echo("Error description: " . mysqli_error($conn));
					while($row = mysqli_fetch_assoc($result))
					{
						$userFirst = $row["firstname"];
						$userLast = $row["lastname"];
						$userUniv = $row["university_id"];
						$userEmail = $row["email"];
						$superAdminStatus = $row["permission_level"];
					}
					$sql = "SELECT university.name FROM university WHERE (university.university_id = $userUniv)";
					$result = mysqli_query($conn, $sql);
					while($row = mysqli_fetch_assoc($result))
						$userUniv = $row["name"];
					echo "<p> Name: ".$userFirst." ".$userLast."<br>E-mail Address: ".$userEmail."<br>University: ".$userUniv."<br></p>";
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
        <p>Copyright &copy; Your Website 2018</p>
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
