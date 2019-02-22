<?php
require_once('functions.php');
require_once('data.php');
date_default_timezone_set('Europe/Moscow');

$link = mysqli_connect('localhost', 'root', '', 'doingsdone');
if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
}
mysqli_set_charset($link, 'utf8');

$current_user_id = 2;
$sql_get_list_project = 'SELECT * FROM projects WHERE user_id = ' . $current_user_id;
$db_categories = db_fetch_data($link, $sql_get_list_project);
convert_db_categories($db_categories, $categories);

$filters_categories = 0;
if (isset($_GET['filter'])) {
    $filters_categories = intval($_GET['filter']);
    if ($categories[$filters_categories] === NULL) {
        http_response_code(404);
    }
}

$sql_get_list_tasks = 'SELECT projects.title AS project, tasks.title, critical_time, state, file FROM tasks JOIN projects ON tasks.project_id = projects.id WHERE tasks.user_id = ' . $current_user_id;
$db_tasks = db_fetch_data($link, $sql_get_list_tasks);
convert_db_tasks($db_tasks, $tasks);

$page_content = include_template('add.php', [
    'categories' => $categories
]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = $_POST;

    $required = ['date', 'project', 'name'];
    $dict = ['date' => 'Дата', 'project' => 'Проект', 'name' => 'Название'];
    $errors = [];

    if (empty($_POST['name'])) {
        $errors['name'] = 'Это поле надо заполнить';
    }

    if (!in_array($_POST['project'], $categories, true)) {
        $errors['project'] = 'Такого проекта не существует';
    }

    if (strtotime($_POST['date']) < time() && $_POST['date'] !== '') {
        $errors['date'] = 'Не корректное время';
    }

    if (isset($_FILES['preview']['name'])) {
        $tmp_name = $_FILES['preview']['tmp_name'];
        $path = $_FILES['preview']['name'];

        move_uploaded_file($tmp_name, '' . $path);
        $task['path'] = $path;
    }

    $page_content = include_template('add.php', [
        'task' => $task,
        'errors' => $errors,
        'dict' => $dict,
        'categories' => $categories
    ]);

    if (empty($errors)) {
        $sql_put_new_task = 'INSERT INTO tasks SET user_id = ' . $current_user_id . ', project_id = ' . array_search($_POST['project'], $categories) . ', state = 0, title = \'' . $_POST['name'] . '\'';
        if (!($_POST['date'] === '' or $_POST['date'] === NULL)) {
            $sql_put_new_task = $sql_put_new_task . ', critical_time = STR_TO_DATE(\'' . $_POST['date'] . '\', \'%d.%m.%Y\')';
        }
        if ($_FILES['preview']['name'] != NULL) {
            $sql_put_new_task = $sql_put_new_task . ', file = \'' . $_FILES['preview']['name'] . '\'';
        }
        db_insert_data($link, $sql_put_new_task);
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
