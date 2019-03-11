<?php
require_once('init.php');

$show_completed = false;

if ($current_user_id !== NULL) {
    $errors = [];
    $search = [];

    $task_id = isset($_GET['task_id']) ? intval($_GET['task_id']) : NULL;
    if (isset($_GET['check'])) {
        $task_state = intval($_GET['check']) === 1 ? 1 : 0;
    } else {
        $task_state = 0;
    }
    if ($task_id !== NULL) {
        $sql_get_update_task = 'SELECT * FROM tasks WHERE id = ? AND user_id = ?';
        $sql_update_task_info = [$task_id, $current_user_id];
        $update_task = db_fetch_data($link, $sql_get_update_task, $sql_update_task_info);
        if (!empty($update_task)) {
            $sql_update_isDone_task = 'UPDATE tasks SET state = ? WHERE id = ?';
            $sql_task_info = [$task_state, $task_id];
            db_fetch_data($link, $sql_update_isDone_task, $sql_task_info);
        }
    }

    $sql_get_list_tasks = 'SELECT * FROM tasks WHERE user_id = ?';
    $sql_tasks_info = [$current_user_id];

    if(isset($_GET['category'])) {
        if ($_GET['category'] !== '0' && !empty($categories)) {
            if (!in_array(intval($_GET['category']), array_column($categories, 'id'))) {
                http_response_code(404);
            } else {
                $sql_get_list_tasks = $sql_get_list_tasks . ' AND project_id = ?';
                $sql_tasks_info[] = intval($_GET['category']);
            }
        }
    }

    if (isset($_GET['filter_task'])) {
        switch ($_GET['filter_task']) {
            case 'today':
                $sql_get_list_tasks = $sql_get_list_tasks . ' AND critical_time >= DATE_FORMAT(NOW(), \'%Y-%m-%d 00:00:00\') AND critical_time <= DATE_FORMAT(NOW(), \'%Y-%m-%d 23:59:59\')';
                break;
            case 'tomorrow':
                $sql_get_list_tasks = $sql_get_list_tasks . ' AND critical_time >= DATE_FORMAT(NOW() + INTERVAL 1 DAY, \'%Y-%m-%d 00:00:00\') AND critical_time <= DATE_FORMAT(NOW() + INTERVAL 1 DAY, \'%Y-%m-%d 23:59:59\')';
                break;
            case 'overdue':
                $sql_get_list_tasks = $sql_get_list_tasks . ' AND critical_time < DATE_FORMAT(NOW(), \'%Y-%m-%d 00:00:00\')';
                break;
        }
    }

    if (isset($_GET['show_completed'])) {
        $show_completed = ($_GET['show_completed'] === '1');
    }
    if (!$show_completed) {
        $sql_get_list_tasks = $sql_get_list_tasks . ' AND state <> 1';
    }

    if (isset($_GET['search_task'])) {
        $errors = [];
        $search_task = trim($_GET['search_task']);
        $search['search_task'] = $search_task;
        if (strlen($search_task) > 3) {
            $sql_get_list_tasks = $sql_get_list_tasks . ' AND MATCH(tasks.title) AGAINST(?)';
            $sql_tasks_info[] = $search_task;
        } else {
            $errors['search_task'] = 'Введите для поиска более трёх символов';
        }
    }

    $tasks = db_fetch_data($link, $sql_get_list_tasks, $sql_tasks_info);
}

$sidebar = include_template('project_sidebar.php', [
    'categories' => $categories,
]);

$page_content = include_template('index.php', [
    'tasks' => $tasks,
    'categories' => $categories,
    'show_completed' => $show_completed,
    'errors' => $errors,
    'search' => $search,
]);

$layout_content = include_template('layout.php', [
    'title' => 'Дела в порядке',
    'content' => $page_content,
    'sidebar' => $sidebar,
    'access' => $access
]);

echo($layout_content);
