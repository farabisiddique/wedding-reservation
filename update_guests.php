<?php
// Include your database connection
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract the program ID from the request
    $programId = $_POST['programId'];

    // Begin a transaction
    $conn->beginTransaction();

    try {
        // Assuming guests data is sent as an array of objects or associative arrays
        // Each guest entry includes 'id' (format "tXcY" where X is table number, Y is chair number) and 'value' (guest name)
        foreach ($_POST['guests'] as $guest) {
            // Extract table and chair numbers from the id (expected format "tXcY")
            list($tableNumber, $chairNumber) = explode('c', substr($guest['id'], 1));
            
            // Prepare the SQL statement to update the guest's name
            $sql = "UPDATE wr_positions SET position_guest_name = :guest_name WHERE program_id = :program_id AND position_table_number = :table_number AND position_chair_number = :chair_number";
            $stmt = $conn->prepare($sql);
            
            if($guest['value']==''){
                $guest['value']= NULL;
            }
            // Bind parameters and execute
            $stmt->execute([
                ':guest_name' => $guest['value'],
                ':program_id' => $programId,
                ':table_number' => $tableNumber,
                ':chair_number' => $chairNumber
            ]);
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
