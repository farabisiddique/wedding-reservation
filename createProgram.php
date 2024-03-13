<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create A Program</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
        .logoutBtn{
          position: absolute;
          top: 0;
          right: 0;
        }

        .createProgram{
          position: absolute;
          top: 0;
          right: 100px;
        }
    </style>
</head>
<body>

  <div class="container mt-5 position-relative">
      <a class="btn btn-secondary createProgram" href='./myPrograms.php'>My Programs</a>
      <a class="btn btn-primary logoutBtn" href='./logoutHost.php'>Logout</a>
      <h2>Add Program</h2>
      <form action="./cp.php" method="post">
          <div class="form-group">
              <label for="prog_name">Program Name</label>
              <input type="text" class="form-control" id="prog_name" name="prog_name" required>
          </div>
          <div class="form-group">
              <label for="prog_date_time">Program Date and Time</label>
              <input type="datetime-local" class="form-control" id="prog_date_time" name="prog_date_time">
          </div>
          <div class="form-group">
              <label for="prog_no_of_tables">Number of Tables</label>
              <input type="number" class="form-control" id="prog_no_of_tables" name="prog_no_of_tables" value="5" required>
          </div>
          <!-- prog_created_at value will be automatically generated by the database -->
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>
  </div>


    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>