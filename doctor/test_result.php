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
              <a href="../logout.php" class="btn btn-danger" type="submit">Logout</a>
            </form>
          </div>
        </nav>
      </div>

      <!-- Prescribe Patient -->
      <div class="row">

        <div class="my-4 text-center">
          <h2 class="h2">TEST RESULT HISTORY</h2>
        </div>

        <div class="col-12 col-md-8 mx-auto mb-3">
          <div class="row justify-content-end">
            <div class="col-4 ml-auto p-0">
              <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
              </form>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-8 mx-auto bg-form p-5 rounded">
          <div class="row text-center">
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

                  try {

                    $connection = new PDO("mysql:host=" . $GLOBALS['host'] . "; dbname=" . $GLOBALS['database'], $GLOBALS['username'], $GLOBALS['password']);

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
                            <td><a href="view_result.php?appointment=<?=$data["appointment_id"]?>">View</a></td>
                            <?php
                          }else{ ?>

                            <td><a href="#" disabled></a></td>

                        <?php } ?>

                      </tr>

                      <?php } ?>


              </tbody>
            </table>
          </div>
        </div>

        <div class="col-12">
          <div class="mx-auto px-100 my-3">
            <nav aria-label="...">
              <ul class="pagination">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active" aria-current="page">
                  <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#">Next</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>

        <div class="col-12 text-center mt-3">
          <a href="view_patients.php" class="btn btn-danger p-2">Return</a>
        </div>

      </div>


    </div>

    <?php
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
