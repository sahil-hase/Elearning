<?php 
include "../includes/navbar.php";
session_start();

try {
    // Connect to PostgreSQL using PDO
    $con = new PDO("pgsql:host=localhost;dbname=postgres", "postgres", "123");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>
<link rel="stylesheet" type="text/css" href="../../css/java_programming.css">
<link rel="stylesheet" type="text/css" href="../../css/programming.css">

<style type="text/css">
    #main-content {
        margin-right: 0px;
        margin-top: 60px;
        margin-left: 300px;
        padding: 10px;
        background: linear-gradient(to right, #49a09d, #5f2c82);
    }

    body, textarea {
        background: linear-gradient(to right, #49a09d, #5f2c82);
    }

    #btn-add {
        position: absolute;
        top: 10px;
        left: 800px;
    }

    #sidebarleftmenu {
        background: linear-gradient(to right, #4A569D, #DC2424);
    }
</style>

<body>
    <div class="sidemenu" id="sidebarleftmenu" style="margin-top: -20px; width: 250px;">
        <ul class="sidemenulist">
            <li style="background-color: orangered;"><a href="">Welcome Admin</a></li>
            <li><a href="http://localhost/MyResponsiveWebsiteDemo/admin/courses/admin_panel.php">Courses</a></li>
            <li><a href="">Add Course</a></li>
            <li><a href="">Update Course</a></li>
        </ul>
    </div>

    <div id="main-content" class="container col-md-9 bg-primary mt-20 form-row" style="margin-top: 100px;">
        <div class="col-lg-12">
            <h1 class="text-center text-white">Manage Your Course</h1><br>
            <table class="table table-striped table-hover">
                <tr class="text-white font-weight-bold">
                    <th>ID</th>
                    <th>Topic Name</th>
                    <th>Description</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>

                <?php
                if (isset($_GET['course_name'])) {
                    $coursename = $_GET['course_name'];

                    // Fetch courses from PostgreSQL
                    $query = "SELECT * FROM courses WHERE course_name = :coursename";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':coursename', $coursename, PDO::PARAM_STR);
                    $stmt->execute();
                    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($courses as $res) {
                        echo "<tr class='text-white'>";
                        echo "<td>" . htmlspecialchars($res['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($res['topic_name']) . "</td>";
                        echo "<td><textarea rows='3' cols='50' class='text-white'>" . htmlspecialchars($res['description']) . "</textarea></td>";
                        echo "<td><a class='text-white no-gutters' href='update_course.php?course_id=" . $res['id'] . "'>Update</a></td>";
                        echo "<td><a class='text-white no-gutters' href='delete_topic.php?course_id=" . $res['id'] . "&course_name=" . urlencode($res['course_name']) . "'>Delete</a></td>";
                        echo "</tr>";
                    }
                }
                ?>

            </table>
            <button class="btn btn-primary" id="btn-add">
                <a href="add_new_topic.php?" class="text-white">Add a new topic</a>
            </button>
        </div>
    </div>
</body>
