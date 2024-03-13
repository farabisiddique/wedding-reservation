<?php
session_start(); // Start a new session or resume the existing one

// Include database connection settings
include('db.php'); // Ensure this file contains your PDO database connection setup

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;

    // Prepare a select statement
    $sql = "SELECT * FROM wr_host WHERE host_username = :username";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':username', $username);

    // Execute the statement
    $stmt->execute();

    // Fetch the row
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // If $user is FALSE, the username does not exist
    if($user === false){
        // Handle error - send user back to login form
        die('Incorrect username / password combination!');
    } else {
        // Compare the passwords
        // $validPassword = password_verify($password, $user['host_password']);

        // If $validPassword is TRUE, the login has been successful
        if($password==$user['host_password']){
            // Provide the user with a login session
            $_SESSION['user_id'] = $user['host_id'];
            $_SESSION['logged_in'] = time();

            // Redirect to their desired page
            header('Location: myPrograms.php'); // Change 'success.php' to the script you want to direct to after login
            exit;

        } else{
            // Handle error - send user back to login form
            die('Incorrect username / password combination!');
        }
    }
} else {
    // Redirect them to the login page
    header('Location: index.php');
    exit;
}
?>
