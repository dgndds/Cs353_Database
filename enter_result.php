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
            <a class="navbar-brand">Welcome Doctor Murat Kuşçu</a>
            <form class="d-flex">
              <button class="btn btn-danger" type="submit">Logout</button>
            </form>
          </div>
        </nav>
      </div>

      <!-- Prescribe Patient -->
      <div class="row mb-4">

        <div class="my-4 text-center">
          <h2 class="h2">NEW TEST</h2>
        </div>


        <div class="col-5 mx-auto bg-form p-4 rounded">

            <div class="col-6 mx-auto">

              <div class="row mb-3">
                <div class="col-5">
                  <label for="inputPassword6" class="col-form-label">Patient Name</label>
                </div>
                <div class="col-7">
                  <input type="text" class="form-control d-inline" aria-describedby="passwordHelpInline">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-5">
                  <label for="inputPassword6" class="col-form-label">Test Name</label>
                </div>
                <div class="col-7">
                  <input type="text" class="form-control d-inline" aria-describedby="passwordHelpInline">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-5">
                  <label for="inputPassword6" class="col-form-label">Test Type</label>
                </div>
                <div class="col-7">
                  <input type="text" class="form-control d-inline" aria-describedby="passwordHelpInline">
                </div>
              </div>

              <div class="row">
                <div class="col-5">
                  <label for="inputPassword6" class="col-form-label">Magnesium</label>
                </div>
                <div class="col-7">
                  <input type="text" class="form-control d-inline" aria-describedby="passwordHelpInline">
                </div>
              </div>
            </div>
          </form>
      </div>

      <div class="col-8 mx-auto mt-3">
        <form class="d-flex justify-content-center">
          <button class="btn btn-danger p-2" type="submit">Register Test</button>
        </form>
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
