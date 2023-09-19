<?php
  include('dbcon.php');
  include('session.php');

  $result = mysqli_query($con, "select * from jobseeker where id='$session_id'");
  $row = mysqli_fetch_array($result);
  ob_start();
  global $selection;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>job seeker Home Page </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/jobseeker.css">
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
      $query = mysqli_query($con, "SELECT * FROM jobseeker WHERE id=$session_id");
      $row  = mysqli_fetch_array($query);
      $firstName = $row['first_name'];
      $lastName = $row['last_name'];
      $age = $row['age'];
      $quals = $row['qualifications'];
      $exp = $row['work_experience'];
      $langs = $row['languages'];
      $phone = $row['phone_number'];
      $email = $row['email_address'];
      $pass = $row['password'];

      echo ("<h1 class='text-size'>Welcome  <span>$firstName</span></h1>  
              <br>
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
        <h1 class="text-size">Job <span>Applicants</span></h1>
        <br>

        <table>
            <tr>
                <th>Job Title</th>
                <th>Job Provider</th>
                <th>Status</th>
            </tr>
            <tr>
        <?php
        $query = mysqli_query($con, "
          select joboffer.title, jobprovider.name, applicationstatus.status, jobOffer.id from jobseeker
          Inner join jobapplication on jobapplication.job_seeker_id = $session_id
          Inner join joboffer on jobapplication.job_offer_id = joboffer.id	
          Inner join jobprovider on jobprovider.id = joboffer.job_provider_id
          Inner join applicationstatus on applicationstatus.id = jobapplication.application_status_id
          GROUP BY jobapplication.id
        ");

        $apps  = mysqli_fetch_all($query);
        $num_row = mysqli_num_rows($query);
        if ($num_row == 0) echo ("<tr><td colspan=3>No mtaching offers was found!</td></tr>");
        
        foreach ($apps as $row) {
          $job_title = $row[0];
          $job_provider = $row[1];
          $status = $row[2];
          echo ("<tr>
            <td><a href='jobdetail.php?id=$row[3]'style='color: #fff; text-decoration: underline;'>$row[0]</a></td>
            <td>$job_provider</td> <td>$status</td></tr>"
          );
        }
        ?>
          </tr>
        </table>
        <br><br><br>
        <!---  END of  second section--->


        <!---  Thired section--->
    <h1 class="text-size">Available <span> Job offers</span></h1><br>

    <table id='jobOffers'>
      <thead><tr>
        <th>Job Category</th>
        <th>Job Title</th>
        <th> Job provider </th>
        <th> Salary </th>
        <th colspan=2 style="background:none; border:none; text-align:center;">
          Search By Category:
          <select id='cats' style="margin-left: 10px;" onchange="updateCat(this, event)">
          <?php
          $query = mysqli_query($con, "SELECT * FROM jobcategory");
          $cats  = mysqli_fetch_all($query);
          foreach ($cats as $cat) {
            $cap = $cat[1];
            echo ("<option value={$cat[0]}>$cap</option>");
          }
          echo"</select>";
          ?> 
        </th>     
      </tr></thead>
      <tbody></tbody>
    </table>
      <script type='text/javascript'>
        function updateCat(element) {
          console.log(element);
          $.ajax({
            type: 'POST',
            url: 'helpers.php',
            data: {
              filter: true,
              cat_id: element.value,
            },
            beforeSend: function() {
            
            },
            success: function(data) {
              $("#jobOffers").find("tr:gt(0)").remove();
              console.log(data);
              var data = JSON.parse(data);
              var table = $('#jobOffers')
              
              if(data.length == 0) {
                var tr = $('<tr>')[0];
                tr.innerHTML = "<td colspan=6 style='text-align:center'>No mtaching offers was found!</td>";
                table.append(tr);
              }

              for(var i in data){
                console.log(data[i]);
                var tr = $('<tr>')[0];
                tr.innerHTML = (`
                  <td>${data[i].cat}</td> 
                  <td><a style='color:white; text-decoration:underline;' href='jobdetail.php?id=${data[i].Offerid}'>${data[i].title}</a></td>
                  <td>${data[i].name}</td>
                  <td>${data[i].salary}</td>
                  <td><a href='jobdetail.php?id=${data[i].Offerid}' style='color:white;text-decoration:underline;'>Details</a></td>
                `)
                if(data[i].applied) tr.innerHTML += "<td><p style='padding:3px'>Applied</p></td>";
                else tr.innerHTML += `<td id=${data[i].Offerid}><button onClick='ApplyJob(this, event)' style='padding:3px' value='${data[i].Offerid}'>Apply</button></td>`;
                table.append(tr);
              }
            }
          });
        }

        function ApplyJob(element){
          console.log('apply yo ', event.target.value)
          $.ajax({
            type: 'POST',
            url: 'helpers.php',
            data: {
              apply: true,
              jobid: event.target.value,
            },
            beforeSend: function() {
              event.target.setAttribute("disabled", "disabled");
              event.target.innerHTML = '...';
            },
            success: function(data) {
              window.location.reload();
            }
          });
        }
        updateCat(document.getElementById('cats'))
      </script>
      <br><br><br><br><br><br><br>
        <!---  Thired section--->
    </main>
    <footer>
        <div class="footer nav-area">
            <h6> &copy;Get A Job 2022</h6><br>
        </div>
    </footer>
</body>

</html>