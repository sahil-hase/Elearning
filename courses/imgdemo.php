<?php
session_start();

try {
    // PostgreSQL Connection
    $con = new PDO("pgsql:host=localhost;dbname=postgres", "postgres", "123");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle Add Course
    if (isset($_POST['btn-add-course'])) {
        $languagename = $_POST['languagename'];
        $languagedesc = $_POST['languagedesc'];
        $languageimg = $_FILES['languageimg'];

        $filename = $languageimg['name'];
        $fileerror = $languageimg['error'];
        $filetmp = $languageimg['tmp_name'];

        $fileext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed_ext = ['png', 'jpg', 'jpeg'];

        if (in_array($fileext, $allowed_ext)) {
            $destinationfile = 'uploadimg/' . basename($filename);
            move_uploaded_file($filetmp, $destinationfile);

            // Insert course using prepared statements
            $query = "INSERT INTO programming_languages (language_name, language_image, language_description) 
                      VALUES (:name, :image, :desc)";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':name', $languagename, PDO::PARAM_STR);
            $stmt->bindParam(':image', $destinationfile, PDO::PARAM_STR);
            $stmt->bindParam(':desc', $languagedesc, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                header("Location: admin_panel.php");
                exit();
            } else {
                echo "Error adding course.";
            }
        } else {
            echo "Invalid file type. Allowed: PNG, JPG, JPEG.";
        }
    }

    // Handle Delete Course
    if (isset($_POST['btn-delete-course'])) {
        $course_name = $_POST['txt_course_del_id'];

        $query = "DELETE FROM programming_languages WHERE language_name = :name";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':name', $course_name, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: admin_panel.php");
            exit();
        } else {
            echo "Error deleting course.";
        }
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
