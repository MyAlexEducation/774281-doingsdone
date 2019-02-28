<?php
require_once('init.php');

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
