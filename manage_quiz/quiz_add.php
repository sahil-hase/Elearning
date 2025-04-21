<?php 

include '../classes/manage_quiz_class.php';

// PostgreSQL Connection
try {
    $con = new PDO("pgsql:host=localhost;dbname=postgres", "postgres", "123");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// ================================================================================================================
// **ADD QUIZ CATEGORY**
if (isset($_POST['btn_add_quiz_sub'])) {
    if (!empty($_POST['course_name'])) {
        $course_name = $_POST['course_name'];

        // Insert Query
        $query = "INSERT INTO category (course_name) VALUES (:course_name)";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':course_name', $course_name, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location:manage_quiz.php");
            exit();
        }
    }
}

// ================================================================================================================
// **DELETE QUIZ CATEGORY**
if (isset($_POST['btn_delete_quiz_sub'])) {
    if (!empty($_POST['selected_course'])) {
        $selected_course = $_POST['selected_course'];

        // Delete Query
        $query = "DELETE FROM category WHERE id = :selected_course";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':selected_course', $selected_course, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location:manage_quiz.php");
            exit();
        }
    }
}

// ================================================================================================================
// **ADD A NEW QUESTION**
extract($_POST);

if (!empty($question) && !empty($opt1) && !empty($opt2) && !empty($opt3) && !empty($opt4) && !empty($answer) && !empty($cat)) {
    $quiz = new manage_quiz_class;

    $ques = htmlentities($question);
    $option1 = htmlentities($opt1);
    $option2 = htmlentities($opt2);
    $option3 = htmlentities($opt3);
    $option4 = htmlentities($opt4);
    $cat = htmlentities($cat);

    $optionsArray = [$option1, $option2, $option3, $option4];
    $matchedAnswer = array_search($answer, $optionsArray);

    // Insert Query
    $query = "INSERT INTO question_test (question, opt1, opt2, opt3, opt4, answer, category) 
              VALUES (:question, :opt1, :opt2, :opt3, :opt4, :answer, :category)";
    
    $stmt = $con->prepare($query);
    $stmt->bindParam(':question', $ques, PDO::PARAM_STR);
    $stmt->bindParam(':opt1', $option1, PDO::PARAM_STR);
    $stmt->bindParam(':opt2', $option2, PDO::PARAM_STR);
    $stmt->bindParam(':opt3', $option3, PDO::PARAM_STR);
    $stmt->bindParam(':opt4', $option4, PDO::PARAM_STR);
    $stmt->bindParam(':answer', $matchedAnswer, PDO::PARAM_INT);
    $stmt->bindParam(':category', $cat, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: manage_quiz.php?run=success");
        exit();
    }
}

?>
