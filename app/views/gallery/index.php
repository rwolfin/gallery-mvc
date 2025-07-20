<?php
require_once '../config/config.php';
require_once '../engine/functions.php';

// Обработка действий
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        // Авторизация
        if ($_POST['action'] === 'login' && !empty($_POST['username'])) {
            $_SESSION['user'] = htmlspecialchars($_POST['username']);
        }
        
        // Выход
        if ($_POST['action'] === 'logout') {
            unset($_SESSION['user']);
        }
        
        // Загрузка изображения
        if ($_POST['action'] === 'upload' && isset($_FILES['image']) && isset($_SESSION['user'])) {
            upload_image($_FILES['image']);
        }
        
        // Удаление изображения
        if ($_POST['action'] === 'delete_image' && isset($_POST['image_id']) && isset($_SESSION['user'])) {
            delete_image($_POST['image_id']);
        }
        
        // Добавление комментария
        if ($_POST['action'] === 'add_comment' && isset($_POST['image_id'], $_POST['text']) && isset($_SESSION['user'])) {
            add_comment($_POST['image_id'], $_SESSION['user'], $_POST['text']);
        }
        
        // Удаление комментария
        if ($_POST['action'] === 'delete_comment' && isset($_POST['comment_id']) && isset($_SESSION['user'])) {
            delete_comment($_POST['comment_id']);
        }
    }
    header("Location: /public/");
    exit;
}

// Подключение шаблонов
require_once '../app/views/layout/header.php';
?>

<div class="container mt-5">
    <h1 class="mb-4">Галерея изображений</h1>
    
    <!-- Форма авторизации -->
    <?php if (!isset($_SESSION['user'])): ?>
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="action" value="login">
                    <div class="form-group">
                        <label for="username">Имя пользователя</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Войти</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="d-flex justify-content-between mb-4">
            <div>
                <span>Вы вошли как: <strong><?= $_SESSION['user'] ?></strong></span>
                <form method="POST" class="d-inline ml-2">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit" class="btn btn-sm btn-outline-secondary">Выйти</button>
                </form>
            </div>
            
            <!-- Форма загрузки -->
            <form method="POST" enctype="multipart/form-data" class="form-inline">
                <input type="hidden" name="action" value="upload">
                <div class="form-group mr-2">
                    <input type="file" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-success">Загрузить</button>
            </form>
        </div>
    <?php endif; ?>
    
    <!-- Галерея -->
    <div class="row">
        <?php foreach (get_all_images() as $image): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="img/<?= $image['filename'] ?>" class="card-img-top" alt="Image">
                    <div class="card-body">
                        <?php if (isset($_SESSION['user'])): ?>
                            <form method="POST" class="text-right mb-3">
                                <input type="hidden" name="action" value="delete_image">
                                <input type="hidden" name="image_id" value="<?= $image['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                            </form>
                        <?php endif; ?>
                        
                        <!-- Комментарии -->
                        <h5>Комментарии:</h5>
                        <?php foreach (get_comments($image['id']) as $comment): ?>
                            <div class="card mb-2">
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong><?= htmlspecialchars($comment['user_id']) ?></strong>
                                            <small class="text-muted ml-2"><?= $comment['created_at'] ?></small>
                                        </div>
                                        <?php if (isset($_SESSION['user']) && $_SESSION['user'] === $comment['user_id']): ?>
                                            <form method="POST">
                                                <input type="hidden" name="action" value="delete_comment">
                                                <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">&times;</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                    <p class="mb-0"><?= htmlspecialchars($comment['text']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <!-- Форма комментария -->
                        <?php if (isset($_SESSION['user'])): ?>
                            <form method="POST" class="mt-3">
                                <input type="hidden" name="action" value="add_comment">
                                <input type="hidden" name="image_id" value="<?= $image['id'] ?>">
                                <div class="form-group">
                                    <textarea name="text" class="form-control" placeholder="Ваш комментарий..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">Отправить</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>