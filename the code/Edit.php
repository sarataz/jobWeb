<?php
  include('dbcon.php');
  include('session.php');

  $result = mysqli_query($con, "select * from jobprovider where id='$session_id'") or die('Error In Session');
  $row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Edit</title>
  <meta name='viewport' content='width=device-width, initial-scale=1.0' />

  <!-- MATERIAL DESIGN ICONIC FONT -->
  <link rel='stylesheet' href='fonts/material-design-iconic-font/css/material-design-iconic-font.min.css' />
  <link rel='preconnect' href='https://fonts.googleapis.com' />
  <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin />
  <link href='https://fonts.googleapis.com/css2?family=Work+Sans:wght@300&display=swap' rel='stylesheet' />

  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' />
  <!-- STYLE CSS -->
  <link rel='stylesheet' href='css/Edit.css' />
</head>

<body style='
      background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
        url(images/1.jpeg);
      height: 25vh;
      -webkit-background-size: cover;
      background-size: cover;
      background-position: center center;
  '>

  <header>
    <div class='wrapper'>
      <nav id='navbar'>
        <label class='logo'><a href='index.php'><img src='images/DB-logo.png' alt='' width='20' /></a></label>
        <ul class='nav-area'><li><a href='index.php?logout=1'>Log out</a></li></ul>
      </nav>
    </div>
    <br><br><br>
  </header>

  <div class='wrapper'>
    <div class='inner'>
      <form action='' method='post'>
        <h3>Edit job offer</h3>
        <?php

        if (!isset($_GET['id'])) {
          header('location:seekerHomePage.php');
        }
        $job = (int)$_GET['id'];
        $query = mysqli_query($con, "
            SELECT jobCategory.category, joboffer.* FROM joboffer 
            inner join jobCategory on jobOffer.job_category_id = jobCategory.id
            WHERE joboffer.id = $job;
          ");
        $row = mysqli_fetch_array($query);
        echo ("
            <div class='form-group'>
              <input type='text' name='cat' value='$row[0]' class='form-control' />
              <input type='text' name='title' value='$row[4]' class='form-control' />
            </div>
            <div class='form-wrapper'>
              <input type='text' name='full-time' value='$row[5]' class='form-control' />
            </div>
            <div class='form-wrapper'>
              <input type='number' name='salary' value='$row[6]' class='form-control' />
            </div>
            <div class='form-wrapper'>
              <input class='form-control' name='location' type='text' value='$row[7]' />
            </div>
            <div class='form-wrapper'>
              <input
                name='desc'
                type='text'
                value='$row[8]'
                class='form-control'
              />
            </div>

            <div class='form-wrapper'>
              <input
                type='text'
                name='req'
                value='$row[9]'
                class='form-control'
              />
            </div>
          ");
        ?>
        <input type='submit' class='btn' title='Edit' name='edit' value='Edit'></input>
      </form>
    </div>
  </div>

  <?php
  if (isset($_POST['edit'])) {
    $cat = mysqli_real_escape_string($con, $_POST['cat']);
    $query = mysqli_query($con, "select * from jobCategory where category = '$cat'");
    $num_row   = mysqli_num_rows($query);
    if ($num_row == 0) {
      $query = mysqli_query($con, "insert into jobCategory(category) values ('$cat') ");
      $query = mysqli_query($con, "select * from jobCategory where category = '$cat'");
    }
    $cat_id = mysqli_fetch_array($query)[0];
    $job_id = (int)$_GET['id'];

    $title = mysqli_real_escape_string($con, $_POST['title']);
    $fulltime = mysqli_real_escape_string($con, $_POST['full-time']);
    $salary = (int)mysqli_real_escape_string($con, $_POST['salary']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $desc = mysqli_real_escape_string($con, $_POST['desc']);
    $req = mysqli_real_escape_string($con, $_POST['req']);

    $query = mysqli_query(
      $con,
      "
          UPDATE joboffer 
          SET 
            job_category_id = $cat_id,
            title = '$title',
            full_time = '$fulltime',
            salary = $salary,
            location = '$location',
            description = '$desc',
            requirements = '$req'
          WHERE joboffer.id = $job_id;"
    );
    echo "<script>
      alert('The job offer was edited successfully!');
      window.location.href='jobdetail.php?id=$job_id';
    </script>";
  }
  ?>
  <footer>
    <div class='footer nav-area'>
      <h6>&copy;Get A Job 2022</h6>
      <br />
    </div>
  </footer>
</body>

</html>