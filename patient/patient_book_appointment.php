<?php
  require_once("../config.php");
  session_start();
  
  if ( !(isset($_SESSION["TC"]) && $_SESSION["type"] == "patient") ) {
    header("location:../index.php");
  }

  try{
    $connection = new PDO("mysql:host=" . $GLOBALS['host'] . "; dbname=" . $GLOBALS['database'], $GLOBALS['username'], $GLOBALS['password']);

    $query = $connection->prepare("SELECT department_name FROM departments");

    $query->execute();
    
    if(isset($_POST['doctorId']) && isset($_POST['chosenDate'])){
      $selectedDoctor = $_POST['doctorId'];
      $selectedDate = $_POST['chosenDate'];
      $userTc = $_SESSION['TC'];

      $query = $connection->prepare("INSERT INTO time_shift (TC, shift_date, available) VALUES (?, ?, 'reserved')");

      $query->execute(
        array(
          $selectedDoctor,$selectedDate
        )
      );

      $query = $connection->prepare("INSERT INTO appointment (app_date) VALUES (?)");
 
      $query->execute(
         array(
           $selectedDate
         )
       );
      
       $query = $connection->prepare("INSERT INTO book_appointment (patientTC, doctorTC) VALUES (?, ?)");

          
       $query->execute(
            
        array(
            $userTc,$selectedDoctor
          )
        );
    }

    if(isset($_SESSION["selectedDeparment"]) && isset($_SESSION["selectedMonth"])){
      $selectedDepartment= $_SESSION["selectedDeparment"];
      $selectedMonth = $_SESSION["selectedMonth"]; 
    }
    

    if(!empty($_POST['department-name']) && !empty($_POST['month'])) {
      $selectedDepartment = $_POST['department-name'];
      $selectedMonth = $_POST['month'];
      $_SESSION["selectedDeparment"] =$selectedDepartment;
      $_SESSION["selectedMonth"] = $selectedMonth;
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
            <a class="navbar-brand">Welcome <?php echo $_SESSION["userName"]?></a>
            <form class="d-flex">
              <a href="../logout.php" class="btn btn-danger" type="submit">Logout</a>
            </form>
          </div>
        </nav>
      </div>

      <!-- Prescribe Patient -->
      <div class="row">

        <div class="m-4 text-center">
          <h2 class="h2">BOOK AN APPOINTMENT</h2>
        </div>

        <?php
          $query = $connection->prepare("SELECT department_name FROM departments");
          $query->execute();
        ?>

        <div class="col-12 col-md-8 mx-auto mb-4">
          <div class="row">
            <div class="col-12 col-md-4 mb-3 text-center">
              <div class="dropdown col-12 col-md-6">
                <p class="d-inline" style="font-size:1.3rem;"><b>Month: </b></p>
                <form action="patient_book_appointment.php" method="post">
                  <select name="month" class="form-select">
                      <option value="" disabled selected>Choose option</option>
                      <option value="01">January</option>
                      <option value="02">February</option>
                      <option value="03">March</option>
                      <option value="04">April</option>
                      <option value="05">May</option>
                      <option value="06">June</option>
                      <option value="07">July</option>
                      <option value="08">August</option>
                      <option value="09">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                  </select>
              </div>
            </div>
            <div class="col-12 col-md-4 mb-3 text-center">
              <div class="dropdown col-12 col-md-6">
                <p class="d-inline" style="font-size:1.3rem;"><b>Department: </b></p>
                  <select name="department-name" class="form-select">
                      <option value="" disabled selected>Choose option</option>
                      <?php
                        while($data = $query->fetch()){?>
                          <option value="<?=$data["department_name"]?>"><?=$data["department_name"]?></option>
                          <?php } 
                      ?>
                  </select>
              </div>
            </div>
            <div class="col-12 col-md-4">
                <input class="btn btn-danger" type="submit" value="Search" name="btnSbmt">
              </form>
            </div>
          </div>
        </div>

        <?php if(!empty($_POST['department-name']) && !empty($_POST['month'])){?>
        <div class="col-12 col-md-8 mx-auto bg-form p-5 rounded">
          <div class="row text-center">
            <div class="col-12">
              <table class="table table-sm table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php

                   $query = $connection->prepare("SELECT TC,first_name,last_name from doctor natural join user where TC in (select TC from  departments natural join works_in where department_name=? )");

                   $query->execute(
                     array(
                       $selectedDepartment
                     )
                   );

                   $doctors = $query;
                   $index = 1;
                   while($data = $doctors->fetch()){
                     for($i = 1; $i <= 30; $i++){
                      $i_padded = sprintf("%02d", $i);
                      $monthPadded = sprintf("%02d", $selectedMonth);
                      $date = "2021-" . $monthPadded ."-". $i_padded;
  
                      $query = $connection->prepare("SELECT * FROM time_shift where ? in (select shift_date from time_shift) and shift_date=? and TC=?");
  
                      $query->execute(
                        array(
                          $date,$date,$data["TC"]
                        )
                      );
                      
                      if ($query->rowCount() == 0 && date("Y-m-d") <= $date){
                        $dateToShow = $i."-".$selectedMonth."-2021";
                        echo "<form action=\"patient_book_appointment.php\" method=\"post\">";
                        echo "<tr>";
                        echo "<th scope=\"row\">$index</th>";
                        echo "<td><input type=\"hidden\" name=\"doctorId\" value=\"".$data["TC"]."\">".$data["first_name"]." ".$data["last_name"]."</td>";
                        echo "<td><input type=\"hidden\" name=\"chosenDate\" value=\"".$date."\">".$dateToShow."</td>";
                        echo "<td><input type=\"submit\" value=\"Appoint\"></td>";
                        echo "</tr>";
                        echo "</form>";
                        $index++;
                      }
                    }
                   }
                ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php }?>
        <div class="col-12 text-center mt-3">
          <a href="index.php" class="btn btn-danger p-2">Return</a>
        </div>
        <?php
          } catch (PDOException $err) {
            echo "<h1>Cant Connect Database!</h1>";
          }
        ?>
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
