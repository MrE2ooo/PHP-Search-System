<?php
// Include the database connection file
require_once 'includes/dbh.inc.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $userSearch = $_POST['usersearch'];

    try {
        // Prepare the SQL query to search for comments by username
        $sql = "SELECT comments.comment_text, users.username, comments.created_at 
                FROM comments 
                JOIN users ON comments.user_id = users.id 
                WHERE users.username = :usersearch";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usersearch', $userSearch, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Fetch all results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database errors
        die("Error: " . $e->getMessage());
    }
} else {
    // Redirect 
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h3>Search Results:</h3>
    <?php
    function echobr() {
        echo "<br>";
    }

    if (empty($results)) {
        echo "<div>";
        echo "<p>No results found for '" . htmlspecialchars($userSearch) . "'.</p>";
        echo "</div>";
    } else {
        echo "<ul>";
        foreach ($results as $row) {
            echo "<li><strong>" . htmlspecialchars($row['username']) . ":</strong> " . htmlspecialchars($row['comment_text']);
            echobr();
            echo "Posted on: " . htmlspecialchars($row['created_at']) . "</li>";
        }
        echo "</ul>";
    }
    ?>
</body>
</html>
