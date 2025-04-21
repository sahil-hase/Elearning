<?php
try {
    // PostgreSQL Connection
    $con = new PDO("pgsql:host=localhost;dbname=postgres", "postgres", "123");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if course_id exists
    if (isset($_GET['course_id']) && !empty($_GET['course_id']) && isset($_GET['course_name'])) {
        $id = trim($_GET['course_id']);
        $course_name = trim($_GET['course_name']);

        // Delete query using prepared statement
        $query = "DELETE FROM courses WHERE id = :id";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: ../edit_topics.php?course_name=" . urlencode($course_name));
            exit();
        } else {
            echo "Error deleting course.";
        }
    } else {
        echo "Invalid course ID.";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
