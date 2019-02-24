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
$sql_get_list_project = 'SELECT * FROM projects WHERE user_id = ?';
$db_categories = db_fetch_data($link, $sql_get_list_project, [$current_user_id]);
convert_db_categories($db_categories, $categories);

$filters_categories = 0;
if (isset($_GET['filter'])) {
    $filters_categories = intval($_GET['filter']);
    if ($categories[$filters_categories] === NULL) {
        http_response_code(404);
    }
}

$sql_get_list_tasks = 'SELECT projects.title AS project, tasks.title, critical_time, state, file FROM tasks JOIN projects ON tasks.project_id = projects.id WHERE tasks.user_id = ?';
$db_tasks = db_fetch_data($link, $sql_get_list_tasks, [$current_user_id]);
convert_db_tasks($db_tasks, $tasks);
