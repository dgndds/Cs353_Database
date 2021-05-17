<?php

  require_once("config.php");

  session_start();

  if ( isset($_SESSION["TC"]) ) {
    if ( $_SESSION["type"] == "doctor" ) {
      header("location:doctor/");
    }else if ( $_SESSION["type"] == "patient" ) {
      header("location:patient/");
    }else if ( $_SESSION["type"] == "laboratorian" ) {
      header("location:laboratorian/");
    }else if ( $_SESSION["type"] == "pharmacist" ) {
      header("location:pharmacist/");
    }
  }

  $incorrect_login = False;

  try {

    $connection = new PDO("mysql:host=" . $GLOBALS['host'] . "; dbname=" . $GLOBALS['database'], $GLOBALS['username'], $GLOBALS['password']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      if ( isset($_POST['btnPat']) && isset($_POST["TC"]) && isset($_POST["password"]) ) {

          $tc = $_POST["TC"];
          $password = $_POST["password"];

          $query = $connection->prepare("SELECT * FROM user WHERE ? in (SELECT TC FROM patient) AND password=?");

          $query->execute(
            array(
               $tc, $password
             )
          );

          if ( $query->rowCount() > 0 ){
              $_SESSION["TC"] = $tc;
              $_SESSION["password"] = $password;
              $_SESSION["type"] = "patient";
              header("location:patient/");
          }else {
            $incorrect_login = True;
          }

      } else if( isset($_POST['btnEmp']) && isset($_POST["TC"]) && isset($_POST["password"]) ) {

          $tc = $_POST["TC"];
          $password = $_POST["password"];

          $query = $connection->prepare("SELECT * FROM user WHERE ? in (SELECT TC FROM employee) AND password=?");

          $query->execute(
            array(
               $tc, $password
             )
          );

          if ( $query->rowCount() > 0 ){
              $_SESSION["TC"] = $tc;
              $_SESSION["sid"] = $password;

              $query = $connection->prepare("SELECT * FROM user WHERE ? in (SELECT TC FROM doctor) AND password=?");

              $query->execute(
                array(
                   $tc, $password
                 )
              );

              if ( $query->rowCount() > 0  ) {
                $_SESSION["type"] = "doctor";
                header("location:doctor/");
              }else {
                $query = $connection->prepare("SELECT * FROM user WHERE ? in (SELECT TC FROM pharmacist) AND password=?");

                $query->execute(
                  array(
                     $tc, $password
                   )
                );

                if ( $query->rowCount() > 0  ) {
                  $_SESSION["type"] = "pharmacist";
                  header("location:pharmacist/");
                }else {
                  $_SESSION["type"] = "laboratorian";
                  header("location:laboratorian/");
                }
              }

          }else {
            $incorrect_login = True;
          }

      }

    }

  } catch (PDOException $err) {
    echo "<h1>Cant Connect Database!</h1>";
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
    <link rel="stylesheet" href="css/style.css">

    <title>Hospital System</title>

  </head>
  <body class="bg">

    <div class="container-fluid p-0">

      <!-- Prescribe Patient -->
      <div class="row mt-5">

        <div class="m-4 text-center">
          <h2 class="h2">HOSPITAL DATA MANAGEMENT SYSTEM</h2>
        </div>

        <div class="col-12 col-md-5 mx-auto bg-form p-5 rounded">
          <div class="row text-center">

            <div class="col-12 text-left">
              <form action="index.php" method="POST">
                <div class="mb-3">
                  <label class="form-label">TC</label>
                  <input type="text" class="form-control" name="TC" aria-describedby="emailHelp">
                  <div class="form-text">We'll never share your information with anyone else.</div>
                </div> <br>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Password</label>
                  <input type="password" class="form-control" name="password">
                </div>

                <?php if( $incorrect_login ){ ?>

                  <div class="badge bg-warning text-wrap p-2 w-50" style="width: 6rem;">
                    Invalid username or password!
                  </div>


                <?php

                  $incorrect_login = False;
                }

                ?>

            </div>

            <div class="col-12 my-3">
                <button class="btn btn-danger p-3" type="submit" name="btnPat">LOGIN AS PATIENT</button>
            </div>

            <div class="col-12 mb-3">
                <button class="btn btn-danger p-3" type="submit" name="btnEmp">LOGIN AS EMPLOYEE</button>
              </form>
            </div>

            <div class="col-12">
                <a href="register_patient.php" class="btn btn-danger p-3">REGISTER PATIENT</a>
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
