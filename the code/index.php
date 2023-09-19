<?php
  session_start();
  if(isset($_GET['logout'])){
    session_destroy();
  }

  if (isset($_SESSION['user_id'])){
    if($_SESSION['role'] == 'seeker') header('location:seekerHomePage.php');
    else  header('location:ProviderHomePage.php');
  }
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Get A Job </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/hp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>



    <!-- welcome-->

    <header>
        <div class="wrapper">
            <nav id="navbar">

                <a href="index.php" class="logo"> <img src="images/DB-logo.png" alt=""> </a>

                <ul class="nav-area">


                    <li><a href="index.php#aboutus">Our Featrues </a></li>
                    <li><a href="index.php#contactus">Contact Us</a></li>
                    <li><a href="index.php">Home</a></li>
                </ul>

            </nav>
        </div>

        <div class="welcome-text ">
            <div class="">
                <h1>Your Dream <br> job is <span>waiting..</span></h1>
                <a href="seekerlogin.php" class="btn btn-log">JOB SEEKER LOG-IN</a>
                <a href="providerlogin.php" class="btn btn-log">JOB PROVIDER LOG-IN </a> <br><br>
                <p style="color: white ;"> New Job seeker ?<a style="color:#88b3dd ; padding:2px 10px ;"
                        href="signupseek.php" class="sing">sign Up</a></p>
            </div>
        </div>
    </header>


    <!-- welcome-->

    <!--Our Featrues------  ------------------------------------------------------------------->
    <section id="aboutus">
        <div class="au mr">
            <h1>Our <span>Featrues</span></h1>
            <br>

            <div class="OurServicesTitle">

                <div class="OurServices">
                    <div class="os-box">
                        <img src="images/search.png" alt=" Search millions of jobs " class="img-os">
                        <h3 style="color: white;">Search Millions of jobs </h3>
                    </div>

                    <div class="os-box">
                        <img src="images/manage.png" alt=" Easy to manage jobs " class="img-os">
                        <h3 style="color: white;">Easy to manage jobs</h3>
                    </div>

                    <div class="os-box">
                        <img src="images/top.png" alt=" Top Careers " class="img-os">
                        <h3 style="color: white;">Top Careers </h3>
                    </div>




                </div>
    </section>

    <!--Our Featrues------------------------------------------------------------------------->




    <section id="contactus">
        <div class="au ">
            <h1>Contact <span>US</span></h1>
        </div>
        <br>
        <br>

        <div class="contact-info ">
            <div class="card">
                <i class="card-icon far fa-envelope"></i>
                <p>Get_A_job@gmail.com</p><br>
            </div>

            <div class="card">
                <i class="card-icon fas fa-phone"></i>
                <p>+000000000000</p><br>
            </div>

            <div class="card tw">
                <i class="card-icon fab fa-twitter"></i>
                <p>@Get_A_job</p>
            </div>
        </div>


    </section>



    <footer>
        <div class="footer ">
            <h6>&copy;Get A Job 2022</h6>
            <br />
        </div>
    </footer>

</body>

</html>