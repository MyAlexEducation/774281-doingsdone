<?php
require_once ('vendor/autoload.php');
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

if (!isset($_SESSION['show_completed'])) {
    $_SESSION['show_completed'] = 0;
}


$current_user_id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : NULL;

if ($current_user_id !== NULL) {
    $sql_get_list_categories = 'SELECT *, (SELECT COUNT(*) FROM tasks as t WHERE t.project_id=projects.id) as cnt FROM projects WHERE user_id = ?';
    $categories = db_fetch_data($link, $sql_get_list_categories, [$current_user_id]);
}
