<?php
require_once 'check_auth.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="index.html">☕ Главная</a></li>
        <li><a href="catalog.html">☕ Каталог</a></li>
        <li><a href="login.php">☕ Вход</a></li>
        <li><a href="dashboard.php">☕ Кабинет</a></li>
    </ul>
</nav>
<hr>
<h1>Личный кабинет</h1>
<p>Добро пожаловать, <strong><?php echo $_SESSION['user_name']; ?></strong>!</p>
<p>Ваш email: <?php echo $_SESSION['user_email']; ?></p>
<hr>
<p><a href="logout.php">Выйти из системы</a></p>
<footer>
    <p>&copy; 2025 Кофейная лавка</p>
</footer>
</body>
</html>