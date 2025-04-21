<?php
session_start();  // Start session to use session variables

// Secure PostgreSQL Database Connection
$con = pg_connect("host=localhost dbname=postgres user=postgres password=123");
if (!$con) {
    die("Connection failed: " . pg_last_error());
}

// Sanitize GET parameter
$course_name = isset($_GET['course_name']) ? htmlspecialchars($_GET['course_name'], ENT_QUOTES, 'UTF-8') : '';

?>


<!DOCTYPE html>
<html>
<head>
    <title>Manage Course Videos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>  <!-- Fixed jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Google Fonts & Font Awesome -->
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

<div class="container-fluid mt-5">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-2 sidebar badge-dark">
            <ul class="list-group text-white sidebar-list">
                <li class="list-group-item bg-dark"><a href="../admin_main.php">Welcome Admin</a></li>
                <li class="list-group-item bg-dark"><a href="manage_courses/manage_courses.php">Manage Courses</a></li>
                <li class="list-group-item bg-dark"><a href="">Manage Quiz</a></li>
                <li class="list-group-item bg-dark" style="height: 400px;"></li>
            </ul>
        </div>

     <!-- Main Content -->
<div class="col-md-10">
    <h3 class="text-center mt-2">Manage Your <?php echo $course_name; ?> Online Video Tutorial</h3>
    <button class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">Add New Video</button><br>

    <div class="row col-md-12 ml-2 shadow">

        <?php
        // Use prepared statements in PostgreSQL
        $query = "SELECT * FROM videos WHERE course_name = $1";
        $result = pg_query_params($con, $query, array($course_name));

        while ($row = pg_fetch_assoc($result)) { ?>
            <div class="col-md-4 p-3">
                <div class="card shadow mycard" style="width: 18rem; height: 7rem;">
                    <div class="inner">
                        <img class="card-img-top" style="height: 11rem;" src="<?php echo htmlspecialchars($row['video_image']); ?>" alt="Video Thumbnail">
                    </div>

                    <div class="card-body shadow" style="background-color: #f1f1f1;">
                        <p class="card-text"><?php echo htmlspecialchars($row['video_name']); ?></p>

                        <span class="text-danger" style="font-size: 14px;">
                            <a href="watch_video.php?video_id=<?php echo $row['video_id']; ?>&course_name=<?php echo $row['course_name']; ?>" class="text-success p-1">Watch <i class="fa fa-eye"></i></a>
                            <a href="" class="p-1 text-primary">Update <i class="fa fa-pencil ml-1"></i></a>
                            <a href="video_add.php?id=<?php echo $row['video_id']; ?>&course_name=<?php echo $row['course_name']; ?>&run=delete" class="p-1 text-danger">Delete <i class="fa fa-trash-o ml-1"></i></a>
                        </span>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Add Video Modal -->
    <div class="col-md-4 mt-5">
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add Video</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Form -->
                    <form action="video_add.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" name="course_name" value="<?php echo $course_name; ?>">

                            <div class="form-group">
                                <label>Enter Video Title:</label>
                                <input type="text" name="vid_title" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Upload Video Image:</label>
                                <input type="file" name="vid_img" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Enter Video Path:</label>
                                <input type="text" name="vid_path" class="form-control" required>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" name="btn_add_new_vid">Add Video</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div> <!-- Main Content End -->
</div>
</div>

</body>
</html>
