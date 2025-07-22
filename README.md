# 🖼️ MVC Галерея изображений

Проект — веб-приложение "Галерея изображений", построенное на архитектуре MVC (Model-View-Controller) с использованием PHP и MySQL. Позволяет пользователям загружать изображения, оставлять комментарии и просматривать галерею других пользователей.

## 🔁 Альтернатива (Процедурный стиль)

Если вы хотите посмотреть на ту же самую галерею, но написанную в **процедурном стиле без ООП**, вы можете найти этот проект здесь: [github.com/rwolfin/gallery-app](https://github.com/rwolfin/gallery-app)

## 🚀 Функционал

✅ Авторизация пользователей  
✅ Загрузка изображений (для авторизованных пользователей)  
✅ Просмотр галереи (для всех)  
✅ Добавление комментариев (для авторизованных)  
✅ Удаление своих комментариев  
✅ Удаление изображений (с каскадным удалением комментариев)  

## 📂 Структура проекта

```

📁 gallery-app/
├── 📁 app/
│   ├── 📁 controllers/
│   │   ├── 📄 AuthController.php
│   │   ├── 📄 GalleryController.php
│   │   └── 📄 ImageController.php
│   ├── 📁 Models/
│   │   ├── 📄 Comment.php
│   │   ├── 📄 Database.php
│   │   └── 📄 Image.php
│   └── 📁 views/
│       ├── 📁 gallery/
│       │   └── 📄 index.php
│       └── 📁 layout/
│           ├── 📄 footer.php
│           └── 📄 header.php
├── 📁 config/
│   └── 📄 config.php
├── 📁 engine/
│   ├── 📄 functions.php
│   └── 📄 Router.php
├── 📁 public/
│   ├── 📁 img/
│   └── 📄 index.php
├── 📄 composer.json
├── 📄 composer.lock
├── ⚙️ .htaccess
└── 📄 index.php

```


## ⚙️ Установка

1. **Склонируйте репозиторий или распакуйте архив:**

   ```bash
   git clone https://github.com/rwolfin/gallery-mvc.git
   ```

2. **Создайте базу данных и выполните SQL-запросы:**

   ```sql
   CREATE DATABASE gallery_db;
   USE gallery_db;

   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) UNIQUE NOT NULL,
       password VARCHAR(255) NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

   CREATE TABLE images (
       id INT AUTO_INCREMENT PRIMARY KEY,
       user_id VARCHAR(255) NOT NULL,
       filename VARCHAR(255) NOT NULL,
       original_name VARCHAR(255) NOT NULL,
       uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
   );

   CREATE TABLE comments (
       id INT AUTO_INCREMENT PRIMARY KEY,
       image_id INT NOT NULL,
       user_id VARCHAR(255) NOT NULL,
       text TEXT NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       FOREIGN KEY (image_id) REFERENCES images(id) ON DELETE CASCADE,
       FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
   );
   ```

3. **Настройте подключение к базе данных:**

   В файле `config/config.php` укажите ваши параметры подключения:

   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'gallery_db');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

4. **Запустите локальный сервер:**

   ```bash
   php -S localhost:8000 -t public
   ```

   И откройте в браузере: [http://localhost:8000](http://localhost:8000)

## 📦 Стек технологий

- PHP 8.x
- MySQL / MariaDB
- MVC (собственная реализация)
- HTML/CSS/JavaScript
- (по необходимости) Composer

## 📝 Лицензия

MIT License. Используйте свободно и улучшайте под свои нужды.

---

> Разработано с ❤️ для учебных и демонстрационных целей в школе Skillfactory