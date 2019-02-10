<?php
require_once('functions.php');
require_once('data.php');
date_default_timezone_set('Europe/Moscow');

$page_content = include_template('index.php', [
    'show_complete_tasks' => $show_complete_tasks,
    'tasks' => $tasks
]);

$layout_content = include_template('layout.php', [
    'title' => 'Дела в порядке',
    'content' => $page_content,
    'categories' => $categories,
    'tasks' => $tasks
]);

echo($layout_content);