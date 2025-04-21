<?php
session_start();

try {
    // PostgreSQL Connection
    $con = new PDO("pgsql:host=localhost;dbname=postgres", "postgres", "123");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ==========================================================================================
    // ADD A NEW COURSE
    if (isset($_POST['btn_add'])) {
        $languagename = $_POST['course_name'];
        $languageimg = $_FILES['course_image'];
        $languagedesc = $_POST['course_desc'];

        $filename = $languageimg['name'];
        $filetmp = $languageimg['tmp_name'];
        $fileext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = ['png', 'jpg', 'jpeg'];

        if (in_array($fileext, $allowed)) {
            $destinationfile = 'uploadimg/' . $filename;
            move_uploaded_file($filetmp, '../../' . $destinationfile);

            $query = "INSERT INTO programming_languages (language_name, language_image, language_description) 
                      VALUES (:languagename, :destinationfile, :languagedesc)";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':languagename', $languagename);
            $stmt->bindParam(':destinationfile', $destinationfile);
            $stmt->bindParam(':languagedesc', $languagedesc);

            if ($stmt->execute()) {
                header("location:manage_courses.php?status=added");
                exit();
            }
        }
    }

    // ==========================================================================================
    // DELETE A COURSE
    if (isset($_POST['btn-delete-course'])) {
        $course_name = $_POST['selected_course'];
        $query = "DELETE FROM programming_languages WHERE language_name = :course_name";
        $stmt = $con->prepare($query);
		header("location:manage_courses.php?status=deleted");
        $stmt->bindParam(':course_name', $course_name);

        if ($stmt->execute()) {
            exit();
        }
    }

    // ==========================================================================================
    // UPDATE A COURSE
    if (isset($_POST['btn_update'])) {
        $languagename = $_POST['selected-course-to-update'];
        $languageimg = $_FILES['course_image'];
        $languagedesc = $_POST['course_desc'];

        $filename = $languageimg['name'];
        $filetmp = $languageimg['tmp_name'];
        $fileext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = ['png', 'jpg', 'jpeg'];

        if (in_array($fileext, $allowed)) {
            $destinationfile = 'uploadimg/' . $filename;
            move_uploaded_file($filetmp, '../../' . $destinationfile);

            $query = "UPDATE programming_languages 
                      SET language_image = :destinationfile, language_description = :languagedesc 
                      WHERE language_name = :languagename";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':destinationfile', $destinationfile);
            $stmt->bindParam(':languagedesc', $languagedesc);
            $stmt->bindParam(':languagename', $languagename);

            if ($stmt->execute()) {
                header("location:manage_courses.php?status=updated");
                exit();
            }
        }
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
