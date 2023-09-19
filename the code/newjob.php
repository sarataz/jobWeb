<?php 
  include('dbcon.php');
  include('session.php'); 

  $result=mysqli_query($con, "select * from jobprovider where id='$session_id'")or die('Error In Session');
  $row=mysqli_fetch_array($result);

?>

<!DOCTYPE html>

<html>

<head>
    <title>add new job offer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!-- STYLE CSS -->
    <link rel="stylesheet" href="css\newjob.css">
</head>

<body style="
      background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
        url(images/1.jpeg);
      height: 25vh;

      background-position: center center;
    ">
    <header>
        <div class="wrapper">
            <nav id="navbar">
                <label class="logo">
                    <a href="index.php">
                        <img src="images/DB-logo.png" alt="" width="20" />
                    </a>
                </label>
                <ul class="nav-area">
                    <li><a href="index.php?logout=1">Log out</a></li>
                </ul>
            </nav>
        </div>
        <br /><br /><br />
    </header>

    <div class="wrapper">
      <div class="inner">
        <form action="#" method="post">
          <h3>Add new job offer</h3>
          <div class="form-group">
              <input type="text" name="category" required placeholder="job category" class="form-control" />
              <input type="text" required name="title" placeholder="job title" class="form-control" />
          </div>
          <div class="form-wrapper">
              <input type="text" required name="full-time" placeholder="full-time / part-time"
                  class="form-control" />
          </div>
          <div class="form-wrapper">
              <input type="number" required placeholder="salary" name="salary" class="form-control" />
          </div>
          <div class="form-wrapper">
              <input class="form-control" required type="text" name="location" placeholder="Enter location" />
          </div>
          <div class="form-wrapper">
              <input name="desc" required type="text" placeholder="description" class="form-control" />
          </div>

          <div class="form-wrapper">
              <input type="text" required name="req" placeholder="requirements" class="form-control" />
          </div>
          
          <input type="submit" id="btn" title="add job" name="newjob" value="Add Job"></input>

          <?php if (isset($_POST['newjob']))
            echo"<br><h4 class='ok' style='text-align:center;'>New job was added successfully!</h4>";
          ?>

        </form>
      </div>
    </div>


    <?php
    if (isset($_POST['newjob'])){
      $cat = mysqli_real_escape_string($con, $_POST['category']);
      $query = mysqli_query($con, "select * from jobCategory where category = '$cat'");
      $num_row 	= mysqli_num_rows($query);
      if($num_row == 0){
        $query = mysqli_query($con, "insert into jobCategory(category) values ('$cat')");
        $query = mysqli_query($con, "select * from jobCategory  where category = '$cat'");
      } 
      
      $cat_id = mysqli_fetch_array($query)[0];
      $title= mysqli_real_escape_string($con, $_POST['title']);
      $fulltime= mysqli_real_escape_string($con, $_POST['full-time']);
      $salary= (int)mysqli_real_escape_string($con, $_POST['salary']);
      $location= mysqli_real_escape_string($con, $_POST['location']);
      $desc= mysqli_real_escape_string($con, $_POST['desc']);
      $req= mysqli_real_escape_string($con, $_POST['req']);
      $query = mysqli_query($con, "
        insert into jobOffer(
          job_provider_id,
          job_category_id,
          title,
          full_time,
          salary,
          location,
          description,
          requirements
        )
        values(
          $session_id,
          $cat_id,
          '$title',
          '$fulltime',
          $salary,
          '$location', 
          '$desc',
          '$req'
        )
      ");
      $query = mysqli_query($con, "SELECT * FROM joboffer ORDER BY ID DESC LIMIT 1");
      $id = mysqli_fetch_array($query)[0];
      header("location:jobdetail.php?id=$id");
    }
    ?>

    <footer>
        <div class="footer nav-area">
            <h6>&copy;Get A Job 2022</h6>
            <br>
        </div>
    </footer>
</body>

</html>