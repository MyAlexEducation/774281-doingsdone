<?php
require_once('init.php');

$access = 'all';
$sidebar = include_template('register_sidebar.php', []);
$page_content = include_template('auth.php', []);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login_info = $_POST;

    $required = ['email', 'password'];
    $dict = ['email' => 'Почта', 'password' => 'Пароль'];
    $errors = [];

    if ($_POST['email'] === NULL || $_POST['email'] === '') {
        $errors['email'] = 'E-mail не введён';
    }
    else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'E-mail введён некорректно';
    } else {
        $sql_get_user = 'SELECT * FROM users WHERE email = ?';
        $user = db_fetch_data($link, $sql_get_user, [$login_info['email']])[0];
        if (!$user) {
            $errors['email'] = 'Пользователя с такой почтой не существует';
        }
    }

    if ($_POST['password'] === NULL || $_POST['password'] === '') {
        $errors['password'] = 'Пароль не введён';
    } else if (!password_verify($login_info['password'], $user['password'])) {
        $errors['password'] = 'Неправильный пароль';
    }

    $page_content = include_template('auth.php', [
        'login_info' => $login_info,
        'errors' => $errors,
        'dict' => $dict,
    ]);

    if (empty($errors)) {
        $current_user_id = intval($user['id']);
        $_SESSION['user'] = $user;
        header("Location: /");
    }
}

$layout_content = include_template('layout.php', [
    'title' => 'Дела в порядке',
    'content' => $page_content,
    'sidebar' => $sidebar,
    'categories' => $categories,
    'tasks' => $tasks,
    'access' => $access
]);

echo($layout_content);
