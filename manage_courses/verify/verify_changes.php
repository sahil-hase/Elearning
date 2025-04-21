<?php
try {
    // PostgreSQL Connection
    $con = new PDO("pgsql:host=localhost;dbname=postgres", "postgres", "123");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // =============================================================================================================
    // Add a new topic in the courses table (request came from add_new_topic.php)
    if (isset($_POST['submitbtn'])) {
        if (!empty($_POST['topic_name']) && !empty($_POST['coursename']) && !empty($_POST['editor'])) {
            $topicname = trim($_POST['topic_name']);
            $coursename = trim($_POST['coursename']);
            $description = trim($_POST['editor']);

            // Insert query using prepared statement
            $query = "INSERT INTO courses (topic_name, description, course_name) VALUES (:topic_name, :description, :course_name)";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':topic_name', $topicname, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':course_name', $coursename, PDO::PARAM_STR);

            if ($stmt->execute()) {
                header("Location: ../edit_topics.php?course_name=" . urlencode($coursename));
                exit();
            } else {
                echo "Error inserting topic.";
            }
        } else {
            echo "All fields are required.";
        }
    }

    // =============================================================================================================
    // Update a topic in the courses table (request came from update_topic.php)
    if (isset($_POST['submitupdate'])) {
        if (!empty($_POST['cors_id']) && !empty($_POST['coursename']) && !empty($_POST['topic_name']) && !empty($_POST['editor'])) {
            $course_id = trim($_POST['cors_id']);
            $course_name = trim($_POST['coursename']);
            $topic_name = trim($_POST['topic_name']);
            $description = trim($_POST['editor']);

            // Update query using prepared statement
            $query = "UPDATE courses SET topic_name = :topic_name, description = :description, course_name = :course_name WHERE id = :course_id";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':topic_name', $topic_name, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':course_name', $course_name, PDO::PARAM_STR);
            $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: ../edit_topics.php?course_name=" . urlencode($course_name));
                exit();
            } else {
                echo "Error updating topic.";
            }
        } else {
            echo "All fields are required.";
        }
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
