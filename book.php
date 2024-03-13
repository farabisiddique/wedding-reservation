<?php
// Include your database connection file
include 'db.php'; // Adjust the path as necessary to include your actual connection script

// Get the program ID from the URL parameter
$programId = $_GET['pid'];


$program_sql = "SELECT * FROM wr_programs WHERE prog_id = :programId";
$program_stmt = $conn->prepare($program_sql);

// Bind the programId parameter to the prepared statement
$program_stmt->bindParam(':programId', $programId, PDO::PARAM_INT);

// Execute the statement
$program_stmt->execute();

// Fetch the program data
$programData = $program_stmt->fetch(PDO::FETCH_ASSOC);


try {
    // Prepare the SQL statement to select all positions for the given program ID
    $stmt = $conn->prepare("SELECT * FROM wr_positions WHERE position_guest_name IS NULL AND program_id = :programId ORDER BY position_table_number, position_chair_number ASC");

    // Bind the programId parameter
    $stmt->bindParam(':programId', $programId, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();

    // Initialize an array to hold the table and chair numbers
    $tablesAndChairs = [];

    // Check if there are any results
    if ($stmt->rowCount() > 0) {
        // Fetch all the matching records
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Process the results to fill tablesAndChairs array
        foreach ($results as $row) {
            // If the table number isn't already a key in the array, add it
            if (!array_key_exists($row['position_table_number'], $tablesAndChairs)) {
                $tablesAndChairs[$row['position_table_number']] = [];
            }
            // Add the chair number to the corresponding table's array
            $tablesAndChairs[$row['position_table_number']][] = $row['position_chair_number'];
        }
    }

    

    // Output the tablesAndChairs array for demonstration
    

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Seat For Program</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./table.css">
  </head>
  <body>

    <div class="container mt-5">
        <h3> Reserve Table For
          <span class="programName"><?php echo htmlspecialchars($programData['prog_name']); ?></span> on 
          <span class="programDateTime"><?php echo (new DateTime($programData['prog_date_time']))->format('jS F, Y \a\t g:i A'); ?></span>
        </h3>
        <?php 
          if(count($tablesAndChairs)>0){
        
        ?>
        <form id="bookSeat">
          <div class="mb-3">
            <label for="bookerName" class="form-label">Booker's Name</label>
            <input type="text" class="form-control" id="bookerName" name="bookerName" required>
          </div>
          <div class="mb-3">
            <label for="bookerPhone" class="form-label">Booker's Phone Number</label>
            <input type="number" class="form-control" id="bookerPhone" name="bookerPhone" required>
          </div>
          <div class="row">
              
              <?php 
                  foreach( $tablesAndChairs as $tableNumber => $chairs ){
                    
              ?>
                    <div class="col-lg-4 border border-2">
                        <p class="text-center">Table <?php echo $tableNumber; ?></p>
                        <?php 
                            foreach( $chairs as $chairNumber ){
                                 
                        ?>
                        <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
                          <img src="./chair.jpg" class="chairIcon" />
                          <span class="chairNo">Chair <?php echo $chairNumber; ?></span>
                          <div class="input-group">
                            <input type="text" class="form-control guestName" id="<?php echo "t".$tableNumber."c".$chairNumber; ?>" placeholder="Write Guest Name Here">
                            <div class="input-group-append removeGuest">
                              <span class="input-group-text d-flex ">
                                <img src="./trash.png"> 
                              </span>
                            </div>
                          </div>
                        </div>
                        <?php } ?>
                        
                    </div>
            <?php } ?>
              
          </div>
          <div class="row">
            <div class="col-lg-2 mx-auto my-4">
               <button type="submit" class="btn btn-primary">Confirm</button>
            </div>
            
          </div>
         
        </form>
        <?php 
          }
          else{
        ?>
        <h3 class="text-center mt-3">Sorry! No Seat Available.</h3>
        <?php 
          }
        ?>

      
    </div>
    
    <!-- Bootstrap Modal -->
    <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="responseModalLabel">Booking Confirmation</h5>
            <button type="button" class="btn-close closeResponseModal" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Response content will be placed here -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary closeResponseModal" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
          $('.removeGuest').click(function() {
            $(this).siblings('input[type="text"]').val('');
          });

          $("#bookSeat").submit(function(e){
              e.preventDefault();
              var bookerName = $("#bookerName").val();
              var bookerPhone = $("#bookerPhone").val();
              var guestNames = [];
              $('.guestName').each(function() {
                var value = $(this).val().trim(); // Get the trimmed value of the current input
                var id = $(this).attr('id'); // Get the ID of the current input

                // Check if the input is not empty
                if(value !== "") {
                  guestNames.push({id: id, value: value}); // Add the ID and value to the guestNames array
                }
              });

              var programId = <?php echo json_encode($programId); ?>;
              // Send the data using AJAX to a PHP script for database insertion
              $.ajax({
                url: './bookSeat.php', // Path to your PHP script
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ bookerName: bookerName, bookerPhone: bookerPhone, programId: programId, guests: guestNames }), // Convert data to JSON string
                success: function(response) {
                    $('#responseModal .modal-body').html("Your Booking Is Confirmed! Remember This Pin No for Updating Booking: "+response);
                    // Show the modal
                    var modal = new bootstrap.Modal(document.getElementById('responseModal'));
                    modal.show();
                },
                error: function(xhr, status, error) {
                  console.error(error); 
                }
              });
              
          });

          $(".closeResponseModal").click(function(){
            location.reload();

          });

          
          
        });
    </script>

    
  </body>
</html>