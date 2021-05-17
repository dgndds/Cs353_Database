<?php
  require_once("config.php");
  $connection = new PDO("mysql:host=" . $GLOBALS['host'] . "; dbname=" . $GLOBALS['database'], $GLOBALS['username'], $GLOBALS['password']);
  $finished = 0;
  if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['phone'])
  && isset($_POST['tc_id']) && isset($_POST['email']) && isset($_POST['bdate']) && isset($_POST['pass']) 
  && isset($_POST['gender']) && isset($_POST['btype']) && isset($_POST['height']) && isset($_POST['weight']))  {
    $tc_id = $_POST['tc_id'];
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $bdate = $_POST['bdate'];
    $pass = $_POST['pass'];
    $blood = $_POST['btype'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $query3 = $connection->prepare("insert into user values (?,?,?,?,?,?,?,?)");
    $query3->execute(
      array(
        $tc_id, $pass, $fname, $lname, $email, $gender, $bdate, $phone
      )
    );
    if($query3->rowCount() == 0){
      $finished = -1;
    }
    $query4 = $connection->prepare("insert into patient (`TC`, `height`, `weight`, `blood_type`) VALUES (?, ?, ?, ?)");
    $query4->execute(
      array(
        $tc_id, $height, $weight, $blood
      )
    );
    if($finished != -1){
      if($query4->rowCount() == 0){
        $finished = -1;
      }
      else{
        $finished = 1;
      }
    }
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

      <!-- Prescribe Patient -->
      <div class="row my-5">

        <div class="my-4 text-center">
          <h2 class="h2">HOSPITAL DATA MANAGEMENT SYSTEM</h2>
            <?php 
            if($finished == 1){ ?>
                <div class="badge bg-success text-wrap p-2 w-50" style="width: 6rem;">
                  Account Created Successfully!
                </div>
            <?php }
            else if($finished == -1){ ?>
              <div class="badge bg-danger text-wrap p-2 w-50" style="width: 6rem;">
                    Account Creation Failed!
              </div>
            <?php } ?>
        </div>
        
            

        <div class="col-12 col-md-5 mx-auto bg-form p-5 rounded">
          <div class="row text-center">

            <div class="col-12 text-left">
              <form class="row g-3 needs-validation" novalidate method="POST"> 
                <div class="col-md-6">
                  <label for="validationCustom01" class="form-label">First name</label>
                  <input type="text" name="first_name" class="form-control" id="validationCustom01" required>
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                  <div class="invalid-feedback">
                    Please write a name.
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="validationCustom02" class="form-label">Last name</label>
                  <input type="text" name="last_name" class="form-control" id="validationCustom02" required>
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                  <div class="invalid-feedback">
                    Please write a last name.
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="validationCustom02" class="form-label">TC</label>
                  <input type="number" min="0" max="2147483647" name="tc_id" class="form-control" id="validationCustom02" required>
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                  <div class="invalid-feedback">
                    Please provide a valid TC.
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="validationCustom02" class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" id="validationCustom02" required>
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                  <div class="invalid-feedback">
                    Please write a email.
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="validationCustom05" class="form-label">Password</label>
                  <input type="password" name="pass" class="form-control" id="validationCustom05" required>
                  <div class="invalid-feedback">
                    Please provide a password.
                  </div>
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="validationCustom05" class="form-label">Phone Number</label>
                  <input type="text" name="phone" class="form-control" id="validationCustom05" pattern="[0]{1}[0-9]{10}" required>
                  <div class="invalid-feedback">
                    Please provide a phone number starting with 0 and Max 11 Num.
                  </div>
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="validationCustom05" class="form-label">Birtdate</label>
                  <input type="date" name="bdate" max="2021-05-16" class="form-control" id="validationCustom05" required>
                  <div class="invalid-feedback">
                    Please provide a birtdate.
                  </div>
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="validationCustom04" class="form-label">Gender</label>
                  <select class="form-select" name="gender" id="validationCustom04" required>
                    <option selected disabled value="">Choose...</option>
                    <option>Male</option>
                    <option>Female</option>
                  </select>
                  <div class="invalid-feedback">
                    Please select a gender.
                  </div>
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                </div>
                <div class="col-md-6">
                <label for="validationCustom04" class="form-label">Blood Type</label>
                  <select class="form-select" name="btype" id="validationCustom04" required>
                    <option selected disabled value="">Choose...</option>
                    <option>A+</option>
                    <option>A-</option>
                    <option>B+</option>
                    <option>B-</option>
                    <option>AB+</option>
                    <option>AB-</option>
                    <option>O+</option>
                    <option>O-</option>
                  </select>
                  <div class="invalid-feedback">
                    Please identify your blood type.
                  </div>
                  <div class="valid-feedback">
                    Looks good!
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="validationCustom05" class="form-label">Height</label>
                  <input type="number" name="height" min="0" class="form-control" id="validationCustom05" required>
                  <div class="invalid-feedback">
                    Please provide a height.
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="validationCustom05" class="form-label">Weight</label>
                  <input type="number" name="weight" min="0" class="form-control" id="validationCustom05" required>
                  <div class="invalid-feedback">
                    Please provide a weight.
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-check text-left">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                    <label class="form-check-label" for="invalidCheck">
                      Agree to terms and conditions
                    </label>
                    <div class="invalid-feedback">
                      You must agree before submitting.
                    </div>
                    <div class="valid-feedback">
                      Looks good!
                    </div>
                  </div>
                </div>
                <div class="col-12 mt-5">
                    <button class="btn btn-danger p-3" type="submit">REGISTER PATIENT</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-12 mt-3">
          <form class="d-flex justify-content-center">
            <a href="index.php" class="btn btn-danger px-4">Return</a>
          </form>
        </div>

      </div>

    </div>


    <!-- Optional JavaScript; choose one of the two! -->
    <script type="text/javascript">
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
      .forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }

          form.classList.add('was-validated')
        }, false)
      })
    })()
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
