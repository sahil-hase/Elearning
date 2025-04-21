<?php
session_start();

// Secure PostgreSQL Database Connection
$con = pg_connect("host=localhost dbname=postgres user=postgres password=123");
if (!$con) {
    die("Connection failed: " . pg_last_error());
}

// ==============================================================================
// ADD A NEW VIDEO COURSE
if (isset($_POST['btn_add_vid'])) {
    $coursename = $_POST['course_name'];
    $courseimg = $_FILES['course_image'];
    $coursedesc = $_POST['course_desc'];

    $filename = $courseimg['name'];
    $filetmp = $courseimg['tmp_name'];

    $fileext = pathinfo($filename, PATHINFO_EXTENSION);
    $allowed_exts = ['png', 'jpg', 'jpeg'];

    if (in_array(strtolower($fileext), $allowed_exts)) {
        $destinationfile = '../../uploadimg/' . $filename;
        move_uploaded_file($filetmp, $destinationfile);

        $query = "INSERT INTO video_info (image, description, course_name) VALUES ($1, $2, $3)";
        $result = pg_query_params($con, $query, [$destinationfile, $coursedesc, $coursename]);

        if ($result) {
            header("location:manage_videos.php?status=added");
        }
    }
}

// ==============================================================================
// UPDATE A VIDEO COURSE
if (isset($_POST['btn_update_vid'])) {
    $languagename = $_POST['selected-course-to-update'];
    $languageimg = $_FILES['course_image'];
    $languagedesc = $_POST['course_desc'];

    $filename = $languageimg['name'];
    $filetmp = $languageimg['tmp_name'];

    $fileext = pathinfo($filename, PATHINFO_EXTENSION);
    $allowed_exts = ['png', 'jpg', 'jpeg'];

    if (in_array(strtolower($fileext), $allowed_exts)) {
        $destinationfile = '../../uploadimg/' . $filename;
        move_uploaded_file($filetmp, $destinationfile);

        $query = "UPDATE video_info SET image = $1, description = $2 WHERE course_name = $3";
        $result = pg_query_params($con, $query, [$destinationfile, $languagedesc, $languagename]);

        if ($result) {
            header("location:manage_videos.php?status=updated");
        }
    }
}

// ==============================================================================
// DELETE A VIDEO COURSE
if (isset($_POST['btn-delete-vid'])) {
    $course_name = $_POST['selected_course'];
    $query = "DELETE FROM video_info WHERE course_name = $1";
    $result = pg_query_params($con, $query, [$course_name]);

    if ($result) {
        header("location:manage_videos.php?status=deleted");
    }
}

// ==============================================================================
// DELETE A PARTICULAR VIDEO
if (isset($_GET['id'])) { 
    $course_name = $_GET['course_name']; 
    $vid_id = $_GET['id'];
    
    $query = "DELETE FROM videos WHERE video_id = $1";
    $result = pg_query_params($con, $query, [$vid_id]);

    if ($result) {
        header("location:edit_videos.php?course_name=$course_name");
    }
}

// ==============================================================================
// ADD A NEW VIDEO
if (isset($_POST['btn_add_new_vid'])) {
    $coursename = $_POST['course_name'];
    $video_img = $_FILES['vid_img'];
    $video_title = $_POST['vid_title'];
    $video_path = $_POST['vid_path'];

    $filename = $video_img['name'];
    $filetmp = $video_img['tmp_name'];

    $fileext = pathinfo($filename, PATHINFO_EXTENSION);
    $allowed_exts = ['png', 'jpg', 'jpeg'];

    if (in_array(strtolower($fileext), $allowed_exts)) {
        $destinationfile = '../../uploadimg/' . $filename;
        move_uploaded_file($filetmp, $destinationfile);

        $query = "INSERT INTO videos (video_path, video_name, course_name, video_image) VALUES ($1, $2, $3, $4)";
        $result = pg_query_params($con, $query, [$video_path, $video_title, $coursename, $destinationfile]);

        if ($result) {
            header("location:edit_videos.php?course_name=$coursename&status=added");
        }
    }
}
?>
