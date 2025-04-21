<!DOCTYPE html>
<html>
<head>
    <title>Manage Courses</title>

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
                <li class="list-group-item bg-dark"><a href="../admin_main.php">Welcome Admin</a></li>
                <li class="list-group-item bg-dark"><a href="manage_courses.php">Manage Courses</a></li>
                <li class="list-group-item bg-dark"><a href="#">Manage Quizzes</a></li>
                <li class="list-group-item bg-dark"><a href="#">Manage Videos</a></li>
                <li class="list-group-item bg-dark" style="height: 400px;"></li>
            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="col-md-10">
            <div class="col-lg-12">
                <h3 class="text-center mt-2">Manage Your Course</h3><br>

                <table class="table table-striped table-hover shadow">
                    <tr class="font-weight-bold">
                        <th>ID</th>
                        <th>Topic Name</th>
                        <th>Description</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>

                    <?php
                    try {
                        // PostgreSQL Connection
                        $con = new PDO("pgsql:host=localhost;dbname=postgres", "postgres", "123");
                        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        if (isset($_GET['course_name'])) {
                            $coursename = $_GET['course_name'];
                            $query = "SELECT * FROM courses WHERE course_name = :coursename";
                            $stmt = $con->prepare($query);
                            $stmt->bindParam(':coursename', $coursename);
                            $stmt->execute();
                            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($courses as $course) {
                                echo "<tr>";
                                echo "<td>{$course['id']}</td>";
                                echo "<td>{$course['topic_name']}</td>";
                                echo "<td><textarea rows='3' cols='50'>" . html_entity_decode($course['description'], ENT_QUOTES) . "</textarea></td>";
                                echo "<td><a href='update_topic.php?course_id={$course['id']}' class='text-primary'>Update <i class='fa fa-pencil-square ml-2'></i></a></td>";
                                echo "<td><a href='verify/verify_delete.php?course_id={$course['id']}&course_name={$course['course_name']}' class='text-danger'>Delete <i class='fa fa-trash-o ml-2'></i></a></td>";
                                echo "</tr>";
                            }

                            echo '<button class="btn btn-primary" id="btn-add">
                                    <a href="add_new_topic.php?course_name=' . $coursename . '" class="text-white">Add a new topic</a>
                                  </button>';
                        } else {
                            echo "<tr><td colspan='5' class='text-center text-danger'>No course selected</td></tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='5' class='text-danger text-center'>Database Error: " . $e->getMessage() . "</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>
