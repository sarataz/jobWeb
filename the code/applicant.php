<?php 
  include('dbcon.php');
  include('session.php'); 

  $result=mysqli_query($con, "select * from jobprovider where id='$session_id'")or die('Error In Session');
  $row=mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <title>applicant</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="css/jobseeker.css">

</head>


<body class="text-color">
  <header>
    <div class="wrapper">
      <nav id="navbar">

        <label class="logo">
          <a href="index.php"> <img src="images/DB-logo.png" alt="" width="20"> </a>
        </label>
        <ul class="nav-area">
          <li><a href="index.php?logout=1">Log out</a></li>


        </ul>

      </nav>
    </div>
    <br><br><br>
  </header>


  <main>


    <!--- First section--->

    <div class="">
      <h1 class="text-size" style="font-size:40px; text-shadow: 2px 2px 8px #6087fd" ;>Welcome</h1>
      <br>
      <?php
        $id = (int)$_GET['id'];
        $query = mysqli_query($con, "SELECT * FROM jobSeeker WHERE id=$id");
        $row	= mysqli_fetch_array($query);
        $firstName = $row['first_name'];
        $lastName = $row['last_name'];
        $age = $row['age'];
        $quals = $row['qualifications'];
        $exp = $row['work_experience'];
        $langs = $row['languages'];
        $phone = $row['phone_number'];
        $email = $row['email_address'];
        $pass = $row['password'];

        echo ("
          <div class='box'>
          <p>First Name: $firstName</p>
          <p>Last Name: $lastName</p>
          <p>Age: $age</p>
          <p>Qualifications: $quals</p>
          <p>Work Experiences: $exp</p>
          <p>Languages: $langs </p>
          <p>Phone Number: $phone</p>
          <p>Email Address: $email</p>
          </div>"
        );
      ?> 
    </div>
    <br><br>
    <!--- End of First section--->


    <!--- second section--->

    <!---  Thired section--->
    <main>
      <footer>
        <div class="footer nav-area">
          <h6> &copy;Get A Job 2022</h6><br>
        </div>

      </footer>
</body>

</html>