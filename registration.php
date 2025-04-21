<?php 

session_start();

// Database connection
$host = "localhost";
$dbname = "postgres";
$user = "postgres";  // Replace with your PostgreSQL username
$password = "123";  // Replace with your PostgreSQL password

$con = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if ($con) {
    echo "Connection successful";
} else {
    echo "No connection";
    exit();
}

// Get user inputs and prevent SQL injection
$name = pg_escape_string($con, $_POST['name']);
$pass = pg_escape_string($con, $_POST['password']);
$email = pg_escape_string($con, $_POST['email']);

// Check if user already exists
$q = "SELECT * FROM login WHERE username = '$name' AND password = '$pass'";
$result = pg_query($con, $q);

if (!$result) {
    echo "Query failed: " . pg_last_error($con);
    exit();
}

// Count matching rows
$num = pg_num_rows($result);

if ($num == 1) {
    echo "Duplicate data";
    header("Location: signup.html");
    exit();  // Stop execution after redirection
} else {
    // Insert new user
    $qy = "INSERT INTO login(username, password, email) VALUES('$name', '$pass', '$email')";
    $insert_result = pg_query($con, $qy);

    if ($insert_result) {
        echo "Inserted";
        header("Location: login.php");
        exit();
    } else {
        echo "Insertion failed: " . pg_last_error($con);
    }
}

pg_close($con); // Close connection

?>
