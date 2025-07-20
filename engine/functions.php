<?php
require_once __DIR__ . '/../config/config.php';

function db_connect() {
    static $db;
    if ($db === null) {
        $db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        mysqli_set_charset($db, 'utf8');
    }
    return $db;
}


function upload_image($file) {
    if ($file['error'] !== UPLOAD_ERR_OK) return false;
    

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    if (!in_array($mime, ALLOWED_TYPES) || $file['size'] > MAX_FILE_SIZE) return false;


    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    $destination = UPLOAD_DIR . $filename;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $db = db_connect();
        $stmt = mysqli_prepare($db, "INSERT INTO images (filename) VALUES (?)");
        mysqli_stmt_bind_param($stmt, 's', $filename);
        mysqli_stmt_execute($stmt);
        return mysqli_insert_id($db);
    }
    return false;
}


function delete_image($image_id) {
    $db = db_connect();
    $image_id = (int)$image_id;


    $stmt = mysqli_prepare($db, "SELECT filename FROM images WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $image_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $filename);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($filename) {
       
        $filepath = UPLOAD_DIR . $filename;
        if (file_exists($filepath)) unlink($filepath);
        
   
        $stmt = mysqli_prepare($db, "DELETE FROM images WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $image_id);
        return mysqli_stmt_execute($stmt);
    }
    return false;
}


function add_comment($image_id, $author, $text) {
    $db = db_connect();
    $stmt = mysqli_prepare($db, "INSERT INTO comments (image_id, user_id, text) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'iss', $image_id, $author, $text);
    return mysqli_stmt_execute($stmt);
}


function delete_comment($comment_id) {
    $db = db_connect();
    $stmt = mysqli_prepare($db, "DELETE FROM comments WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $comment_id);
    return mysqli_stmt_execute($stmt);
}

function get_all_images() {
    $db = db_connect();
    $result = mysqli_query($db, "SELECT * FROM images ORDER BY id DESC");
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_comments($image_id) {
    $db = db_connect();
    $stmt = mysqli_prepare($db, "SELECT * FROM comments WHERE image_id = ? ORDER BY created_at DESC");
    mysqli_stmt_bind_param($stmt, 'i', $image_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}