<?php
require_once('init.php');

$sidebar = include_template('project_sidebar.php', [
    'tasks' => $tasks,
    'categories' => $categories,
    'filters_categories' => $filters_categories
]);

$page_content = include_template('project.php', []);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_info = $_POST;

    $required = ['name'];
    $dict = ['name' => 'Название'];
    $errors = [];

    if (empty($_POST['name'])) {
        $errors['name'] = 'Это поле надо заполнить';
    }

    if (empty($errors)) {
        $sql_put_new_project = 'INSERT INTO projects SET user_id = ?, title = ?';
        $new_project_info = [$current_user_id, $_POST['name']];
        db_insert_data($link, $sql_put_new_project, $new_project_info);
        header('Location: /');
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
