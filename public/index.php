<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../engine/Router.php';
require_once __DIR__ . '/../app/models/Comment.php';
require_once __DIR__ . '/../app/models/Database.php';
require_once __DIR__ . '/../app/models/Image.php';

session_start();

$router = new Router();
$router->route();