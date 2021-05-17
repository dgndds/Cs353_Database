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
          <h2 class="h2">Manage Days</h2>
        </div>

        <div class="col-8 mx-auto bg-form p-5 rounded">

          <div class="my-4">
              <b>Today:</b> <?=date("Y-m-d")?>

              <br>

              Cancelled: <a href="#" class="btn btn-danger" style="width:25px;height:25px;"></a>  &nbsp; &nbsp; &nbsp;
              Available: <a href="#" class="btn btn-success" style="width:25px;height:25px;"></a> &nbsp; &nbsp; &nbsp;
              Past: <a href="#" class="btn btn-danger disabled" style="width:25px;height:25px;" tabindex="-1" role="button" aria-disabled="true"></a> &nbsp; &nbsp; &nbsp;
              Reserved: <a href="#" class="btn btn-warning" style="width:25px;height:25px;"></a>
          </div>

          <table class="table table-sm table-striped table-hover">
            <thead>
              <tr>
                <th scope="col">Monday</th>
                <th scope="col">Tuesday</th>
                <th scope="col">Wednesday</th>
                <th scope="col">Thursday</th>
                <th scope="col">Friday</th>
                <th scope="col">Saturday</th>
                <th scope="col">Sunday</th>
              </tr>
            </thead>
            <tbody>

              <?php

                  if ( (isset($_SESSION["TC"]) && $_SESSION["type"] == "doctor") ) {

                        $tc = $_SESSION["TC"];

                        if ( isset($_GET["change"]) ) {

                          $change = $_GET["change"];
                          $day = $_GET["day"];

                          if ( $change == "cancel" ) {

                            $query = $connection->prepare("
                              DELETE FROM time_shift WHERE TC=? and shift_date=?;"
                            );

                            $query->execute(
                              array(
                                 $tc, $day
                               )
                            );

                          }else if ( $change == "success" ) {

                            $query = $connection->prepare("
                            INSERT INTO time_shift (TC, shift_date, available) VALUES (?, ?, 'cancel');"
                            );

                            $query->execute(
                              array(
                                 $tc, $day
                               )
                            );

                          }

                        }

                        $query = $connection->prepare("
                          SELECT shift_date, available FROM time_shift WHERE TC=?;"
                        );

                        $query->execute(
                          array(
                             $tc
                           )
                        );

                        if ( $query->rowCount() > 0 ){

                          $times = array();

                          while($data = $query->fetch()) {
                            $times[$data['shift_date']] = $data['available'];
                          }


                          $today = date("Y-m-d");
                          $day_name = date('l', strtotime($today));
                          $day = $today;

                          $flag = 1;
                          $counter = 0;

                          for ($i=0; $i < 5; $i++) {

                           ?>

                             <tr>

                              <?php

                                $days = array("Sunday"=>"6", "Monday"=>"0", "Tuesday"=>"1", "Wednesday"=>"2", "Thursday"=>"3", "Friday"=>"4", "Saturday"=>"5");

                                foreach($days as $key => $value) {


                                    if ( !$flag ) {
                                      $day =  substr($today, 0, 8) . (((int)substr($today, 8, 2)) + $counter - (int)$days[date('l', strtotime($today))]);
                                      ?>
                                      <td><?=$day?> &nbsp;<a href="#" class="btn btn-danger disabled" style="width:25px;height:25px;" tabindex="-1" role="button" aria-disabled="true"></a></td>
                                    <?php
                                    }else {
                                        if ( array_key_exists( $day, $times ) ) {
                                          if ( $times[$day] == "cancel" ) { ?>
                                              <td><?=$day?> &nbsp;<a href="manage_days.php?change=cancel&day=<?=$day?>" class="btn btn-danger" style="width:25px;height:25px;"></a></td>
                                            <?php
                                          }else if ( $times[$day] == "reserved" ) { ?>
                                              <td><?=$day?> &nbsp;<a href="#" class="btn btn-warning" style="width:25px;height:25px;"></a></td>
                                            <?php
                                          }
                                        }else{
                                          ?>
                                            <td><?=$day?> &nbsp;<a href="manage_days.php?change=success&day=<?=$day?>" class="btn btn-success" style="width:25px;height:25px;"></a></td>
                                          <?php
                                        }

                                        $day = increaseDay($day);

                                    }

                                    $counter++;
                                }

                              ?>

                            </tr>

                        <?php  }

                        }else {

                        }

                  }

                } catch (PDOException $err) {
                  echo "<h1>Cant Connect Database!</h1>";
                }

                function increaseDay($sample_day) {

                  $day_s = substr($sample_day, 8, 2);
                  $day = ((int)$day_s);
                  $month = 0;

                  if ( $day == 31 ) {
                    $day = 1;
                    $month = 1;
                  }else {
                    $day++;
                  }

                  if ( $day < 10 ) {
                    $day_s = "0" . $day;
                  }else {
                    $day_s = "" . $day;
                  }

                  $month_s = substr($sample_day, 5, 2);
                  $month = $month + (int)$month_s;

                  if ( $month < 10 ) {
                    $month_s = "0" . $month;
                  }else {
                    $month_s = "" . $month;
                  }

                  $month_s = substr($sample_day, 0, 5) . $month_s . "-" . $day_s ;

                  return $month_s;
                }

              ?>

            </tbody>
          </table>
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
