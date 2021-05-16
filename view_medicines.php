<?php
  require_once("config.php");
  session_start();
  $connection = new PDO("mysql:host=" . $GLOBALS['host'] . "; dbname=" . $GLOBALS['database'], $GLOBALS['username'], $GLOBALS['password']);     
?>
<?php
  if (isset($_GET['medicine_id']) && isset($_POST['search'])) {
   //getting value passed in url
   $tc = $_SESSION["TC"];
   $productieorder =  $_GET['medicine_id'];
   $incrementBy = $_POST['search'];
   $query2 = $connection->prepare("update medicine set medicine_qty = medicine_qty + $incrementBy where medicine_id =$productieorder");
   $query2->execute();
   $query3 = $connection->prepare("insert into supply values ($productieorder, $tc)");
   $query3->execute();
   header("location: view_medicines.php");              
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
    <link rel="stylesheet" href="css/style.css">

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
            <a class="navbar-brand"><?php echo "Welcome Dr. ".$name;?></a>
            <form class="d-flex">
              <a href="logout.php" class="btn btn-danger" type="submit">Logout</a>
            </form>
          </div>
        </nav>
      </div>

      <!-- Prescribe Patient -->
      <div class="row">

        <div class="m-4 text-center">
          <h2 class="h2 mb-3">MEDICINIES</h2>
        </div>

        <div class="col-12 col-md-8 mx-auto bg-form p-5 rounded">
          <div class="row text-center">
              <?php
                $sql = "SELECT * FROM medicine";
                $query1= $connection->prepare("select * from medicine");
                $query1->execute();          
                echo "
                  <form class=\"d-flex\">
                  <table class=\"table table-sm table-striped table-hover\">
                  <thead>
                    <tr>
                      <th scope=\"col\"></th>
                      <th scope=\"col\">Medicine ID</th>
                      <th scope=\"col\">Medicine Name</th>
                      <th scope=\"col\">Medicine Type</th>
                      <th scope=\"col\">QTY</th>
                      <th scope=\"col\">Action</th>
                    </tr>
                  </thead>
                  <tbody>";
                
                while($row1 = $query1->fetch()){?>
                   <tr>
                          <th scope="row"></th>
                          <td><?php echo $row1['medicine_id'];?></td>
                          <td><?php echo $row1['medicine_name'];?></td>
                          <td><?php echo $row1['type'];?></td>
                          <td><?php echo $row1['medicine_qty'];?></td>
                          <td>
                              <form></form>
                              <form action="view_medicines.php?medicine_id=<?=$row1['medicine_id']?>" method="POST">
                                <div class="input-group mb-1">
                                  <input type="number" min="1" name="search" class="form-control" placeholder="value" style="width: 5px">
                                  <input type="submit" class="btn btn-danger" value="Add">
                                </div>
                              </form>
                          </td>
                    </tr>
               <?php }; 
                echo "</tbody>
                      </table>";
              ?> 
              
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
          <a href="pharmacist_home.php" class="btn btn-danger p-2">Return</a>
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
