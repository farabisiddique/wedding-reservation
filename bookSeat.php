<?php
// Assuming db.php connects to your database and provides a PDO instance $conn
include 'db.php';

// Decode the JSON data from the AJAX request
$data = json_decode(file_get_contents('php://input'), true);
$programId = $data['programId'];
$guests = $data['guests'];
$bookerName = $data['bookerName'];
$bookerPhone = $data['bookerPhone'];
// $bookerPin = 0000;

try {
    $conn->beginTransaction();
    $stmtBooker = $conn->prepare("INSERT INTO wr_booker (booker_name, booker_phone) VALUES (:booker_name, :booker_phone)");
    $stmtBooker->execute([
        ':booker_name' => $bookerName,
        ':booker_phone' => $bookerPhone
    ]);
    $bookerId = $conn->lastInsertId(); 
    $bookerPin = str_pad($bookerId, 3, '0', STR_PAD_LEFT);
    // Update the booker_pin using the booker_id
    $stmtUpdatePin = $conn->prepare("UPDATE wr_booker SET booker_pin = :booker_pin WHERE booker_id = :booker_id");
    $stmtUpdatePin->execute([
        ':booker_pin' => $bookerPin,
        ':booker_id' => $bookerId
    ]);
  

    foreach ($guests as $guest) {
        // Extract table and chair numbers from the ID
        preg_match('/t(\d+)c(\d+)/', $guest['id'], $matches);
        $tableNumber = $matches[1];
        $chairNumber = $matches[2];
        $guestName = $guest['value'];

        // Prepare the UPDATE statement
        $stmt = $conn->prepare("UPDATE wr_positions SET position_guest_name = :guest_name , position_booker_id = :booker_id  WHERE program_id = :program_id AND position_table_number = :table_number AND position_chair_number = :chair_number");
        $stmt->execute([
            ':guest_name' => $guestName,
            ':booker_id' => $bookerId,
            ':program_id' => $programId,
            ':table_number' => $tableNumber,
            ':chair_number' => $chairNumber
        ]);
    }

    $conn->commit();
    echo $bookerPin;
} catch (PDOException $e) {
    // Rollback the transaction in case of error
    $conn->rollBack();
    // Handle any errors
    echo 0;
}
?>
