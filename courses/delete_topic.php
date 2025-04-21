<?php
// Get course details from URL parameters
$course_name = $_GET['course_name'];
$id = $_GET['course_id'];

try {
    // PostgreSQL connection
    $con = new PDO("pgsql:host=localhost;dbname=postgres", "postgres", "123");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Delete course safely using prepared statements
    $query = "DELETE FROM courses WHERE id = :id";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        header("Location: admin_edit_courses.php?course_name=" . urlencode($course_name));
        exit(); // Ensure script stops after redirect
    } else {
        echo "Error deleting the course.";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
