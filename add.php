<?php
require_once('init.php');

$access = 'user';

$sidebar = include_template('project_sidebar.php', [
    'tasks' => $tasks,
    'categories' => $categories,
]);

$page_content = include_template('add.php', [
    'categories' => $categories
]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = $_POST;
    $errors = [];

    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $errors['name'] = 'Это поле надо заполнить';
    }

    if (isset($_POST['project']) && !in_array(intval($_POST['project']), array_column($categories, 'id'))) {
        $errors['project'] = 'Такого проекта не существует';
    }

    if (strtotime($_POST['date']) < strtotime(date('d.m.Y 00:00:00')) && $_POST['date'] !== '') {
        $errors['date'] = 'Не корректное время';
        $task['date'] = '';
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
        'categories' => $categories
    ]);

    if (empty($errors)) {
        $sql_put_new_task = 'INSERT INTO tasks SET user_id = ?, state = ?, title = ?';
        $new_task_info = [$current_user_id, 0, $_POST['name']];
        if (isset($_POST['project'])) {
            $sql_put_new_task = $sql_put_new_task . ', project_id = ?';
            $new_task_info[] = $_POST['project'];
        }
        if (!($_POST['date'] === '' or $_POST['date'] === NULL)) {
            $sql_put_new_task = $sql_put_new_task . ', critical_time = STR_TO_DATE(?, \'%d.%m.%Y\')';
            $new_task_info[] = $_POST['date'];
        }
        if ($_FILES['preview']['name'] != NULL) {
            $sql_put_new_task = $sql_put_new_task . ', file = ?';
            $new_task_info[] = $_FILES['preview']['name'];
        }
        db_insert_data($link, $sql_put_new_task, $new_task_info);
        header('Location: /');
    }
}

$layout_content = include_template('layout.php', [
    'title' => 'Дела в порядке',
    'content' => $page_content,
    'sidebar' => $sidebar,
    'access' => $access
]);

echo($layout_content);
