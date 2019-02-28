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
    } else {
        $sql_get_user_projects = 'SELECT * FROM projects WHERE user_id = ? AND title = ?';
        $user_project_info = db_fetch_data($link, $sql_get_user_projects, [$current_user_id, $_POST['name']]);

        if (!empty($user_project_info)) {
            $errors['name'] = 'У вас уже есть проект с данным именем';
            var_dump($user_project_info);
        }
    }

    if (empty($errors)) {
        $sql_put_new_project = 'INSERT INTO projects SET user_id = ?, title = ?';
        $new_project_info = [$current_user_id, $_POST['name']];
        db_insert_data($link, $sql_put_new_project, $new_project_info);
        header('Location: /');
    }

    $page_content = include_template('project.php', [
        'form_info' => $form_info,
        'errors' => $errors
    ]);
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
