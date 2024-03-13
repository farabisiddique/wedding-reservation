<?php
// This script fetches booking information based on booker_id and outputs JavaScript code to fill in the guest names

// Include database connection
include 'db.php';

// Assuming you know the booker_id, for example:
$bookerId = 13; // This should be dynamically determined based on your application's logic

// Prepare the SQL query to fetch booking information
$sql = "SELECT * FROM wr_positions WHERE position_booker_id = :bookerId";
$stmt = $conn->prepare($sql);

// Bind the bookerId parameter
$stmt->bindParam(':bookerId', $bookerId, PDO::PARAM_INT);

// Execute the query
$stmt->execute();

// Fetch all booking records
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output JavaScript to populate the input fields
echo "<script>";
foreach ($bookings as $booking) {
    $inputId = "t" . $booking['position_table_number'] . "c" . $booking['position_chair_number'];
    $guestName = $booking['position_guest_name'];
    echo "document.getElementById('$inputId').value = " . json_encode($guestName) . ";";
}
echo "</script>";
?>
