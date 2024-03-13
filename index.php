<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-5">
        <h2 class="mb-3">Login Page</h2>
        <!-- Tabs nav -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#host">Login as Host</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#guest">Login as Guest</a>
            </li>
        </ul>

        <!-- Tabs content -->
        <div class="tab-content">
            <div class="tab-pane active container mt-3" id="host">
                <form action="loginHost.php" method="post">
                    <div class="mb-3">
                        <label for="hostEmail" class="form-label">Host Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
                    </div>
                    <div class="mb-3">
                        <label for="hostPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login as Host</button>
                </form>
            </div>
            <div class="tab-pane container mt-3" id="guest">
                <form action="loginGuest.php" method="post">
                    <div class="mb-3">
                        <label for="pinno" class="form-label">PIN No</label>
                        <input type="text" class="form-control" id="pinno" name="pinno" placeholder="Enter Your PIN No">
                    </div>
        
                    <button type="submit" class="btn btn-primary">Login as Guest</button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>