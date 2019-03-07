<?php
require_once('init.php');

$show_completed = false;

if (isset($_GET['filter_task']) && !isset($intervals[$_GET['filter_task']])) {
    http_response_code(404);
}

if (!isset($_GET['task_id'])) {
    $_GET['task_id'] = NULL;
}

if ($current_user_id !== NULL) {
    $sql_get_list_tasks = 'SELECT * FROM tasks WHERE user_id = ?';
    $sql_tasks_info = [$current_user_id];

    if (!isset($_GET['category'])) {
        $_GET['category'] = '0';
    }
    if ($_GET['category'] !== '0' && !empty($categories)) {
        if (!in_array(intval($_GET['category']), array_column($categories, 'id'))) {
            http_response_code(404);
        } else {
            $sql_get_list_tasks = $sql_get_list_tasks . ' AND project_id = ?';
            $sql_tasks_info[] = intval($_GET['category']);
        }
    }

    if (!isset($_GET['filter_task'])) {
        $_GET['filter_task'] = 'all';
    }
    switch ($_GET['filter_task']) {
        case 'all':
            break;
        case 'today':
            $sql_get_list_tasks = $sql_get_list_tasks . ' AND critical_time >= DATE_FORMAT(NOW(), \'%Y-%m-%d 00:00:00\') AND critical_time <= DATE_FORMAT(NOW(), \'%Y-%m-%d 23:59:59\')';
            break;
        case 'tomorrow':
            $sql_get_list_tasks = $sql_get_list_tasks . ' AND critical_time >= DATE_FORMAT(NOW() + INTERVAL 1 DAY, \'%Y-%m-%d 00:00:00\') AND critical_time <= DATE_FORMAT(NOW() + INTERVAL 1 DAY, \'%Y-%m-%d 23:59:59\')';
            break;
        case 'overdue':
            $sql_get_list_tasks = $sql_get_list_tasks . ' AND critical_time < DATE_FORMAT(NOW(), \'%Y-%m-%d 00:00:00\')';
            break;
        default:
            http_response_code(404);
    }

    if (isset($_GET['show_completed'])) {
        $show_completed = ($_GET['show_completed'] === '1');
    }
    if (!$show_completed) {
        $sql_get_list_tasks = $sql_get_list_tasks . ' AND state <> 1';
    }

    if (isset($_GET['search_task'])) {
        $sql_get_list_tasks = $sql_get_list_tasks . ' AND MATCH(tasks.title) AGAINST(?)';
        $sql_tasks_info[] = $_GET['search_task'];
    }

    $tasks = db_fetch_data($link, $sql_get_list_tasks, $sql_tasks_info);
}

if (intval($_GET['task_id']) != 0 && (intval($_GET['check']) == 0 || intval($_GET['check']) == 1)) {
    $is_page_update = false;
    $value_state = intval($_GET['check']);
    $value_task_id = intval($_GET['task_id']);
    $sql_update_isDone_task = 'UPDATE tasks SET state = ? WHERE id = ?';
    $sql_task_info = [$value_state, $value_task_id];
    foreach ($tasks as $key => $item) {
        if ($item['id'] === $value_task_id && intval($item['state']) !== $value_state) {
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
    'categories' => $categories,
]);

$page_content = include_template('index.php', [
    'tasks' => $tasks,
    'categories' => $categories,
    'show_completed' => $show_completed,
]);

$layout_content = include_template('layout.php', [
    'title' => 'Дела в порядке',
    'content' => $page_content,
    'sidebar' => $sidebar,
    'access' => $access
]);

echo($layout_content);
