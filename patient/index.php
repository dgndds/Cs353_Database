<?php

  require_once("../config.php");

  session_start();

  if ( !(isset($_SESSION["TC"]) && $_SESSION["type"] == "patient") ) {
    //SELECT first_name,last_name FROM heroku_115a957c1ea7ee2.user where TC=1147483647;
    
    
    header("location:../index.php");
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">

    <title>Hospital System</title>

  </head>
  <body class="bg">

    <div class="container-fluid p-0">

      <!-- HEADER -->
      <div class="row">
        <nav class="navbar navbar-light header px-0">
          <div class="container-fluid">
            <a class="navbar-brand">Welcome 
            <?php
            try{
              $tc = $_SESSION["TC"];
          
              $connection = new PDO("mysql:host=" . $GLOBALS['host'] . "; dbname=" . $GLOBALS['database'], $GLOBALS['username'], $GLOBALS['password']);
          
              $query = $connection->prepare("CALL GetUserNameByTc(?);");
            
              $query->execute(
                array(
                $tc
              )
            );
            
            $data = $query->fetch();
            
            $_SESSION['userName'] = $data["first_name"]." ".$data["last_name"];
            }catch(PDOException $err){
              echo "default";
            }
            
            echo $_SESSION['userName'];
            ?>
            </a>
            <form class="d-flex">
              <a href="../logout.php" class="btn btn-danger" type="submit">Logout</a>
            </form>
          </div>
        </nav>
      </div>

      <!-- Actions -->
      <div class="row mt-5">

        <div class="my-4 text-center">
          <h2 class="h2">HOSPITAL DATA MANAGEMENT SYSTEM</h2>
        </div>

        <div class="col-12 col-md-4 mx-auto bg-form p-5 rounded">
          <div class="row text-center">

            <div class="col-12 mb-3">
              <form class="d-flex justify-content-center">
                <a href="see_appointments.php" class="btn btn-danger p-3 w-100">View Appointments</a>
              </form>
            </div>

            <div class="col-12 mb-3">
              <form class="d-flex justify-content-center">
                <a href="patient_book_appointment.php" class="btn btn-danger p-3 w-100">Book Appointment</a>
              </form>
            </div>

            <div class="col-12 mb-3">
              <form class="d-flex justify-content-center">
                <a href="see_test_results.php" class="btn btn-danger p-3 w-100">View Test Results</a>
              </form>
            </div>

          </div>
        </div>

      </div>

    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
    -->
  </body>
</html>
