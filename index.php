<?php
    include 'includes/function.php';
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
    <link href="css/indexpage.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
      
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

.intro-body
{
        position:relative;
	   z-index:2;
        margin: auto;
        padding: 20px;
        width: 80%;
        height: 1000px;
          padding-top: 100px;

}
        .dropdown
        {
          font-size:22px;
          width:100%;
          height:100%;
          padding:5px 10px;
          background-color:rgba(128,128,128,0.75);
          color: white;
          border-radius:25px;
          border-color:(128,128,128,0.75);
        }
        
    </style>
      


  </head>

  <body id="page-top">
      
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['login'])) { //user logging in

        require 'includes/login.inc.php';
        
    }
    
    elseif (isset($_POST['register'])) { //user registering
        
        require 'includes/register.inc.php';
        
    }
}
?>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="index.php">Event Manager</a>
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
              <a class="nav-link js-scroll-trigger" href="index.php">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Intro Header -->
    <header class="masthead">

    </header>
      
    <div class="intro-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="form">
                        <ul class="tab-group">
                        <li class="tab active"><a href="#login">Log In</a></li>
                        <li class="tab"><a href="#signup">Sign Up</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="login">   
                                <h1>Welcome Back!</h1>

                                <form action="includes/login.inc.php" method="post">
                                    <div class="field-wrap">
                                        <label>E-mail<span class="req"></span></label>
                                        <input type="email" name ="email" required autocomplete="off"/>
                                    </div>

                                    <div class="field-wrap">
                                        <label>Password<span class="req"></span></label>
                                        <input type="password" name = "password" required autocomplete="off"/>
                                    </div>

                                    <p class="forgot"><a href="#">Forgot Password?</a></p>

                                    <input class = "button button-block" type="submit" name = "login" value = "LOG IN">
                                </form>
                                </div>

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
                                            Select Your University<span class="req"></span>
                                            </label>
                                            <input name = "university" type="text" list="universities" />
                                            <datalist id="universities">
                                                <option>Not Listed</option>
                                                <?php
                                                    formatSignUpUniversity();
                                                ?>
                                            </datalist>
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
