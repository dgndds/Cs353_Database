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
          <h2 class="h2">Request Test</h2>
        </div>

        <div class="col-12 col-md-6 mx-auto bg-form p-5 rounded">

          <?php

            try {

              $connection = new PDO("mysql:host=" . $GLOBALS['host'] . "; dbname=" . $GLOBALS['database'], $GLOBALS['username'], $GLOBALS['password']);

              if ( (isset($_SESSION["TC"]) && $_SESSION["type"] == "doctor") ) {

                    $tc = $_SESSION["TC"];

                    $query = $connection->prepare("
                      SELECT first_name, last_name FROM user WHERE TC=?;"
                    );

                    $query->execute(
                      array(
                         $_GET["tc_number"]
                       )
                    );

                    if ( $query->rowCount() > 0 ){

                      $data = $query->fetch();

                      ?>

          <div class="row mb-3">
            <div class="col-6 text-right">
              <p class="d-inline" style="font-size:1.3rem;"><b>Patient: </b></p>
            </div>
            <div class="col-6">
              <p class="fs-5">
                  <?php


                      echo $data["first_name"] . " " . $data["last_name"];

                     }



                  ?>
              </p>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-6 text-right">
              <p class="d-inline" style="font-size:1.3rem;"><b>Test Type: </b></p>
            </div>
            <div class="col-6">
              <?php if ( !isset($_GET["selected_test"]) ) { ?>
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  Select
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                  <?php

                    $query = $connection->prepare("
                      SELECT * FROM test;"
                    );

                    $query->execute();

                    while ( $data = $query->fetch() ) { ?>
                      <li><a class="dropdown-item" href="request_test.php?tc_number=<?=$_GET["tc_number"]?>&appointment=<?=$_GET["appointment"]?>&selected_test=<?=$data["test_name"]?>&test_id=<?=$data["test_id"]?>"><?=$data["test_name"]?></a></li>
                    <?php
                    }

                  ?>
                </ul>
              </div>

            <?php }else{

                echo "<p class=\"fs-5 d-inline\">" . $_GET["selected_test"] . "</p>"; ?>
                &nbsp;&nbsp;&nbsp;
                <a class="btn btn-danger" onclick="empty()" href="request_test.php?tc_number=<?=$_GET["tc_number"]?>&appointment=<?=$_GET["appointment"]?>">Delete!</a>


            <?php } ?>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-6 text-right">
              <p class="d-inline" style="font-size:1.3rem;"><b>Components: </b></p>
            </div>
            <div class="col-6">
              <?php if ( isset($_GET["selected_test"]) ) { ?>

              <select class="form-select w-50" aria-label="Select" id="component">
                <option selected>Select</option>
                  <?php

                    $query = $connection->prepare("
                      SELECT component_name FROM component WHERE test_id=( SELECT test_id FROM test WHERE test_name=? );"
                    );

                    $query->execute(
                      array(
                        $_GET["selected_test"]
                      )
                    );

                    while ( $data = $query->fetch() ) { ?>
                      <option value="<?=$data["component_name"]?>"><?=$data["component_name"]?></option>
                    <?php
                    }

                  ?>

                </select>
            <?php }else {
              echo "<p class=\"fs-5 d-inline\">Please Select a Test Type</p>";
            } ?>

            </div>
          </div>

          <div class="row text-center">

            <div class="col-12">
                <button class="btn btn-success px-3" onclick="addComponent(document.getElementById('component').value)">Add Component</button>
            </div>

            <div class="col-12 text-center mt-3">
                <h3 class="h3">Requested Components</h3>
                <form action="request_test.php?tc_number=<?=$_GET["tc_number"]?>&appointment=<?=$_GET["appointment"]?>&selected_test=<?=$_GET["selected_test"]?>&test_id=<?=$_GET["test_id"]?>" method="POST">
                <div class="form-floating">
                  <textarea class="form-control mb-4" placeholder="Leave a comment here" name="comps" id="comp" style="resize: none;" readonly></textarea>
                  <label for="comp">Components</label>
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-success px-3" type="submit">Submit</button>
              </form>

              <div class="my-2">
                <?php

                  if ( isset($_POST["comps"]) ) {

                    $query = $connection->prepare("
                    SELECT * FROM laboratorian WHERE speciality=?;"
                    );

                    $query->execute(
                      array(
                        $_GET["selected_test"]
                      )
                    );

                    $data = $query->fetchAll();

                    $random_number = rand(0, $query->rowCount() - 1);

                    $query = $connection->prepare("
                    INSERT INTO request_test (appointment_id, laboratorianTC, test_id, components) VALUES (?, ?, ?, ?);"
                    );

                    $query->execute(
                      array(
                        $_GET["appointment"], $data[$random_number][0], $_GET["test_id"], $_POST["comps"]
                      )
                    );

                    if ( $query->rowCount() > 0 ) {?>

                      <div class="badge bg-success text-wrap p-2 w-50" style="width: 6rem;">
                         Successfully Added!
                      </div>

                    <?php
                  }else{
                    echo "olmadı kardeş,";
                  }

                  }

                ?>
              </div>

            </div>

          </div>

        </div>

        <div class="col-12 text-center mt-3">
          <a href="view_patients.php" class="btn btn-danger p-2">Return</a>
        </div>

      </div>

    <?php
}
      } catch (PDOException $err) {
        echo "<h1>Cant Connect Database!</h1>";
      }
    ?>


    </div>


    <!-- Optional JavaScript; choose one of the two! -->
    <script type="text/javascript">

      function addComponent( c_name ) {
        var text = document.getElementById("comp").innerHTML;

        if ( !text.includes(c_name) ) {
          document.getElementById("comp").innerHTML += c_name + " ";
        }
      }

      function empty(){
        document.getElementById("comp").innerHTML = "";
      }

    </script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
    -->
  </body>
</html>
