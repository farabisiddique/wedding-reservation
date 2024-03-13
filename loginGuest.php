<?php
// Include database connection
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pinno = !empty($_POST['pinno']) ? trim($_POST['pinno']) : null;

    // Prepare the SQL statement to select the booker by PIN
    $sql = "SELECT * FROM wr_booker WHERE booker_pin = :pinno";
    $stmt = $conn->prepare($sql);

    // Bind parameter
    $stmt->bindParam(':pinno', $pinno);

    // Execute the statement
    $stmt->execute();

    // Fetch the booker
    $booker = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($booker) {
        $bookerId = $booker['booker_id'];
        header('Location: myBooking.php?id='.$bookerId);
    } else {
        echo "Incorrect PIN No. Please try again.";
        // Optionally, provide a link back to the login form.
    }
} else {
    // If not accessed via POST, redirect back to the login form or display an error.
    echo "Invalid access method.";
}
?>
