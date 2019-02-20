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

$current_user_id = 1;
$sql_get_list_project = 'SELECT * FROM projects WHERE user_id = ' . $current_user_id;
$db_categories = db_fetch_data($link, $sql_get_list_project);
$categories = [];
foreach ($db_categories as $key => $item) {
    array_push($categories, $item['title']);
};

$filters_categories =  '';
if (isset($_GET['filter'])) {
    $filters_categories = $_GET['filter'];
    if (!in_array($filters_categories, $categories)) {
        http_response_code(404);
    }
}

$sql_get_list_tasks = 'SELECT projects.title AS project, tasks.title, critical_time, state FROM tasks JOIN projects ON tasks.project_id = projects.id WHERE tasks.user_id = ' . $current_user_id;
$db_tasks = db_fetch_data($link, $sql_get_list_tasks);
$tasks = [];
foreach ($db_tasks as $key => $item) {
    $task = [];
    $task['name'] = $item['title'];
    $task['data'] = date('d.m.Y', strtotime($item['critical_time']));
    $task['category'] = $item['project'];
    $task['isDone'] = ($item['state'] === 1);
    array_push($tasks, $task);
};

$page_content = include_template('index.php', [
    'show_complete_tasks' => $show_complete_tasks,
    'tasks' => $tasks,
    'filters_categories' => $filters_categories
]);

$layout_content = include_template('layout.php', [
    'title' => 'Дела в порядке',
    'content' => $page_content,
    'categories' => $categories,
    'tasks' => $tasks,
]);

echo($layout_content);
