<?php 

class admin
{
    public $host = "localhost";
    public $username = "postgres";
    public $pass = "123";
    public $db_name = "postgres";
    public $conn;
    public $user_details;
    public $course_count = 0;
    public $video_count = 0;
    public $faq_list;

    public function __construct()
    {
        try {
            $this->conn = new PDO("pgsql:host=$this->host;dbname=$this->db_name", $this->username, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // ===================================================================================
    public function show_users() // Function to display users list on admin main page
    {
        $query = "SELECT * FROM login";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $this->user_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->user_details;
    }

    // =================================================================================================================
    public function display_course_count() // Function to display number of courses available in the database
    {
        $query = "SELECT COUNT(*) as count FROM programming_languages";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->course_count = $result['count'];
        print_r($this->course_count);
    }

    // =================================================================================================================
    public function display_video_count()
    {
        $query = "SELECT COUNT(*) as count FROM video_info";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->video_count = $result['count'];
        print_r($this->video_count);
    }

    // =================================================================================================================
    public function display_faq_list()
    {
        $query = "SELECT * FROM faq";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $this->faq_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->faq_list;
    }
}

?>
