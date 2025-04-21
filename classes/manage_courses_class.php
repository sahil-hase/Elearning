<?php 

class manage_courses_class
{
    public $host = "localhost";
    public $username = "postgres";
    public $pass = "123";
    public $db_name = "postgres";
    public $conn;
    public $course_list;

    public function __construct()
    {
        try {
            $this->conn = new PDO("pgsql:host=$this->host;dbname=$this->db_name", $this->username, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function display_courses()
    {
        $query = "SELECT * FROM programming_languages";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $this->course_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->course_list;
    }
}

?>
