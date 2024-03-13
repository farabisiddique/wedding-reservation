<?php
// Include your database connection
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentBookerId = $_POST['bookerId']; // The current booker's ID as part of the request

    $conn->beginTransaction();

    try {
        foreach ($_POST['guests'] as $guest) {
            list($tableNumber, $chairNumber) = explode('c', substr($guest['id'], 1));

            $guestName = $guest['value'] === '' ? NULL : $guest['value'];

            // Prepare the SQL statement to update the guest's name and booker ID for the position
            $updateSql = "UPDATE wr_positions SET position_guest_name = :guest_name, position_booker_id = :booker_id WHERE position_table_number = :table_number AND position_chair_number = :chair_number";
            $updateStmt = $conn->prepare($updateSql);

            // Bind parameters and execute
            $updateStmt->bindParam(':guest_name', $guestName);
            $updateStmt->bindParam(':booker_id', $currentBookerId);
            $updateStmt->bindParam(':table_number', $tableNumber);
            $updateStmt->bindParam(':chair_number', $chairNumber);

            // Execute the update
            $updateStmt->execute();
        }

        // Commit the transaction
        $conn->commit();
        echo "Guest positions updated successfully.";
    } catch (Exception $e) {
        // An error occurred; rollback the transaction and report the error
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
