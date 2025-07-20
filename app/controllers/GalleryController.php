<?php
class GalleryController {
    protected $imageModel;
    protected $commentModel;

    public function __construct() {
        $this->imageModel = new Image();
        $this->commentModel = new Comment();
    }

    public function index() {
        $images = $this->imageModel->getAllImages();
        require_once '../app/views/gallery/index.php';
    }
}