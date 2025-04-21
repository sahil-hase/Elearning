<?php
session_start();

// PostgreSQL Database Connection
$host = "localhost";
$dbname = "postgres";  // Updated to 'postgres'
$user = "postgres";    // Updated to 'postgres'
$password = "123";     // Updated to '123'

try {
    $con = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    die("Database connection failed: " . $e->getMessage());
}
// Get course name from URL parameter
if (isset($_GET['course_name'])) {
    $course_name = $_GET['course_name'];

    // Use a prepared statement to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM courses WHERE course_name = :course_name");
    $stmt->execute([':course_name' => $course_name]);
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    die("Invalid request!");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>E-learning</title>
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../../css/java_programming.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lobster|Rubik|Assistant" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <script src="https://apis.google.com/js/platform.js"></script>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-inverse navbar-fixed-top" style="height: 80px;">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navi">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <h1 style="color: white;margin-top: 10px;" id="myhead">E-learning</h1>
        </div>
        <div class="collapse navbar-collapse" id="navi">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../../index.php">Home</a></li>
                <li><a href="#" id="our-location" class="btn-success"><?php echo $_SESSION['username']; ?></a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidemenu" id="sidebarleftmenu">
    <ul class="sidemenulist">
        <li><a href="#" class="crossbutton" onclick="closesidemenu()">&times;</a></li>
        <li style="background-color: orangered;"><a href="#">Home</a></li>

        <?php foreach ($courses as $course) { ?>
            <form action="fetch_main_content.php" method="POST">
                <input type="hidden" name="txt1" value="<?php echo $course['id']; ?>">
                <button style="background-color: transparent; border: none; text-align:left; color: white;">
                    <li style="width: 300px;"><?php echo $course['topic_name']; ?></li>
                </button>
            </form>
        <?php } ?>

    </ul>
</div>

<!-- Main Content -->
<div id="mainpagecontent" class="shadow">
    <div class="content">
        <p>
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
            }
            ?>
        </p>
    </div>
    <button id="btn_next"></button>
</div>

<!-- YouTube Subscribe Button -->
<div id="yt" class="g-ytsubscribe" data-channelid="UCxwf74gbHaiHHJ7XxZ51JyA" data-layout="full" data-count="default"></div>

<script type="text/javascript">
    function opensidemenu() {
        document.getElementById('sidebarleftmenu').style.width = '250px';
        document.getElementById('mainpagecontent').style.marginLeft = '250px';
    }

    function closesidemenu() {
        document.getElementById('sidebarleftmenu').style.width = '0';
        document.getElementById('mainpagecontent').style.marginLeft = '0px';
    }
</script>

</body>
</html>
