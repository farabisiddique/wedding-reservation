<?php

session_start(); 

include('db.php'); 
$host = $_SESSION['user_id'];
$sql = "SELECT * FROM wr_programs WHERE prog_host_id='$host'";
$stmt = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Host Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./table.css">
    <style>
        .logoutBtn{
          position: absolute;
          top: 0;
          right: 0;
        }

        .searchGuest{
          position: absolute;
          top: 0;
          right: 100px;
        }

        .createProgram{
          position: absolute;
          top: 0;
          right: 260px;
        }
    </style>
  </head>
  <body>
    
    <div class="container mt-5 position-relative">
      <a class="btn btn-secondary createProgram" href='./createProgram.php'>Create Program</a>
      <a class="btn btn-secondary searchGuest" href='./search.php'>Search A Guest</a>
      <a class="btn btn-primary logoutBtn" href='./logoutHost.php'>Logout</a>
      <h2>Select a Program</h2> 
      
      <select class="form-select" id="programSelect" aria-label="Select Program">
        <option selected>Open this select menu</option>
        <?php
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='{$row['prog_id']}'>{$row['prog_name']}</option>";
          }
        ?>
      </select>
      <p class='inviteURL mt-3'></p>
      <div id="guestList" class="mt-4">
                  <div class="row">
                        <div class="col-lg-2 mx-auto my-4">
                          <button class="btn btn-primary" id="updateButton" style="display: none;" onclick="updateGuest()">Update</button>
                        </div>
                  </div>
          </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./myPrograms.js"></script>
    <script>
            function updateGuest() {
                // e.preventDefault(); // Prevent default form submission if it's part of a form
                
                var programId = $('#programSelect').val(); // Assuming this is your select element's ID
                var guests = [];
                

                $('.guestName').each(function() {
                        var guestId = $(this).attr('id'); // e.g., "t1c1"
                        var guestName = $(this).val(); 
                        guests.push({id: guestId, value: guestName});
                });

                // Perform the AJAX request
                $.ajax({
                    url: 'update_guests.php',
                    type: 'POST',
                    data: {
                        programId: programId,
                        guests: guests
                    },
                    success: function(response) {
                        console.log('Update Successful:', response);
                        alert('Guest positions updated successfully.');
                    },
                    error: function(xhr, status, error) {
                    }
                });
            }

    </script>
    

  </body>
</html>