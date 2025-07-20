<?php
class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['username'])) {
            $_SESSION['user'] = htmlspecialchars($_POST['username']);
            header("Location: /");
            exit;
        }
    }

    public function logout() {
        unset($_SESSION['user']);
        header("Location: /");
        exit;
    }
}