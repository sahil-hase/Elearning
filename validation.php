<?php 

session_start();

// Database connection
$host = "localhost";
$dbname = "postgres";
$user = "postgres";  // Replace with your PostgreSQL username
$password = "123";  // Replace with your PostgreSQL password
echo "hello";
$con = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if ($con) {
    echo "Connection successful";
} else {
    echo "No connection";
    exit();  // Stop execution if connection fails
}

// Get user inputs
$name = pg_escape_string($con, $_POST['name']);
$pass = pg_escape_string($con, $_POST['password']);
$email = pg_escape_string($con, $_POST['email']);

// Query to check if user exists
$q = "SELECT * FROM login WHERE username = '$name' AND password = '$pass'";
$result = pg_query($con, $q);

if (!$result) {
    echo "Query failed: " . pg_last_error($con);
    exit();
}

// Fetch result and check rows
$res = pg_fetch_assoc($result);
$num = pg_num_rows($result);

if ($num == 1) {
    if ($res['username'] == 'admin') {
        header("Location: admin/admin_main.php");
    } else {
        $_SESSION['username'] = $name;
        header("Location: index.php");
    }
} else {
    $_SESSION['error'] = "error";
    header("Location: login.php");
}

pg_close($con); // Close the connection

?>
