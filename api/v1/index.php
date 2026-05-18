<?php
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';
$input = json_decode(file_get_contents('php://input'), true);

function getUsersFile() {
    return __DIR__ . '/../../data/users.json';
}

function getAllUsers() {
    $file = getUsersFile();
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true);
}

function saveUsers($users) {
    file_put_contents(getUsersFile(), json_encode($users, JSON_PRETTY_PRINT));
}

// РЕГИСТРАЦИЯ
if ($path === '/register' && $method === 'POST') {
    $name = $input['name'] ?? '';
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';
    
    if (!$name || !$email || !$password) {
        echo json_encode(['status' => 'error', 'message' => 'Заполните все поля']);
        exit;
    }
    
    $users = getAllUsers();
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            echo json_encode(['status' => 'error', 'message' => 'Email уже существует']);
            exit;
        }
    }
    
    $newId = count($users) + 1;
    $users[] = [
        'id' => $newId,
        'name' => $name,
        'email' => $email,
        'password' => $password
    ];
    saveUsers($users);
    
    echo json_encode(['status' => 'success', 'message' => 'Регистрация успешна', 'id' => $newId]);
    exit;
}

// АВТОРИЗАЦИЯ
if ($path === '/login' && $method === 'POST') {
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';
    
    $users = getAllUsers();
    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            echo json_encode(['status' => 'success', 'message' => 'Вход выполнен', 'user_id' => $user['id']]);
            exit;
        }
    }
    
    echo json_encode(['status' => 'error', 'message' => 'Неверный email или пароль']);
    exit;
}

// СПИСОК ПОЛЬЗОВАТЕЛЕЙ
if ($path === '/users' && $method === 'GET') {
    $users = getAllUsers();
    $result = [];
    foreach ($users as $user) {
        $result[] = ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email']];
    }
    echo json_encode($result);
    exit;
}

// ПОЛУЧИТЬ ОДНОГО ПОЛЬЗОВАТЕЛЯ
if (preg_match('#/users/(\d+)#', $path, $matches) && $method === 'GET') {
    $id = (int)$matches[1];
    $users = getAllUsers();
    foreach ($users as $user) {
        if ($user['id'] === $id) {
            echo json_encode(['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email']]);
            exit;
        }
    }
    echo json_encode(['status' => 'error', 'message' => 'Пользователь не найден']);
    exit;
}

// ОБНОВИТЬ ПАРОЛЬ
if (preg_match('#/users/(\d+)#', $path, $matches) && $method === 'PUT') {
    $id = (int)$matches[1];
    $newPassword = $input['password'] ?? '';
    
    if (!$newPassword) {
        echo json_encode(['status' => 'error', 'message' => 'Новый пароль обязателен']);
        exit;
    }
    
    $users = getAllUsers();
    $found = false;
    foreach ($users as &$user) {
        if ($user['id'] === $id) {
            $user['password'] = $newPassword;
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        echo json_encode(['status' => 'error', 'message' => 'Пользователь не найден']);
        exit;
    }
    
    saveUsers($users);
    echo json_encode(['status' => 'success', 'message' => 'Пароль обновлен']);
    exit;
}

// УДАЛИТЬ ПОЛЬЗОВАТЕЛЯ
if (preg_match('#/users/(\d+)#', $path, $matches) && $method === 'DELETE') {
    $id = (int)$matches[1];
    $users = getAllUsers();
    $newUsers = [];
    $found = false;
    
    foreach ($users as $user) {
        if ($user['id'] === $id) {
            $found = true;
        } else {
            $newUsers[] = $user;
        }
    }
    
    if (!$found) {
        echo json_encode(['status' => 'error', 'message' => 'Пользователь не найден']);
        exit;
    }
    
    saveUsers($newUsers);
    echo json_encode(['status' => 'success', 'message' => 'Пользователь удален']);
    exit;
}

// ПРОВЕРКА АВТОРИЗАЦИИ ДЛЯ КОРЗИНЫ
if ($path === '/check' && $method === 'GET') {
    session_start();
    if (isset($_SESSION['user_id'])) {
        echo json_encode(['auth' => true]);
    } else {
        echo json_encode(['auth' => false]);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Неверный запрос']);
?>