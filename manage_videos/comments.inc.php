<?php 
session_start();

// PostgreSQL Connection
try {
    $con = new PDO("pgsql:host=localhost;dbname=postgres", "postgres", "123");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$GLOBALS['username'] = "admin";

// ================================================================================================================
// **ADD COMMENT**
function setComments($con) {
    if (isset($_POST['commentSubmit'])) {
        $video_id = $_POST['vid'];
        $uid = "admin";  // Static for now, can be changed to dynamic user
        $date = $_POST['date'];
        $message = $_POST['message'];

        // Insert Query
        $query = "INSERT INTO commentsection (uid, date, message, video_id) VALUES (:uid, :date, :message, :video_id)";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':uid', $uid, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        $stmt->bindParam(':video_id', $video_id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

// ================================================================================================================
// **DISPLAY COMMENTS**
function getComments($con) {
    if (!isset($_SESSION['vid'])) {
        return;
    }
    $video_id = $_SESSION['vid'];

    // Fetch Comments Query
    $query = "SELECT * FROM commentsection WHERE video_id = :video_id ORDER BY date DESC";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':video_id', $video_id, PDO::PARAM_INT);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($comments as $row) {
        echo "<div class='comment-box shadow bg-light'><p>";
        echo "<b>" . htmlspecialchars($row['uid']) . "</b>&nbsp;&nbsp;&nbsp;";
        echo htmlspecialchars($row['date']) . "<br><br>";
        echo nl2br(htmlspecialchars($row['message']));
        echo "</p>";

        // Delete Comment Button
        echo "<form class='delete-form' method='POST' action=''>
            <input type='hidden' name='cid' value='" . $row['cid'] . "'>
            <button type='submit' name='CommentDelete' class='btndelete'>Delete</button> 
        </form>";

        $_SESSION['id'] = $row['cid'];

        // Edit Comment Button
        echo "
        <input type='hidden' name='cid' value='" . $row['cid'] . "'>
        <button type='button' class='btnEdit' data-toggle='modal' data-target='#editModal" . $row['cid'] . "'>Edit</button>";

        // Edit Modal
        echo '
        <div id="editModal' . $row['cid'] . '" class="modal fade col-md-6 m-auto" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Edit Comment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button><br>
              </div>
              <div class="modal-body">
                <form action="" method="POST">
                  <div class="form-group">
                    <input type="hidden" name="cid" value="' . $row['cid'] . '">
                    <label for="message-text" class="col-form-label">Message:</label>
                    <textarea class="form-control" name="message">' . htmlspecialchars($row['message']) . '</textarea>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="commentEdit">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
                </form>
            </div>
          </div>
        </div>';
        
        echo "</div>";
    }
}

// ================================================================================================================
// **DELETE COMMENT**
if (isset($_POST['CommentDelete'])) {
    $cid = $_POST['cid'];

    // Delete Query
    $query = "DELETE FROM commentsection WHERE cid = :cid";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':cid', $cid, PDO::PARAM_INT);
    $stmt->execute();
    
    header("Location: java_videos.php");
    exit();
}

// ================================================================================================================
// **EDIT COMMENT**
if (isset($_POST['commentEdit'])) {
    $cid = $_POST['cid'];
    $message = $_POST['message'];

    // Update Query
    $query = "UPDATE commentsection SET message = :message WHERE cid = :cid";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $stmt->bindParam(':cid', $cid, PDO::PARAM_INT);
    $stmt->execute();
    
    header("Location: java_videos.php");
    exit();
}
?>
