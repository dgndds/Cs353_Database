<?php
  require_once("../config.php");

  session_start();

  $connection = new PDO("mysql:host=" . $GLOBALS['host'] . "; dbname=" . $GLOBALS['database'], $GLOBALS['username'], $GLOBALS['password']);

  if ( !(isset($_SESSION["TC"]) && $_SESSION["type"] == "pharmacist") ) {
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
            <?php
              if (isset($_SESSION["TC"])) {
                $tc = $_SESSION["TC"];
                $query1= $connection->prepare("select * from user where TC = $tc");
                $query1->execute();
                $row1 = $query1->fetch();
                $name = $row1['first_name'] . " " . $row1['last_name'];
              }
            ?>
            <a class="navbar-brand"><?php echo "Welcome Pharmacist ".$name;?></a>

            <form class="d-flex">
              <a href="../logout.php" class="btn btn-danger" type="submit">Logout</a>
            </form>
          </div>
        </nav>
      </div>

      <!-- Prescribe Patient -->
      <div class="row">

        <div class="m-4 text-center">
          <h2 class="h2 mb-3">PATIENT PRESCRIPTIONS</h2>
        </div>

        <div class="col-12 col-md-8 mx-auto bg-form p-5 rounded">
          <div class="row text-center">
          <?php
                $query1= $connection->prepare("select * from book_appointment where appointment_id in (select appointment_id from prescribe)");
                $query1->execute();
                echo "
                  <form class=\"d-flex\">
                  <table class=\"table table-sm table-striped table-hover\">
                  <thead>
                    <tr>
                      <th scope=\"col\"></th>
                      <th scope=\"col\">Date</th>
                      <th scope=\"col\">Appointment ID</th>
                      <th scope=\"col\">Prescribing Doctor</th>
                      <th scope=\"col\">Patient Name</th>
                      <th scope=\"col\">Action</th>
                    </tr>
                  </thead>
                  <tbody>";

                while($row1 = $query1->fetch()){
                    $app = $row1['appointment_id'];
                    $query2= $connection->prepare("select * from User where TC in (select doctorTC from book_appointment where appointment_id in (select appointment_id from prescribe where appointment_id = $app and supplied = 0))");
                    $query2->execute();
                    while($row2 = $query2->fetch()){
                      $doctor = $row2['TC'];
                      $query3= $connection->prepare("select * from User where TC in (select patientTC from book_appointment where appointment_id in (select appointment_id from prescribe where doctorTC = $doctor and appointment_id = $app))");
                      $query3->execute();
                      $row3 = $query3->fetch();
                ?>
                   <tr>
                          <th scope="row"></th>
                          <?php
                              $query= $connection->prepare("select * from appointment where appointment_id = $app");
                              $query->execute();
                              $row = $query->fetch();
                              $date = $row['app_date'];
                          ?>
                          <td><?php echo $date;?></td>
                          <td><?php echo $row1['appointment_id'];?></td>
                          <td><?php echo "Dr. " . $row2['first_name'] . " " . $row2['last_name']; ?></td>
                          <td><?php echo $row3['first_name'] . " " . $row3['last_name']; $fullName = $row3['first_name'] . " " . $row3['last_name']; ?></td>

                          <?php echo "<td> <a href='prescription.php?app_id=".$row1['appointment_id']."& p_id=".$fullName."' class=\"btn btn-danger p-2\">View Prescription</a></td>"?>
                    </tr>
               <?php };
                };
                echo "</tbody>
                      </table>";
              ?>
          </div>
        </div>
        <div class="col-12 text-center mt-3">
          <a href="index.php" class="btn btn-danger p-2">Return</a>
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
