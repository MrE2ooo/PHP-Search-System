//formhandler.inc.php
<?php
// Include the database connection file
require_once 'dbh.inc.php';

// Get form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert data into the database
try {
    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);

    if ($stmt->execute()) {
        // Redirect to the form page with a success message
        header("Location: ../index.php?message=Registration+successful!");
        exit();
    } else {
        // Redirect to the form page with an error message
        header("Location: ../index.php?message=Error:+Registration+failed");
        exit();
    }
} catch (PDOException $e) {
    // Redirect to the form page with an error message
    header("Location: ../index.php?message=Error:+". urlencode($e->getMessage()));
    exit();
}

// Close the connection
$conn = null;
?>