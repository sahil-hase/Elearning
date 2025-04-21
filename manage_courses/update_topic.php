<!DOCTYPE html>
<html>
<head>
    <title>Update Topic</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Quicksand|Open+Sans|Lato" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .sidebar-list {
            font-family: 'Quicksand', sans-serif;
            font-size: 14px;
        }
        .sidebar-list li:hover {
            background-color: deepskyblue !important;
        }
        .sidebar-list li a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>

<?php require("../includes/navbar.php"); ?>  <!-- Navigation Bar -->

<div class="container-fluid" style="margin-top: 50px;">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-sm-2 col-md-2 sidebar badge-dark" id="sidebar">
            <ul class="list-group text-white sidebar-list">
                <li class="list-group-item bg-dark"><a href="#">Welcome Admin</a></li>
                <li class="list-group-item bg-dark"><a href="manage_courses/manage_courses.php">Manage Courses</a></li>
                <li class="list-group-item bg-dark"><a href="#">Manage Quizzes</a></li>
                <li class="list-group-item bg-dark"><a href="#">Manage Videos</a></li>
                <li class="list-group-item bg-dark"><a href="#">Manage Comments</a></li>
                <li class="list-group-item bg-dark"><a href="#">Manage Users</a></li>
                <li class="list-group-item bg-dark"><a href="#">Logout</a></li>
                <li class="list-group-item bg-dark" style="height: 400px;"></li>
            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="col-md-10">
            <div class="mt-1">
                <h3 class="text-center">Update Topic</h3>
            </div>

            <?php  
            try {
                // PostgreSQL Connection
                $con = new PDO("pgsql:host=localhost;dbname=postgres", "postgres", "123");
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if (isset($_GET['course_id'])) {
                    $course_id = $_GET['course_id'];
                    
                    // Fetch course details
                    $query = "SELECT * FROM courses WHERE id = :course_id";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $course = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($course) {
                        ?>

                        <form method="POST" action="verify/verify_changes.php" class="ml-3">
                            <input type="hidden" name="cors_id" value="<?php echo htmlspecialchars($course['id']); ?>">
                            
                            <label>Enter course name:</label>
                            <input type="text" name="coursename" readonly class="form-control" value="<?php echo htmlspecialchars($course['course_name']); ?>"><br>

                            <label>Enter topic name:</label>
                            <input type="text" name="topic_name" class="form-control" value="<?php echo htmlspecialchars($course['topic_name']); ?>">

                            <label>Enter the content:</label>
                            <textarea id="editor" name="editor" class="ckeditor"><?php echo htmlspecialchars($course['description']); ?></textarea>

                            <button type="submit" name="submitupdate" class="btn btn-success mt-3">Submit</button>
                        </form>

                        <?php
                    } else {
                        echo "<p class='text-danger text-center'>Course not found.</p>";
                    }
                } else {
                    echo "<p class='text-danger text-center'>Invalid request.</p>";
                }
            } catch (PDOException $e) {
                echo "<p class='text-danger text-center'>Database Error: " . $e->getMessage() . "</p>";
            }
            ?>

        </div>
    </div>
</div>

<script src="../ckeditor/ckeditor.js"></script> <!-- CKEditor Script -->
</body>
</html>
