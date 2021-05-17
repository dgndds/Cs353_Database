<?php

  require_once("../config.php");

  session_start();

  if ( !(isset($_SESSION["TC"]) && $_SESSION["type"] == "patient") ) {
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
            <a class="navbar-brand">Welcome <?=$_SESSION["userName"]?></a>
            <form class="d-flex">
              <button class="btn btn-danger" type="submit">Logout</button>
            </form>
          </div>
        </nav>
      </div>

      <!-- Prescribe Patient -->
      <div class="row">

        <div class="m-4 text-center">
        <h2 class="h2"><?=strtoupper($_GET["companent_name"])?> TEST RESULT</h2>
        </div>
        <div class="col-8 mx-auto bg-form p-5 rounded">
          <div class="row text-center">
            <?php
              try {
                $connection = new PDO("mysql:host=" . $GLOBALS['host'] . "; dbname=" . $GLOBALS['database'], $GLOBALS['username'], $GLOBALS['password']);

                      $tc = $_SESSION["TC"];

                      $query = $connection->prepare("
                      select * 
                      from user,(
                      SELECT *
                      FROM book_appointment natural join result natural join appointment natural join test) AS T 
                      where `laboratorian.TC` = TC and patientTC=? and test_id=?"
                      );
                      
                      $query->execute(
                        array(
                          $tc,$_GET['test_id'] 
                         )
                      );
                      

                      if ( $query->rowCount() > 0 ){

                        $data = $query->fetch();
            ?>
            <div class="col-12 col-md-6">
              <p>
                <b>Patient Name: </b>
                <?=$_SESSION["userName"]?>
              </p>
            </div>
            <div class="col-12 col-md-6">
              <p>
                <b>Laboratorian Name: </b>
                <?=($data["first_name"] . " " . $data["last_name"])?>
              </p>
            </div>
            <div class="col-12 col-md-6">
              <p>
                <b>Date: </b>
                <?=$data["app_date"]?>
              </p>
            </div>
            <div class="col-12 col-md-6">
              <p>
                <b>Test Name: </b>
                <?=$data["test_name"]?> 
              </p>
            </div>
            
            <div class="col-12">

              <!--
                ============================================ IMPORTANT ============================================
              -->

              <h3 class="h3 text-center mb-2">COMPONENT RESULTS</h3>
              
              <div class="col-12">
                <p>
                  <?php

                  $query = $connection->prepare("
                  select * 
                  from user,component,(
                  SELECT *
                  FROM book_appointment natural join result natural join appointment natural join test ) AS T 
                  where `laboratorian.TC` = TC and patientTC=? and companent_name=? and T.companent_name = component_name"
                  );

                  $query->execute(
                    array(
                      $tc,$_GET['companent_name'] 
                    )
                  );

                  while($data = $query->fetch()){ ?>
                    <b><?=$data["companent_name"]." ".$data["score"]." "."Min: ".$data["min"]." "."Max: ".$data["max"]?></b><br>
                    <?php
                  }
                  ?>
                </p>
            </div>
            <?php
          }
              } catch (PDOException $err) {
                echo "<h1>Cant Connect Database!</h1>";
              }
            ?>
          </div>
        </div>

        <div class="col-12 text-center mt-3">
          <a href="see_test_results.php" class="btn btn-danger p-2">Return</a>
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