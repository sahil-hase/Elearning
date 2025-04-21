<?php
session_start();

// PostgreSQL Database Connection
$host = "localhost";
$dbname = "postgres";  // Updated to 'postgres'
$user = "postgres";    // Updated to 'postgres'
$password = "123";     // Updated to '123'

try {
    $con = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Securely fetch course details
if (isset($_POST['txt1'])) {
    $id = $_POST['txt1'];

    // Use a prepared statement to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM courses WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($res) {
        $_SESSION['message'] = $res['description'];
        header("location: java_programming.php?course_name=" . urlencode($res['course_name']));
        exit(); // Prevent further execution
    } else {
        echo "No course found!";
    }
} else {
    echo "Invalid request!";
}
?>
