<?php
include('dbcon.php');
include('session.php');
$result = mysqli_query($con, "select * from jobprovider where id='$session_id'") or die('Error In Session');
$row = mysqli_fetch_array($result);
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <title>provider Home Page </title>

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/ProviderHomePage.css">

</head>


<body class="text-color">
  <header>
    <div class="wrapper">
      <nav id="navbar">
        <label class="logo"><a href="index.php"> <img src="images/DB-logo.png" alt="" width="20"> </a></label>
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
      <?php
      $query = mysqli_query($con, "SELECT * FROM jobprovider WHERE id=$session_id");
      $row  = mysqli_fetch_array($query);
      echo ("<h1 class='text-size'>Welcome {$row['name']}<span></span></h1>");
      ?>
      <br>
      <div class="box">
        <?php
        echo ("
        <p>Name: {$row['name']}</p>
        <p>Main location: {$row['main_location']}</p>
        <p>Phone: {$row['phone_number']}</p>
        <p>Email: {$row['email_address']}</p>
      ");
        ?>
      </div>
      <br><br>
      <!--- End of First section--->

      <!--- second section--->
      <h1 class="text-size">Received <span>Application</span></h1>

      <br>

      <table>
        <tr>
          <th>Job Title</th>
          <th>Applicants</th>
          <th>Status</th>
          <th>update Status</th>
        </tr>

        <?php
        $query = mysqli_query($con, "
      select
      joboffer.title, 
      concat(jobSeeker.first_name, ' ', jobSeeker.last_name) as name, 
      applicationstatus.status,
      jobApplication.id,
      jobSeeker.id,
      jobOffer.id
      from jobProvider
      inner join jobOffer on jobOffer.job_provider_id = jobProvider.id
      inner join jobApplication on jobApplication.job_offer_id = jobOffer.id
      inner join jobSeeker on jobApplication.job_seeker_id = jobSeeker.id
      inner join ApplicationStatus on jobApplication.application_status_id = ApplicationStatus.id
      where jobProvider.id= $session_id
      group by(jobApplication.id)
    ");

        $apps  = mysqli_fetch_all($query);
        $num_row = mysqli_num_rows($query);

        if ($num_row == 0) echo ("<tr><td colspan=4>No applications were found!</td></tr>");

        foreach ($apps as $row) {
          echo ("
            <tr>
            <td><a href='jobdetail.php?id=$row[5]'   style='color: #fff; margin-top:10px;'>$row[0]</a></td>
            <td><a href='applicant.php?id={$row[4]}' style='color:white;'>{$row[1]}<p></td>
            <td id='status{$row[3]}'>{$row[2]}</td>
            <td><select class='updateJobApp' onchange='updateApp(this, event)'>
          ");

          $query   = mysqli_query($con, "SELECT * FROM applicationStatus");
          $cats     = mysqli_fetch_all($query);
          foreach ($cats as $cat) {
            $cap = $cat[1];
            #                    app.id   stat.id
            echo ("<option value='$row[3] $cat[0]'>$cap</option>");
          }
          echo ("</select></td></tr>");
        }
        echo ('</table>');

        ?>
        <br><br><br>
        <!---  END of  second section--->



        <!-- update job application AJAX -->
        <script type='text/javascript'>
          function updateApp(element) {
            $.ajax({
              type: 'POST',
              url: 'helpers.php',
              data: {
                selection: true,
                app_id: element.value.split(' ')[0],
                state_id: element.value.split(' ')[1],
                newState: element.options[element.selectedIndex].text,
              },
              beforeSend: function() {
                app_id = element.value.split(' ')[0]
                $(`#status${app_id}`).html('...');
              },
              success: function(data) {
                var data = JSON.parse(data);
                $(`#status${data.appid}`).html(data.newState);
              }
            });
          }
        </script>


        <!---  Thired section--->
        <a href="newjob.php" style="color: #fff; text-decoration: underline;">
          <h1 class="text-size-r">Add New Job Offer</h1>
        </a>
        <h1 class="text-size">Offered <span>Jobs</span></h1>

        <table>
          <tr>
            <th>Job title</th><br>
          </tr>
          <?php
          $query = mysqli_query($con, "
            select jobOffer.title, jobOffer.id from jobProvider
            inner join jobOffer on jobOffer.job_provider_id = jobProvider.id
            where jobProvider.id = $session_id
          ");

          $apps  = mysqli_fetch_all($query);
          $num_row = mysqli_num_rows($query);

          if ($num_row == 0) echo ("<tr><td>No jobs were found!</td></tr>");
          
          foreach ($apps as $row) {
            echo ("<tr id='$row[1]'>
              <td><a href='jobdetail.php?id=$row[1]' style='color: #fff; text-decoration: underline;'>$row[0]</a></td>
              <td><a href='Edit.php?id=$row[1]' style='color: #fff; text-decoration: underline;'>Edit</a></td>
              <td>
                <button onClick='deleteJob(this, event)' name='delete' value='$row[1]'
                style='background:none;border:none;color:white;'>Delete</button>
              </td>
            </tr>");
          }
        
          ?>
        </table>

        <!-- delete job offer AJAX -->
        <script type='text/javascript'>
          function deleteJob() {
            $.ajax({
              type: 'POST',
              url: 'helpers.php',
              data: {
                delete: true,
                job_id: event.target.value,
              },
              beforeSend: function() {
                event.target.setAttribute("disabled", "disabled");
                event.target.innerHTML = '...';
              },
              success: function(data) {
                alert('The job offer was deleted successfully!');
                $(`#${data}`).hide();
              }
            });
          }
        </script>

        <br>
        <br>
        <br>
        <!---  Thilered section--->
  </main>

  <footer>
    <div class="footer nav-area">
      <h6> &copy;Get A Job 2022</h6><br>
    </div>
  </footer>

</body>

</html>