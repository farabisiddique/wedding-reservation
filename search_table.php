<?php
include 'db.php'; // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['tableNumber'])) {
    $tableNumber = $_POST['tableNumber'];

    $sql = "SELECT position_chair_number, position_guest_name 
            FROM wr_positions 
            WHERE position_table_number = :tableNumber 
            ORDER BY position_chair_number ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tableNumber', $tableNumber, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        echo "<ul>";
        foreach ($results as $row) {
            $guestName = !empty($row['position_guest_name']) ? htmlspecialchars($row['position_guest_name']) : "Empty Seat";
            echo "<li>Chair " . htmlspecialchars($row['position_chair_number']) . ": " . $guestName . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No guests found for Table " . htmlspecialchars($tableNumber) . ".";
    }
} else {
    echo "Please enter a table number to search.";
}
?>
