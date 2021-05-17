<?php

  require_once("../config.php");

  session_start();

  if ( !(isset($_SESSION["TC"]) && $_SESSION["type"] == "doctor") ) {
    header("location:../index.php");
  }
  $connection = new PDO("mysql:host=" . $GLOBALS['host'] . "; dbname=" . $GLOBALS['database'], $GLOBALS['username'], $GLOBALS['password']);
  if (isset($_GET['tc_number'])){
    $p_tc = $_GET['tc_number'];
    $app = $_GET['appointment'];
  }
  if (isset($_POST['d_name']) && isset($_POST['treat_name']) && isset($_POST['med_id']) && isset($_POST['usage']))  {

    $query = $connection->prepare("INSERT INTO prescribe (`treatment_id`, `medicine_id`, `appointment_id`, `usage_description`, `supplied`) VALUES (?, ?, ?, ?, ?);");
    $query->execute(array(
      $_POST['treat_name'], $_POST['med_id'], $app, $_POST['usage'], 0
    ));
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
      <div class="row mb-4">

        <div class="my-4 text-center">
          <h2 class="h2">PRESCRIBE PATIENT</h2>
        </div>
        <div class="col-8 mx-auto bg-form p-4 rounded">
          <form class="row g-3" method="POST">
            <div class="col-md-10">
              <label for="inputEmail4" class="form-label" style="font-size:20px">Patient Name: </label>
              <label for="inputEmail4" style="font-weight:bold; font-size:20px;" class="form-label"><?php
                $query1= $connection->prepare("select * from user where TC = $p_tc");
                $query1->execute();
                $row1 = $query1->fetch();
                $name = $row1['first_name'] . " " . $row1['last_name'];
                echo $name;
              ?></label>
            </div>
            <div class="col-md-4">
              <label for="inputPassword4" class="form-label">Disease Name</label>
              <select class="form-select w-50" name="d_name" aria-label="Select" id="component">
                <option selected disabled value="">Select</option>

                  <?php

                    $query = $connection->prepare("
                      SELECT * FROM disease;"
                    );

                    $query->execute();

                    while ( $data = $query->fetch() ) { ?>
                      <option value="<?=$data["disease_name"]?>"><?=$data["disease_name"]?></option>
                    <?php
                    }

                  ?>
                </select>
            </div>
            <div class="col-md-4">
              <label for="inputPassword4" class="form-label">Treatment Name</label>
              <select class="form-select w-50" name="treat_name" aria-label="Select" id="component">
                <option selected disabled value="">Select</option>
                  <?php

                    $query = $connection->prepare("
                      SELECT * FROM treatment;"
                    );

                    $query->execute();

                    while ( $data = $query->fetch() ) { ?>
                      <option value="<?=$data["treatment_id"]?>"><?=$data["treatment_name"]?></option>
                    <?php
                    }

                  ?>
                </select>
            </div>
            <div class="col-md-4">
              <label for="inputPassword4" class="form-label">Medicine Name - Type</label>
              <select class="form-select w-50" name="med_id" aria-label="Select" id="component">
                <option selected disabled value="">Select</option>

                  <?php

                    $query = $connection->prepare("
                      SELECT * FROM medicine;"
                    );

                    $query->execute();

                    while ( $data = $query->fetch() ) { ?>
                      <option value="<?=$data["medicine_id"]?>"><?=$data["medicine_name"] . " - " . $data["type"]?></option>
                    <?php
                    }

                  ?>
                </select>
            </div>
            <div class="col-12 form-floating">
              <p>Comments</p>
              <textarea class="form-control" name="usage" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
            </div>
            <div class="col-12 text-center mt-3">
              <button type="submit" class="btn btn-danger p-2">Register Prescription</button>
            </div>
          </form>
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
