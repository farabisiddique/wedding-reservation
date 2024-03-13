<?php
// Include database connection
include 'db.php';

// Assuming you have the booker_id from somewhere, like a session or direct input
$bookerId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Prepare the SQL query to fetch all positions
// This version of the query marks positions as 'disabled' if they are booked by someone other than the current viewer and have a non-null guest name
$sql = "SELECT position_table_number, position_chair_number, position_guest_name, position_booker_id,
        (position_booker_id != :bookerId AND position_guest_name IS NOT NULL) AS is_disabled
        FROM wr_positions
        ORDER BY position_table_number ASC, position_chair_number ASC";

$stmt = $conn->prepare($sql);

// Bind the bookerId parameter
$stmt->bindParam(':bookerId', $bookerId, PDO::PARAM_INT);

// Execute the query
$stmt->execute();

// Fetch all positions
$positions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Organize positions by table for display
$tables = [];
foreach ($positions as $position) {
    $tables[$position['position_table_number']][] = $position;
}
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Booking For Program</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./table.css">
    <style>
        .logoutBtn{
          position: absolute;
          top: 0;
          right: 0;
        }
    </style>
</head>
<body>

<div class="container mt-5 position-relative">
    <a class="btn btn-primary logoutBtn" href='./index.php'>Logout</a>
    <h3>Your reserved seats</h3>
    <div class="row">
        <?php foreach ($tables as $tableNumber => $chairs): ?>
            <div class="col-lg-4 border border-2">
                <p class="text-center">Table <?php echo $tableNumber; ?></p>
                <?php foreach ($chairs as $chair): ?>
                    <div class="d-flex justify-content-start align-items-center gap-2 mb-3">
                        <img src="./chair.jpg" class="chairIcon">
                        <span class="chairNo">Chair <?php echo $chair['position_chair_number']; ?></span>
                        <div class="input-group">
                            <input type="text" class="form-control guestName" id="t<?php echo $tableNumber; ?>c<?php echo $chair['position_chair_number']; ?>" 
                                value="<?php echo htmlspecialchars($chair['position_guest_name']); ?>" 
                                placeholder="Enter Guest Name" 
                                <?php echo $chair['is_disabled'] ? 'disabled' : ''; ?>>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <div class="row">
                        <div class="col-lg-2 mx-auto my-4">
                          <button class="btn btn-primary" id="updateButton" onclick="updateBooking()">Update</button>
                        </div>
                  </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
            function updateBooking() {
                
                var guests = [];
                

                $('.guestName').each(function() {
                        var guestId = $(this).attr('id'); // e.g., "t1c1"
                        var guestName = $(this).val(); 
                        guests.push({id: guestId, value: guestName});
                });
                var bookerId = <?php echo json_encode($bookerId); ?>;
                // Perform the AJAX request
                $.ajax({
                    url: 'update_booking.php',
                    type: 'POST',
                    data: {
                        bookerId: bookerId,
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
