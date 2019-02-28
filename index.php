<?php
require_once('init.php');

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

$sidebar = include_template('project_sidebar.php', [
    'tasks' => $tasks,
    'categories' => $categories,
    'filters_categories' => $filters_categories
]);

$page_content = include_template('index.php', [
    'show_complete_tasks' => $show_complete_tasks,
    'tasks' => $tasks,
    'categories' => $categories,
    'filters' => $filters,
    'intervals' => $intervals
]);

$layout_content = include_template('layout.php', [
    'title' => 'Дела в порядке',
    'content' => $page_content,
    'sidebar' => $sidebar,
    'categories' => $categories,
    'tasks' => $tasks,
    'filters' => $filters,
    'access' => $access
]);

echo($layout_content);
