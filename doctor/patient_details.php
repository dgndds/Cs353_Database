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
          <h2 class="h2">Patient Details</h2>
        </div>

        <div class="col-8 mx-auto bg-form p-5 rounded">
          <div class="row text-center">
            <?php


              try {

                $connection = new PDO("mysql:host=" . $GLOBALS['host'] . "; dbname=" . $GLOBALS['database'], $GLOBALS['username'], $GLOBALS['password']);

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
