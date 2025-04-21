<?php 

class manage_quiz_class
{
    public $host = "localhost";
    public $username = "postgres";
    public $pass = "123";
    public $db_name = "postgres";
    public $conn;
    public $quiz_course_list;

    public function __construct()
    {
        try {
            $this->conn = new PDO("pgsql:host=$this->host;dbname=$this->db_name", $this->username, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function display_quiz_courses()
    {
        $query = "SELECT * FROM category";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $this->quiz_course_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->quiz_course_list;
    }

    public function add_quiz($query_string)
    {
        try {
            $stmt = $this->conn->prepare($query_string);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            die("Error adding quiz: " . $e->getMessage());
        }
    }
}

?>
