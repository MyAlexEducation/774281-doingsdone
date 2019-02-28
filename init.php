<?php
require_once('data.php');
require_once('functions.php');
session_start();

date_default_timezone_set('Europe/Moscow');
$access = 'user';

$link = mysqli_connect('localhost', 'root', '', 'doingsdone');
if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
}
mysqli_set_charset($link, 'utf8');

$current_user_id = $_SESSION['user']['id'];
if ($current_user_id !== NULL) {
    $sql_get_list_project = 'SELECT * FROM projects WHERE user_id = ?';
    $db_categories = db_fetch_data($link, $sql_get_list_project, [$current_user_id]);
    convert_db_categories($db_categories, $categories);

    if (isset($_GET['filter'])) {
        $filters['filter_categories'] = intval($_GET['filter']);
        if ($categories[$filters['filter_categories']] === NULL) {
            http_response_code(404);
        } else {
            $_SESSION['filters']['filter_categories'] = $filters['filter_categories'];
        }
    }

    if (isset($_GET['filter_task'])) {
        $filters['filter_task'] = $_GET['filter_task'];
        if ($intervals[$filters['filter_task']] === NULL) {
            http_response_code(404);
        } else {
            $_SESSION['filters']['filter_task']= $filters['filter_task'];
        }
    }

    if (isset($_GET['show_completed'])) {
        $filters['show_completed'] = ($_GET['show_completed'] === '1');
        $_SESSION['filters']['show_completed'] = $filters['show_completed'];
    }

    $sql_get_list_tasks = 'SELECT projects.title AS project, tasks.title, critical_time, state, file FROM tasks JOIN projects ON tasks.project_id = projects.id WHERE tasks.user_id = ?';
    $db_tasks = db_fetch_data($link, $sql_get_list_tasks, [$current_user_id]);
    convert_db_tasks($db_tasks, $tasks);
}
