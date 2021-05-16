<?php

  require_once("../config.php");

  session_start();

  if ( !(isset($_SESSION["TC"]) && $_SESSION["type"] == "doctor") ) {
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
            <a class="navbar-brand">Welcome Hakan Kara</a>
            <form class="d-flex">
              <a href="../logout.php" class="btn btn-danger">Logout</a>
            </form>
          </div>
        </nav>
      </div>

      <!-- Prescribe Patient -->
      <div class="row">

        <div class="my-4 text-center">
          <h2 class="h2">Patient Details & Diagnose</h2>
        </div>

        <div class="col-8 mx-auto bg-form p-5 rounded">
          <div class="row text-center">
            <?php


              try {

                $connection = new PDO("mysql:host=" . $GLOBALS['host'] . "; dbname=" . $GLOBALS['database'], $GLOBALS['username'], $GLOBALS['password']);

                if ( (isset($_SESSION["TC"]) && $_SESSION["type"] == "doctor" && isset($_GET["tc_number"]) && $_GET["tc_number"] != "") ) {

                      if ( isset($_GET["delete"]) ) {
                        $symptom = $_GET["delete"];

                        $query = $connection->prepare("
                        DELETE FROM showing WHERE (appointment_id=?) AND (symptom_name=?);"
                        );

                        $query->execute(
                          array(
                            $_GET["appointment"], $_GET["delete"]
                          )
                        );

                        if ( $query->rowCount() > 0 ){

                          while($data = $query->fetch()){ ?>

                            <li><a class="dropdown-item" href="diagnose.php?tc_number=<?=$_GET['tc_number']?>&symptom=<?=$data["symptom_name"]?>"><?=$data["symptom_name"]?></a></li>

                            <?php
                          }

                        }

                      }

                      if ( isset($_POST["comment"]) ) {

                        $query = $connection->prepare("
                          UPDATE appointment SET description=? WHERE (appointment_id=?);"
                        );

                        $query->execute(
                          array(
                            $_POST["comment"], $_GET["appointment"]
                          )
                        );
                      }

                      if ( isset($_GET["delete_comment"]) ) {

                        if ( $_GET["delete_comment"] == "true" ) {
                          $query = $connection->prepare("
                            UPDATE appointment SET description=\"\" WHERE (appointment_id=?);"
                          );

                          $query->execute(
                            array(
                              $_GET["appointment"]
                            )
                          );
                        }

                      }

                      if ( isset($_GET["delete_diagnose"]) ) {

                        if ( $_GET["delete_diagnose"] == "true" ) {
                          $query = $connection->prepare("
                            DELETE FROM diagnose WHERE (appointment_id=?);"
                          );

                          $query->execute(
                            array(
                              $_GET["appointment"]
                            )
                          );
                        }

                      }

                      if ( isset($_GET["disease"]) ) {
                        $disease = $_GET["disease"];

                        $query = $connection->prepare("
                        INSERT INTO diagnose (appointment_id, disease_name) VALUES (?, ?);"
                        );

                        $query->execute(
                          array(
                            $_GET["appointment"], $_GET["disease"]
                          )
                        );

                      }

                      $tc = $_SESSION["TC"];

                      $query = $connection->prepare("
                        Select *

                        FROM appointment, user JOIN patient ON user.TC=patient.TC

                        where

                        (appointment_id, user.TC) in (SELECT appointment_id, patientTC FROM book_appointment WHERE doctorTC=?)

                        and

                        patient.TC=?

                        ORDER BY app_date DESC LIMIT 1;"
                      );

                      $query->execute(
                        array(
                           $tc, $_GET['tc_number']
                         )
                      );

                      if ( $query->rowCount() > 0 ){

                        $data = $query->fetch();


            ?>
            <div class="col-12 col-md-6">
              <p>
                <b>Patient Name: </b>
                <?=($data["first_name"] . " " . $data["last_name"])?>
              </p>
            </div>
            <div class="col-12 col-md-6">
              <p>
                <b>TC: </b>
                <?=$data["TC"]?>
              </p>
            </div>
            <div class="col-12 col-md-6">
              <p>
                <b>Height: </b>
                <?=$data["height"]?> m
              </p>
            </div>
            <div class="col-12 col-md-6">
              <p>
                <b>Weight: </b>
                <?=$data["weight"]?>
              </p>
            </div>
            <div class="col-12 col-md-6">
              <p>
                <b>Gender: </b>
                <?=$data["gender"]?>
              </p>
            </div>
            <div class="col-12 col-md-6">
              <p>
                <b>Birtdate: </b>
                <?=$data["birthdate"]?>
              </p>
            </div>
            <div class="col-12 col-md-6">
              <p>
                <b>Phone Number: </b>
                <?=$data["phone_number"]?>
              </p>
            </div>
            <div class="col-12 col-md-6">
              <p>
                <b>Email: </b>
                <?=$data["email"]?>
              </p>
            </div>

            <div class="col-12">

              <h3 class="h3 text-center mb-2">Symptoms</h3>

              <div class="col-12 col-md-5 mx-auto">
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Select
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <?php

                    $query = $connection->prepare("
                      Select * FROM symptom;"
                    );

                    $query->execute();

                    if ( $query->rowCount() > 0 ){

                      while($data = $query->fetch()){?>

                        <li><a class="dropdown-item" href="diagnose.php?tc_number=<?=$_GET['tc_number']?>&appointment=<?=$_GET['appointment']?>&symptom=<?=$data["symptom_name"]?>"><?=$data["symptom_name"]?></a></li>

                        <?php
                      }

                    }

                    if ( isset($_GET["symptom"]) ) {
                      $symptom = $_GET["symptom"];

                      $query = $connection->prepare("
                      INSERT INTO showing (symptom_name, appointment_id) VALUES (?, ?);"
                      );

                      $query->execute(
                        array(
                          $symptom, $_GET['appointment']
                        )
                      );

                    }

                    ?>
                  </ul>
                </div>
              </div>

              <div class="col-12 col-md-6 mx-auto mt-4">
                <p class="fs-4">
                  Showing:
                  <?php

                  $query = $connection->prepare("
                  SELECT * FROM showing WHERE appointment_id=?;"
                  );

                  $query->execute(
                    array(
                      $_GET['appointment']
                    )
                  );

                  while($data = $query->fetch()){ ?>

                    <b><?=$data["symptom_name"]?>,</b>

                    <?php
                  }

                  ?>
                </p>

                <div class="dropdown">
                  <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Delete Symptom
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <?php

                    $query = $connection->prepare("
                      Select * FROM showing WHERE appointment_id=?;"
                    );

                    $query->execute(
                      array(
                        $_GET["appointment"]
                      )
                    );

                    if ( $query->rowCount() > 0 ){

                      while($data = $query->fetch()){ ?>

                        <li><a class="dropdown-item" href="diagnose.php?tc_number=<?=$_GET['tc_number']?>&appointment=<?=$_GET['appointment']?>&delete=<?=$data["symptom_name"]?>"><?=$data["symptom_name"]?></a></li>

                        <?php
                      }

                    }

                    ?>
                  </ul>
                </div>

                <p class="fs-3 mt-4">
                  Comment:

                  <b>
                    <?php

                      $query = $connection->prepare("
                        SELECT description FROM appointment WHERE appointment_id=?;"
                      );

                      $query->execute(
                        array(
                          $_GET["appointment"]
                        )
                      );

                      if ( $query->rowCount() > 0 ){

                        $data = $query->fetch();

                        echo $data["description"];

                      }

                    ?>
                  </b>

                </p>

                <div class="form-floating my-4">
                  <form class="" action="diagnose.php?tc_number=<?=$_GET['tc_number']?>&appointment=<?=$_GET['appointment']?>" method="POST">
                    <textarea class="form-control mb-4" placeholder="Extra Comments" style="height: 100px" name="comment"></textarea>

                    <input type="submit" class="btn btn-info p-2" value="Save Comment!" />

                    <a href="diagnose.php?tc_number=<?=$_GET['tc_number']?>&appointment=<?=$_GET['appointment']?>&delete_comment=true" class="btn btn-danger p-2">Delete Comment!</a>

                  </form>
                </div>

              </div>

              <h3 class="h3 text-center my-4 mb-2">Diagnose</h3>

              <div class="col-12 col-md-5 mx-auto">
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Select
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <?php

                    $query = $connection->prepare("
                      Select * FROM disease;"
                    );

                    $query->execute();

                    if ( $query->rowCount() > 0 ){

                      while($data = $query->fetch()){ ?>

                        <li><a class="dropdown-item" href="diagnose.php?tc_number=<?=$_GET['tc_number']?>&appointment=<?=$_GET['appointment']?>&disease=<?=$data["disease_name"]?>"><?=$data["disease_name"]?></a></li>

                        <?php
                      }

                    }

                    ?>
                  </ul>
                </div>
              </div>

              <div class="col-12 col-md-5 mx-auto mt-4">
                <p class="fs-3">
                  Diagnosed:

                  <b>

                    <?php

                      $query = $connection->prepare("
                      SELECT disease_name FROM diagnose WHERE appointment_id=?;"
                      );

                      $query->execute(
                        array(
                          $_GET["appointment"]
                        )
                      );

                      $data = $query->fetch();

                      echo $data["disease_name"];

                    ?>

                  </b>

                </p>

                <a href="diagnose.php?tc_number=<?=$_GET['tc_number']?>&appointment=<?=$_GET['appointment']?>&delete_diagnose=true" class="btn btn-danger p-2">Delete Diagnose!</a>

              </div>

              <h3 class="h3 text-center my-4 mb-2">Past Results</h3>

              <p><b>Magnesium 100mg </b> <a href="#">past results</a> </p>
              <p><b>Magnesium 100mg </b> <a href="#">past results</a> </p>
              <p><b>Magnesium 100mg </b> <a href="#">past results</a> </p>
              <p><b>Magnesium 100mg </b> <a href="#">past results</a> </p>
              <p><b>Magnesium 100mg </b> <a href="#">past results</a> </p>

            </div>

            <?php
          }}else {
            header("location:see_appointments.php");
          }

              } catch (PDOException $err) {
                echo "<h1>Cant Connect Database!</h1>";
              }
            ?>
          </div>
        </div>


        <div class="col-12 text-center my-3">
          <a href="see_appointments.php" class="btn btn-danger p-2">Return</a>
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
