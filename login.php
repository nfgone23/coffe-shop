<?php
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $users = json_decode(file_get_contents('data/users.json'), true);
    
    $success = false;
    
    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            $success = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
            
            $log = date('Y-m-d H:i:s') . " | " . $_SERVER['REMOTE_ADDR'] . " | " . $email . " | SUCCESS_LOGIN" . PHP_EOL;
            file_put_contents('logs/auth.log', $log, FILE_APPEND);
            
            header('Location: dashboard.php');
            exit;
        }
    }
    
    if (!$success) {
        $error = 'Неверный email или пароль';
        $log = date('Y-m-d H:i:s') . " | " . $_SERVER['REMOTE_ADDR'] . " | " . $email . " | FAIL_LOGIN" . PHP_EOL;
        file_put_contents('logs/auth.log', $log, FILE_APPEND);
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход в кофейную лавку</title>
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
<h1>Авторизация</h1>
<?php if ($error): ?>
    <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
<?php endif; ?>
<form method="post">
    <p><input type="email" name="email" placeholder="Email" required style="width: 250px; padding: 8px;"></p>
    <p><input type="password" name="password" placeholder="Пароль" required style="width: 250px; padding: 8px;"></p>
    <p><button type="submit" class="add-btn" style="width: auto; padding: 8px 25px;">Войти</button></p>
</form>
<p><strong>Тестовые данные:</strong></p>
<p>admin@test.com / password</p>
<p>user@test.com / 123456</p>
<footer>
    <p>&copy; 2025 Кофейная лавка</p>
</footer>
</body>
</html>