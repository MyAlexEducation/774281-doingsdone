<?php
require_once('init.php');

$page_content = include_template('register.php', []);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST;

    $required = ['email', 'password', 'name'];
    $dict = ['email' => 'Почта', 'password' => 'Пароль', 'name' => 'Имя'];
    $errors = [];

    if ($_POST['email'] === NULL || $_POST['email'] === '') {
        $errors['email'] = 'E-mail не введён';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'E-mail введён некорректно';
    } else {
        $sql_get_id_user_for_email = 'SELECT id FROM users WHERE email = ?';
        $user_email_info = [$_POST['email']];
        if (db_fetch_data($link, $sql_get_id_user_for_email, $user_email_info)) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        }
    }

    if ($_POST['password'] === NULL || $_POST['password'] === '') {
        $errors['password'] = 'Пароль не введён';
    }

    if ($_POST['name'] === NULL || $_POST['name'] === '') {
        $errors['name'] = 'Введите имя';
    }

    $page_content = include_template('register.php', [
        'user' => $user,
        'errors' => $errors,
        'dict' => $dict,
    ]);

    if (empty($errors)) {
        $sql_put_new_user = 'INSERT INTO users SET email= ?, password = ?, name = ?';
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $new_user_info = [($_POST['email']), $password, $_POST['name']];
        db_insert_data($link, $sql_put_new_user, $new_user_info);
        header('Location: /');
    }
}

$layout_content = include_template('layout.php', [
    'title' => 'Дела в порядке',
    'content' => $page_content,
    'categories' => $categories,
    'tasks' => $tasks,
]);

echo($layout_content);
