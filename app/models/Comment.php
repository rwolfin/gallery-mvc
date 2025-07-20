<?php
class Comment {
    private $db;

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    public function add($image_id, $author, $text) {
        // ... логика добавления комментария ...
    }

    public function delete($comment_id) {
        // ... логика удаления комментария ...
    }

    public function getForImage($image_id) {
        // ... логика получения комментариев ...
    }
}