<?php
// Include the database connection script
include 'db.php'; // Adjust the path as necessary

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $default_chair_per_table = 2;
    $prog_host_id = 1; // Assuming this comes from the form now
    $prog_name = $_POST['prog_name'];
    $prog_date_time = $_POST['prog_date_time'];
    
    $prog_no_of_tables = $_POST['prog_no_of_tables'];

    try {
        // Insert the new program
        $stmt = $conn->prepare("INSERT INTO wr_programs (prog_name, prog_date_time, prog_host_id, prog_no_of_tables) VALUES (:prog_name, :prog_date_time, :prog_host_id, :prog_no_of_tables)");
        $stmt->bindParam(':prog_name', $prog_name);
        $stmt->bindParam(':prog_date_time', $prog_date_time);
        $stmt->bindParam(':prog_host_id', $prog_host_id);
        $stmt->bindParam(':prog_no_of_tables', $prog_no_of_tables);
        $stmt->execute();

        // Retrieve the ID of the newly inserted program
        $prog_id = $conn->lastInsertId();

        // Prepare the SQL statement for inserting position data
        $stmt = $conn->prepare("INSERT INTO wr_positions (program_id, position_table_number, position_chair_number) VALUES (:program_id, :position_table_number, :position_chair_number)");

        // Loop through each table
        for ($tableNum = 1; $tableNum <= $prog_no_of_tables; $tableNum++) {
            // For each table, insert chairs 1 to 10
            for ($chairNum = 1; $chairNum <= $default_chair_per_table; $chairNum++) {
                $stmt->bindParam(':program_id', $prog_id);
                $stmt->bindParam(':position_table_number', $tableNum);
                $stmt->bindParam(':position_chair_number', $chairNum);
                $stmt->execute();
            }
        }

        header('Location: myPrograms.php');
        // Optionally, redirect to a confirmation page or back to the form
        // header('Location: success_page.php');
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
