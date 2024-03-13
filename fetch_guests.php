<?php
// Include database connection
include 'db.php'; // Ensure this points to your actual database connection setup file

if(isset($_POST['programId'])) {
    $programId = $_POST['programId'];

    // Prepare the SQL query to fetch seating arrangements for the selected program
    $sql = "SELECT position_table_number, position_chair_number, position_guest_name FROM wr_positions WHERE program_id = :programId ORDER BY position_table_number ASC, position_chair_number ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':programId', $programId, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Organize data by table numbers
    $tables = [];
    foreach ($results as $row) {
        $tables[$row['position_table_number']][] = $row;
    }

    // Iterate through tables and display guests
    foreach ($tables as $tableNumber => $chairs) {
        echo "<div class='col-lg-4 border border-2 mb-3'>";
        echo "<p class='text-center'>Table " . htmlspecialchars($tableNumber) . "</p>";

        foreach ($chairs as $chair) {
            echo "<div class='d-flex justify-content-start align-items-center gap-2 mb-3'>";
            echo "<img src='./chair.jpg' class='chairIcon' />";
            echo "<span class='chairNo'>Chair " . htmlspecialchars($chair['position_chair_number']) . "</span>";
            
            $guestName = $chair['position_guest_name'] ? htmlspecialchars($chair['position_guest_name']) : "";
            $inputId = "t" . htmlspecialchars($tableNumber) . "c" . htmlspecialchars($chair['position_chair_number']);
            
            echo "<div class='input-group'>";
            echo "<input type='text' class='form-control guestName' id='" . $inputId . "' value='" . $guestName . "' placeholder='Write Guest Name Here'>";
            echo "<div class='input-group-append removeGuest'>";
            echo "<span class='input-group-text d-flex'>";
            echo "<img src='./trash.png'> ";
            echo "</span></div></div></div>";
        }

        echo "</div>"; 
    }


} else {
    echo "Program ID not provided.";
}
?>
