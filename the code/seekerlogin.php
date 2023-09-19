<?php session_start(); ?>
<?php include('dbcon.php'); ?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign up for job seeker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="./css/seekerlogin.css" />

    <meta charset="UTF-8" />
</head>

<body>
    <div class="wrapper" style="
        background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
          url(images/1.jpeg);
        -webkit-background-size: cover;
        background-size: cover;
        background-position: center center;
      ">
        <nav id="navbar">
            <a href="index.php" class="logo">
                <img src="images/DB-logo.png" alt="" />
            </a>
        </nav>
        <div class="inner">
            <form action="#" method="post">
                <h3>Login seeker</h3>

                <div class="form-wrapper">
                    <input name="user" type="text" placeholder="Email Address" class="form-control" />
                    <i class="zmdi zmdi-email"></i>
                </div>

                <div class="form-wrapper">
                    <input name="pass" type="password" placeholder="Password" class="form-control" />
                </div>

                <input type="submit" class="btn" title="Log In" name="login" value="Login"></input>
                <?php
            if (isset($_POST['login'])){
              $username = mysqli_real_escape_string($con, $_POST['user']);
              $password = mysqli_real_escape_string($con, $_POST['pass']);
              
              $query = mysqli_query($con, "SELECT * FROM jobseeker WHERE email_address='$username'");
              $row		= mysqli_fetch_array($query);
              $num_row 	= mysqli_num_rows($query);
              
              if ($num_row > 0 && password_verify($password, $row['password'])){			
                $_SESSION['user_id']=$row['id'];
                $_SESSION['role']='seeker';
                header('location:seekerHomePage.php');
              }
              else{
                echo "<h5 class='err'>Invalid Username and Password Combination</h5>";
              }
            }
          ?>

            </form>
        </div>
        <footer>
            <div class="footer nav-area">
                <h6>&copy;Get A Job 2022</h6>
                <br />
            </div>
        </footer>
    </div>
</body>

</html>