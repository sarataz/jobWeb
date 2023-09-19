<?php 
  include('dbcon.php');
  include('session.php'); 

  $result=mysqli_query($con, "select * from jobSeeker where id='$session_id'")or die('Error In Session');
  $row=mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <title>job offer details</title>

    <link rel='preconnect' href='https://fonts.googleapis.com' />
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin />
    <link href='https://fonts.googleapis.com/css2?family=Work+Sans:wght@300&display=swap' rel='stylesheet' />

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' />

    <link rel='stylesheet' href='css/ProviderHomePage.css' />
</head>

<body class='text-color'>
    <header>
        <div class='wrapper'>
            <nav id='navbar'>
                <label class='logo'>
                    <a href='index.php'>
                        <img src='images/DB-logo.png' alt='' width='20' />
                    </a>
                </label>
                <ul class='nav-area'>
                    <li><a href='index.php?logout=1'>Log out</a></li>
                </ul>
            </nav>
        </div>
        <br /><br /><br />
    </header>

    <main>
        <!--- second section--->
        <h1 class='text-size' style='font-size: 40px; text-shadow: 2px 2px 8px #6087fd'>
            JOB offers
        </h1>
        <br />
        <div class='text-size'>
            <?php
          $job = (int)$_GET['id'];
          if($_SESSION['role'] == 'seeker'){

            $query = mysqli_query($con,
              "SELECT id FROM jobApplication 
              WHERE jobApplication.job_seeker_id= $session_id
              AND jobApplication.job_offer_id= $job
            ");
            
            $num_row = mysqli_num_rows($query);
            
            if($num_row == 0) echo("
              <form action='' method='post' style='display:inline;'>
                <input type='submit' title='apply' name='apply' value='Apply'
                  style='text-decoration:underline;background:transparent;color:white;border:0px;font-size:20px;padding:0;cursor:pointer;'
                  />
              </form>
            ");
            else echo"<h3>Applied!</h3>";
          }
          if($_SESSION['role'] == 'provider')
            echo"<a href='Edit.php?id=$job' style='color: #fff; text-decoration: underline'>Edit</a>";

          if(isset($_POST['apply'])){
            $query = mysqli_query($con,"
              insert into jobApplication(job_offer_id, job_seeker_id, application_status_id)
              values($job, $session_id, 3);
            ");
            header("location:seekerHomePage.php");
          }
        ?>
        </div>

        <br />
        <br />
        <table>
            <caption style='text-align: left; font-weight: bold; font-size: 20px'>
                Job Informations
            </caption>
            <tr>
                <th>Job category</th>
                <th>Job Title</th>
                <th>full-time / part-time</th>
                <th>salary</th>
                <th>location</th>
                <th>description</th>
                <th>requirements</th>
            </tr>

            <?php
          if (!isset($_GET['id'])) {
            if($_SESSION['role']=='seeker')
              header('location:seekerHomePage.php');
            if($_SESSION['role']=='provider')
              header('location:ProviderHomePage.php');
          }
          $job = (int)$_GET['id'];
          $query = mysqli_query($con,"
            SELECT jobCategory.category, joboffer.* FROM joboffer 
            inner join jobCategory on jobOffer.job_category_id = jobCategory.id
            WHERE joboffer.id = $job;
          ");
          $row = mysqli_fetch_array($query);
          echo("<tr>
            <td style='color: white'>$row[0]</td>
            <td style='color: white'>$row[4]</td>
            <td style='color: white'>$row[5]</td>
            <td style='color: white'>$row[6]</td>
            <td style='color: white'>$row[7]</td>
            <td style='color: white'>$row[8]</td>
            <td style='color: white'>$row[9]</td>
          </tr>");
        ?>
        </table>
        <br /><br /><br />
        <!---  END of  second section--->
    </main>
    <!--- second section--->

    <br />
    <table>
        <caption style='text-align: left; font-weight: bold; font-size: 20px'>
            Job Provider Informations
        </caption>
        <tr>
            <th>Name</th>
            <th>Main location</th>
            <th>Phone Number</th>
            <th>Email Address</th>
        </tr>
        <?php
        $job = (int)$_GET['id'];
        $query = mysqli_query($con,"
          select * from jobProvider where jobProvider.id = (
            select job_provider_id from jobOffer
            where jobOffer.id= $job
          )
        ");
        $row = mysqli_fetch_array($query);
        echo("<tr>
          <td style='color: white'>$row[1]</td>
          <td style='color: white'>$row[2]</td>
          <td style='color: white'>$row[3]</td>
          <td style='color: white'>$row[4]</td>
        </tr>")
      ?>
    </table>
    <br /><br /><br />
    <!---  END of  second section--->

    <footer>
        <div class='footer nav-area'>
            <h6>&copy;Get A Job 2022</h6>
            <br />
        </div>
    </footer>
</body>

</html>