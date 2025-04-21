<?php
try {
    // PostgreSQL Connection
    $con = new PDO("pgsql:host=localhost;dbname=postgres", "postgres", "123");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ensure required fields are set
    if (isset($_POST['topic_name'], $_POST['coursename'], $_POST['editor'])) {
        $topicname = trim($_POST['topic_name']);
        $coursename = trim($_POST['coursename']);
        $description = trim($_POST['editor']);

        // Insert data using prepared statement
        $query = "INSERT INTO courses (topic_name, description, course_name) VALUES (:topicname, :description, :coursename)";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':topicname', $topicname, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':coursename', $coursename, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: admin_edit_courses.php?course_name=" . urlencode($coursename));
            exit();
        } else {
            echo "Error inserting course.";
        }
    } else {
        echo "All fields are required.";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
