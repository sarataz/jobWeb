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
  <link rel="stylesheet" href="css/signupseek.css" />

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
        <h3>Registration Form</h3>
        <div class="form-group">
          <input type="text" required placeholder="First Name" name="first_name" class="form-control" />
          <input type="text" required placeholder="Last Name" name="last_name" class="form-control" />
        </div>
        <div class="form-wrapper">
          <input type="number" required placeholder="Age" name="age" class="form-control" />
          <i class="zmdi zmdi-account"></i>
        </div>
        <div class="form-wrapper">
          <input type="email" name="email" required placeholder="Email Address" class="form-control" />
          <i class="zmdi zmdi-email"></i>
        </div>
        <div class="form-wrapper">
          <label for="phone">Enter your phone number:</label>
          <input required class="form-control" type="tel" id="phone" name="phone" placeholder="+966*********" pattern="[0-9]{8}" required />
          <i class="zmdi zmdi-phone"></i>
        </div>
        <div class="form-wrapper">
          <label for="qual">Qualifications:</label>
          <input name="quals" type="text" required placeholder="Qualifications" class="form-control" />
          <i class="zmdi zmdi-qual"></i>
        </div>

        <div class="form-wrapper">
          <input type="text" required placeholder="Work experience" name="exp" class="form-control" />
          <i class="zmdi zmdi-work"></i>
        </div>
        <div class="form-wrapper">
          <input type="text" placeholder="Languages" name="langs" required class="form-control" />
          <i class="zmdi zmdi-languages"></i>
        </div>

        <div class="form-wrapper">
          <input type="password" name="pass" placeholder="Password" class="form-control" required />
          <i class="zmdi zmdi-lock"></i>
        </div>

        <input type="submit" id="btn" title="Register" name="signup" value="signup"></input>
        <?php
        if (isset($_POST['signup'])) {
          $useremail = mysqli_real_escape_string($con, $_POST['email']);
          $password = mysqli_real_escape_string($con, $_POST['pass']);
          $firstName = mysqli_real_escape_string($con, $_POST['first_name']);
          $lastName = mysqli_real_escape_string($con, $_POST['last_name']);
          $age =  (int)mysqli_real_escape_string($con, $_POST['age']);
          $phone = mysqli_real_escape_string($con, $_POST['phone']);
          $quals = mysqli_real_escape_string($con, $_POST['quals']);
          $exp = mysqli_real_escape_string($con, $_POST['exp']);
          $langs = mysqli_real_escape_string($con, $_POST['langs']);

          $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

          $query = mysqli_query($con, "SELECT * FROM jobseeker WHERE email_address='$useremail'");
          $row    = mysqli_fetch_array($query);
          $num_row   = mysqli_num_rows($query);

          if ($num_row > 0) {
            echo "<br><h5 class='err'>This email has already registerd!</h5>";
          } else {

            $query = mysqli_query(
              $con,
              "insert into jobseeker(
                  first_name, last_name, age, qualifications, work_experience,
                  languages, phone_number, email_address, password
                )
                values(
                  '$firstName', 
                  '$lastName',
                  $age,
                  '$quals',
                  '$exp',
                  '$langs',
                  '$phone',
                  '$useremail',
                  '$hashed_pass')"
            );
            $query = mysqli_query($con, "SELECT * FROM jobseeker WHERE email_address='$useremail'");
            $row = mysqli_fetch_array($query);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = 'seeker';
            header('location:seekerHomePage.php');
          }

          $query = mysqli_query($con, "SELECT * FROM jobseeker WHERE email_address='$useremail'");
          $row    = mysqli_fetch_array($query);
          $num_row   = mysqli_num_rows($query);
          $_SESSION['role'] = 'seeker';
          $_SESSION['user_id'] = $row['id'];
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