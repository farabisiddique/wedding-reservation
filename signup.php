<?php
// Include the database connection script
include './db.php'; // Update this path if necessary

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sUsername']) && isset($_POST['sPassword'])) {
    $username = $_POST['sUsername'];
    $password = $_POST['sPassword']; // Securely hash the password

    try {
        // Prepare SQL statement to insert a new user
        $sql = "INSERT INTO wr_host (host_username, host_password) VALUES (:username, :password)";
        $stmt = $conn->prepare($sql);
        
        // Bind parameters to statement
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        
        // Execute the prepared statement
        $stmt->execute();
        
        echo "Account created successfully.";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
