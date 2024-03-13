<?php
include 'db.php'; // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['guestName'])) {
    $guestName = "%" . $_POST['guestName'] . "%";

    $sql = "SELECT position_table_number, position_chair_number, position_guest_name 
            FROM wr_positions 
            WHERE position_guest_name LIKE :guestName 
            ORDER BY position_table_number, position_chair_number ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':guestName', $guestName, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        echo "<ul>";
        foreach ($results as $row) {
            echo "<li>" . htmlspecialchars($row['position_guest_name']) . " is allocated at Table " . htmlspecialchars($row['position_table_number']) . ", Chair " . htmlspecialchars($row['position_chair_number']) . ".</li>";
        }
        echo "</ul>";
    } else {
        echo "No matching guest found.";
    }
} else {
    echo "Please enter a guest name to search.";
}
?>
