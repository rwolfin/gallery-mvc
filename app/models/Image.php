<?php
class Image {
    private $db;

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    public function upload($file) {
        // ... логика загрузки из старого functions.php ...
    }

    public function delete($image_id) {
        // ... логика удаления из старого functions.php ...
    }

    public function getAllImages() {
        $result = mysqli_query($this->db, "SELECT * FROM images ORDER BY id DESC");
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}