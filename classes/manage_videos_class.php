<?php 

class manage_videos_class
{
    public $host = "localhost";
    public $username = "postgres";
    public $pass = "123";
    public $db_name = "postgres";
    public $conn;
    public $videos_list;

    public function __construct()
    {
        try {
            $this->conn = new PDO("pgsql:host=$this->host;dbname=$this->db_name", $this->username, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function display_videos()
    {
        $query = "SELECT * FROM video_info";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $this->videos_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->videos_list;
    }
}

?>
