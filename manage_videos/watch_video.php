<?php
// Secure PostgreSQL Database Connection
$con = pg_connect("host=localhost dbname=postgres user=postgres password=123");

if (!$con) {
    die("Connection failed: " . pg_last_error());
}

require 'comments.inc.php'; // Including the comment handling code
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Videos</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Quicksand|Open+Sans|Lato" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

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
  
<?php require("../includes/navbar.php"); ?>  <!-- Navigation bar included -->

<div class="container-fluid mt-5">
  <div class="row">

    <!-- Sidebar -->
    <div class="col-sm-2 col-md-2 sidebar badge-dark">
      <ul class="list-group text-white sidebar-list">
        <li class="list-group-item bg-dark"><a href="#">Welcome Admin</a></li>
        <li class="list-group-item bg-dark"><a href="manage_courses/manage_courses.php">Manage Courses</a></li>
        <li class="list-group-item bg-dark"><a href="#">Manage Quizzes</a></li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="col-md-10">
      <h3 class="text-center mt-2">Manage Your <?php echo htmlspecialchars($_GET['course_name']); ?> Online Video Tutorial</h3><br>

      <div class="row ml-2">
        <section class="col-md-7 mt-4">
          <iframe style="border:1px #999 solid;" width="760" height="415" 
          <?php  
            $_SESSION['vid'] = $_GET['video_id'];
            $video_id = $_GET['video_id'];
            $sql = "SELECT * FROM videos WHERE video_id = $1";
            $result = pg_query_params($con, $sql, array($video_id));

            while ($row = pg_fetch_assoc($result)) {
          ?>
          src="<?php echo htmlspecialchars($row['video_path']); ?>"
          <?php } ?>
          frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

          <!-- Comments Section -->
          <br><br>
          <div class="commentdiv shadow bg-light" style="border:1px #d2c8c8 solid;">
            <?php  
              $video_id = $_GET['video_id']; 
              echo "
                <form method='POST' action='".setComments($con)."'>
                  <input type='hidden' name='uid' value='Anonymous'>
                  <input type='hidden' name='vid' value='".$video_id."'>
                  <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
                  <textarea name='message'></textarea><br>
                  <button type='submit' name='commentSubmit' class='commentbtn'>Comment</button>
                </form><br><br>
              ";      
            ?>
          </div>

          <?php getComments($con); ?>
        </section> 
      </div>
    </div>
  </div>
</div>

</body>
</html>
