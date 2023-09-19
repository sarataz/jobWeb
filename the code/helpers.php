<?php
    include('dbcon.php');
    include('session.php');
    ob_start();

    if(isset($_POST['selection']) ){
        
        $app = (int)$_POST['app_id']; 
        $status = (int)$_POST['state_id'];
        $query = mysqli_query($con,"
          UPDATE jobApplication
          SET application_status_id = $status
          WHERE id = $app
        ");
        usleep(200000);
        $ret = array(
          'appid' => $app,
          'newState' => $_POST['newState']
        );
        echo json_encode($ret);
    }


    if (isset($_POST['delete'])) {
      $jobid = (int) $_POST['job_id'];
      try {
        $query = mysqli_query($con, "DELETE FROM joboffer WHERE joboffer.id = $jobid");
      } catch (mysqli_sql_exception) {}

      echo "$jobid";
    }

    if (isset($_POST['filter'])) {
      $selection = $_POST['cat_id'];

      $query = mysqli_query($con, "
      select jobcategory.category, joboffer.title, jobprovider.name, joboffer.salary, joboffer.id from joboffer
      inner join jobprovider on jobprovider.id = joboffer.job_provider_id
      inner join jobcategory on jobcategory.id = joboffer.job_category_id
      where jobcategory.id = '$selection'
      ");

      $jobs = mysqli_fetch_all($query);
      
      $final = array();
      foreach($jobs as $job){
        $row = array(
          'cat' => $job[0],
          'title' => $job[1],
          'name' => $job[2],
          'salary' => $job[3],
          'Offerid' => $job[4],
        );
        
        $query = mysqli_query($con,
          "SELECT id FROM jobApplication 
            WHERE jobApplication.job_seeker_id= $session_id
            AND jobApplication.job_offer_id= {$job[4]}
          "
        );

        $num_row = mysqli_num_rows($query);
        $row['applied'] = boolval($num_row != 0);
        array_push($final, $row);
      }
      echo json_encode($final);
      return;
    }

    if (isset($_POST['apply'])) {
      $jobid = $_POST['jobid'];
      $query = mysqli_query($con, "
        insert into jobApplication(job_offer_id, job_seeker_id, application_status_id)
        values($jobid, $session_id, 3);
      ");
      echo $jobid;      
    }

?>