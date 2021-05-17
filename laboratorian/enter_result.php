<?php

  require_once("../config.php");

  session_start();

  if ( !(isset($_SESSION["TC"]) && $_SESSION["type"] == "laboratorian") ) {
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
            <a class="navbar-brand">Welcome Laboratorian Murat Kuşçu</a>
            <form class="d-flex">
              <a class="btn btn-danger" href="../logout.php">Logout</a>
            </form>
          </div>
        </nav>
      </div>

      <!-- Prescribe Patient -->
      <div class="row mb-4">

        <div class="my-4 text-center">
          <h2 class="h2">ENTER TEST RESULT</h2>
        </div>


        <div class="col-5 mx-auto bg-form p-4 rounded">

            <div class="col-6 mx-auto">
              <?php
                try {

                  $connection = new PDO("mysql:host=" . $GLOBALS['host'] . "; dbname=" . $GLOBALS['database'], $GLOBALS['username'], $GLOBALS['password']);

                  if ( isset($_GET["appointment"]) ) {

              ?>

              <div class="row mb-3">
                <div class="col-5">
                  <p> <b>Patient Name:</b> </p>
                </div>
                <div class="col-7">
                  <p class="fs-6"> <?=$_GET["name"]?> </p>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-5">
                  <p> <b>Test Name:</b> </p>
                </div>
                <div class="col-7">
                  <p class="fs-6"> <?=$_GET["type"]?> </p>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-5">
                  <p> <b>Component Name:</b> </p>
                </div>
                <div class="col-7">
                  <form action="enter_result.php" method="POST">

                    <?php

                      $query = $connection->prepare("
                        SELECT companent_name FROM result WHERE test_id=? and appointment_id=? and laboratorian\.TC=?"
                      );

                      $query->execute(
                        array(
                          $_GET["test_id"], $_GET["appointment"], $_SESSION["TC"]
                        )
                      );

                      while ( $data = $query->fetch() ) {
                        echo $data["companent_name"];
                      }

                    ?>


                  <select name="selected_component" class="form-select" aria-label="Select">
                    <option selected>Select</option>

                          <option value="1">1</option>
                  </select>

                </div>
              </div>

              <div class="row">
                <div class="col-5">
                  <p> <b>Value:</b> </p>
                </div>
                <div class="col-7">
                  <input type="text" class="form-control d-inline" name="result_comp">
                </div>
              </div>
            </div>
          </form>
      </div>

      <div class="col-8 mx-auto mt-3">
          <button class="btn btn-danger p-2" type="submit">Register Test</button>
        </form>
      </div>

      <div class="col-12 text-center mt-3">
        <a href="view_tests.php" class="btn btn-danger p-2">Return</a>
      </div>


    </div>

    <?php
  }else if( isset($_GET["appointment"]) && isset($_GET["finished"]) && $_GET["finished"] == "true" ){



  }else {
    header("location:view_tests.php");
  }

      } catch (PDOException $err) {
        echo "<h1>Cant Connect Database!</h1>";
      }
    ?>

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
