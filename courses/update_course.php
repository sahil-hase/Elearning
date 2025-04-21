<?php 
include "../includes/header.php";

try {
    // PostgreSQL Connection
    $con = new PDO("pgsql:host=localhost;dbname=postgres", "postgres", "123");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ensure course_id is set and is a valid integer
    if (isset($_GET['course_id']) && is_numeric($_GET['course_id'])) {
        $course_id = $_GET['course_id'];

        // Fetch course details using prepared statement
        $query = "SELECT * FROM courses WHERE id = :course_id";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->execute();
        $course = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($course) { 
?>
            <form method="POST" action="verify_update.php">
                <input type="hidden" name="cors_id" value="<?php echo htmlspecialchars($course['id']); ?>">
                
                <label>Enter topic name:</label>
                <input type="text" name="topic_name" class="form-control" value="<?php echo htmlspecialchars($course['topic_name']); ?>" required><br>

                <label>Enter course name:</label>
                <input type="text" name="coursename" class="form-control" value="<?php echo htmlspecialchars($course['course_name']); ?>" required><br>

                <label>Enter the content:</label>
                <textarea id="editor" name="editor" class="ckeditor" placeholder="Enter the content..."><?php echo htmlspecialchars($course['description']); ?></textarea>

                <button type="submit" name="submitupdate" class="btn btn-success">Submit</button>
            </form>

            <script src="../ckeditor/ckeditor.js"></script>
<?php 
        } else {
            echo "<p>No course found with the given ID.</p>";
        }
    } else {
        echo "<p>Invalid Course ID.</p>";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
