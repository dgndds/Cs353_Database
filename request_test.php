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
            <a class="navbar-brand">Welcome Hakan Kara</a>
            <form class="d-flex">
              <button class="btn btn-danger" type="submit">Logout</button>
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

          <div class="row mb-3">
            <div class="col-6 text-right">
              <p class="d-inline" style="font-size:1.3rem;"><b>Patient: </b></p>
            </div>
            <div class="col-6">
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  February
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <li><a class="dropdown-item" href="#">March</a></li>
                  <li><a class="dropdown-item" href="#">May</a></li>
                  <li><a class="dropdown-item" href="#">June</a></li>
                </ul>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-6 text-right">
              <p class="d-inline" style="font-size:1.3rem;"><b>Test Type: </b></p>
            </div>
            <div class="col-6">
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  February
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <li><a class="dropdown-item" href="#">March</a></li>
                  <li><a class="dropdown-item" href="#">May</a></li>
                  <li><a class="dropdown-item" href="#">June</a></li>
                </ul>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-6 text-right">
              <p class="d-inline" style="font-size:1.3rem;"><b>Components: </b></p>
            </div>
            <div class="col-6">
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  February
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <li><a class="dropdown-item" href="#">March</a></li>
                  <li><a class="dropdown-item" href="#">May</a></li>
                  <li><a class="dropdown-item" href="#">June</a></li>
                </ul>
              </div>
            </div>
          </div>

          <div class="row text-center">

            <div class="col-12">
              <form class="d-flex justify-content-center">
                <button class="btn btn-success px-3" type="submit">Add Component</button>
              </form>
            </div>

            <div class="col-12 text-center mt-3">
                <h3 class="h3">Requested Components</h3>
                <p>Magnesium, Magnesium, Magnesium, Magnesium</p>
            </div>

            <div class="col-12">
              <form class="d-flex justify-content-center">
                <button class="btn btn-success px-3" type="submit">Submit</button>
              </form>
            </div>

          </div>

        </div>

        <div class="col-12 text-center mt-3">
          <a href="view_patients.php" class="btn btn-danger p-2">Return</a>
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
