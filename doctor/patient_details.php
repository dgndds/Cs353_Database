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
      <?php

      try {

        $connection = new PDO("mysql:host=" . $GLOBALS['host'] . "; dbname=" . $GLOBALS['database'], $GLOBALS['username'], $GLOBALS['password']);

          $query = $connection->prepare("
          SELECT first_name, last_name FROM user WHERE TC=?;"
          );

          $query->execute(
            array(
              $_SESSION["TC"]
            )
          );

          $data = $query->fetch();

      ?>

        <!-- HEADER -->
        <div class="row">
          <nav class="navbar navbar-light header px-0">
            <div class="container-fluid">
              <a class="navbar-brand">Welcome Doctor <?=($data["first_name"] . " " . $data["last_name"])?></a>
            <form class="d-flex">
              <a href="../logout.php" class="btn btn-danger">Logout</a>
            </form>
          </div>
        </nav>
      </div>

      <!-- Prescribe Patient -->
      <div class="row">

        <div class="my-4 text-center">
          <h2 class="h2">Patient Details</h2>
        </div>

        <div class="col-8 mx-auto bg-form p-5 rounded">
          <div class="row text-center">
            <?php

                if ( (isset($_SESSION["TC"]) && $_SESSION["type"] == "doctor" && isset($_GET["tc_number"]) && $_GET["tc_number"] != "") ) {

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

            <?php
              $flag = 1;

              if ( isset($_GET["status"]) && $_GET["status"] == "future" ) {
                  $flag = 0;
              }

              if ( $flag ) {

            ?>

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

            <div class="my-4">
              <p class="fs-4"> <b>Tests</b> </p>
            </div>

            <table class="table table-sm table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Patient Name</th>
                  <th scope="col">Laboratorian Name</th>
                  <th scope="col">Date</th>
                  <th scope="col">Test Type</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php

                    $query = $connection->prepare("
                    SELECT first_name, last_name, test_name, components, test.test_id, patientTC, request_test.appointment_id
                    FROM
                    ((request_test JOIN book_appointment ON request_test.appointment_id=book_appointment.appointment_id) JOIN user ON user.TC=patientTC) JOIN test ON test.test_id=request_test.test_id
                    WHERE request_test.appointment_id=?
                    ;");

                    $query->execute(
                      array(
                        $_GET["appointment"]
                      )
                    );

                    $counter = 1;
                    while ( $data = $query->fetch() ) {
                      $finished = 0;

                      $inner_query = $connection->prepare("
                      SELECT * FROM result WHERE test_id=?"
                      );

                      $inner_query->execute(
                        array(
                          $data["test_id"]
                        )
                      );

                      ?>

                      <tr>
                        <th scope="row"><?=$counter++?></th>
                        <td><?=($data["first_name"] . " " . $data["last_name"])?></td>
                        <td><?=$data["test_name"]?></td>
                        <td><?=$data["components"]?></td>
                        <?php
                          if ( $inner_query->rowCount() == str_word_count( $data["components"])) {
                            $finished = 1;?>
                            <td>Finished &nbsp;&nbsp; <a href="#" class="btn btn-success" style="width:25px;height:25px;"></a></td>
                            <?php
                          }else if ( $inner_query->rowCount() == 0){ ?>
                            <td>Assigned &nbsp;&nbsp; <a href="#" class="btn btn-danger" style="width:25px;height:25px;"></a></td>
                            <?php
                          }else if ( $inner_query->rowCount() > 0 ){
                            ?>
                            <td>Preparing &nbsp;&nbsp; <a href="#" class="btn btn-warning" style="width:25px;height:25px;"></a></td>
                            <?php
                          }

                          $inner_query = $connection->prepare("
                          SELECT first_name, last_name FROM user WHERE TC=?;"
                          );

                          $inner_query->execute(
                            array(
                              $data["patientTC"]
                            )
                          );

                          $inner_data = $inner_query->fetch();

                          $name = $inner_data["first_name"] . " " . $inner_data["last_name"];

                          if ( $finished ) { ?>
                            <td><a href="view_result.php?patient_name=<?=($data["first_name"] . " " . $data["last_name"])?>&patient_tc=<?=$data["patientTC"]?>&test_id=<?=$data["test_id"]?>&appointment=<?=$_GET["appointment"]?>">View</a></td>
                            <?php
                          }else{ ?>

                            <td><a href="#" disabled></a></td>

                        <?php } ?>

                      </tr>

                      <?php } ?>


              </tbody>
            </table>

            <div class="my-4">
              <p class="fs-4"> <b>Prescribed Medicine(s)</b> </p>
            </div>

            <table class="table table-sm table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Medicine Name</th>
                  <th scope="col">Medicine Type</th>
                  <th scope="col">Usage Description</th>
                </tr>
              </thead>
              <tbody>
                <?php

                    $query = $connection->prepare("
                    SELECT medicine_name, type, usage_description
                    FROM prescribe JOIN medicine ON prescribe.medicine_id=medicine.medicine_id
                    WHERE appointment_id=?
                    ;");

                    $query->execute(
                      array(
                        $_GET["appointment"]
                      )
                    );

                    $counter = 1;
                    while ( $data = $query->fetch() ) {

                      ?>

                      <tr>
                        <th scope="row"><?=$counter++?></th>
                        <td><?=$data["medicine_name"]?></td>
                        <td><?=$data["type"]?></td>
                        <td><?=$data["usage_description"]?></td>
                      </tr>

                      <?php } ?>


              </tbody>
            </table>

            <?php
          }

          }}else {
            header("location:see_appointments.php");
          }

              } catch (PDOException $err) {
                echo "<h1>Cant Connect Database!</h1>";
              }
            ?>
          </div>
        </div>


        <div class="col-12 text-center mt-3">
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
