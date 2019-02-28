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

if (intval($_GET['task_id']) != 0  && (intval($_GET['check']) == 0 || intval($_GET['check']) == 1)) {
    $is_page_update = false;
    $value_state = intval($_GET['check']);
    $value_task_id = intval($_GET['task_id']);
    $sql_update_isDone_task = 'UPDATE tasks SET state = ? WHERE id = ?';
    $sql_task_info = [$value_state, $value_task_id];
    foreach ($tasks as $key => $item) {
        if ($item['id'] === $value_task_id && intval($item['isDone']) !== $value_state) {
            db_fetch_data($link, $sql_update_isDone_task, $sql_task_info);
            $is_page_update = true;
        }
    }
    if ($is_page_update) {
        $is_page_update = false;
        header('Refresh:0');
    }
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
