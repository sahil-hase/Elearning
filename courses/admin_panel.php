<?php 
include "../includes/navbar.php";
session_start();

try {
    // PostgreSQL Connection
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

    body {
        background: linear-gradient(to right, #49a09d, #5f2c82);
    }

    #btn-add-new-course {
        position: relative;
    }
</style>

<body>

    <!-- Sidebar -->
    <div class="sidemenu" id="sidebarleftmenu" style="margin-top: -20px; width: 250px;">
        <ul class="sidemenulist">
            <li style="background-color: orangered;"><a href="#">Welcome Admin</a></li>
            <li><a href="http://localhost/MyResponsiveWebsiteDemo/admin/admin_panel.php">Courses</a></li>
            <li><a href="#" data-toggle="modal" data-target="#myModal">Add New Course</a></li>
            <li><a href="#" data-toggle="modal" data-target="#myModaldelete">Delete Course</a></li>
        </ul>
    </div>

    <!-- Add New Course Modal -->
    <div class="container">
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Course</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" action="imgdemo.php">
                            <div class="form-group">
                                <div class="row form-inline">
                                    <label>Language Name:</label>
                                    <input type="text" name="languagename" class="form-control" required>
                                </div>
                                <div class="row">
                                    <label>Language Description:</label>
                                    <input type="text" name="languagedesc" class="form-control" required>
                                </div>
                                <div class="row">
                                    <label>Language Image:</label>
                                    <input type="file" name="languageimg" class="form-control" required>
                                </div>
                                <button id="btn-login" name="btn-add-course" type="submit" class="btn btn-primary">Add Course</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Course Modal -->
    <div class="modal fade" id="myModaldelete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Course</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="imgdemo.php">
                        <label>Enter Course Name:</label>
                        <input type="text" name="txt_course_del_id" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" name="btn-delete-course">Delete</button>
                </div>
                    </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="container col-md-9 bg-primary mt-20 form-row">
        <br><br><br><br>

        <?php
        // Fetch courses from PostgreSQL
        $query = "SELECT * FROM programming_languages";
        $stmt = $con->prepare($query);
        $stmt->execute();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($courses as $res) {
        ?>
            <div class="col-md-4 content-border" style="margin-bottom: 10px;">
                <div class="latest-news-wrap">
                    <div class="news-img">
                        <img src="../../<?php echo htmlspecialchars($res['language_image']); ?>" class="img-responsive img-fluid">
                        <div class="deat">
                            <span><?php echo htmlspecialchars($res['language_name']); ?></span>
                        </div>
                    </div>
                    <div class="news-content">
                        <p><?php echo htmlspecialchars($res['language_description']); ?></p><br>
                        <a href="admin_edit_courses.php?course_name=<?php echo urlencode($res['language_name']); ?>">Start Reading</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
