<?php
function include_template($name, $data)
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function esc($str)
{
    $text = htmlspecialchars($str);
    //$text = strip_tags($str);

    return $text;
}

function db_get_prepare_stmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            } else if (is_string($value)) {
                $type = 's';
            } else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}

function db_fetch_data($link, $sql, $data = [])
{
    $result = [];
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $result;
}

function db_insert_data($link, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($link);
    }
    return $result;
}

function convert_db_categories($db, &$data) {
    $data = [];
    foreach ($db as $key => $item) {
        $data[$item['id']] = $item['title'];
    };
}

function convert_db_tasks($db, &$data) {
    $data = [];
    foreach ($db as $key => $item) {
        $task = [];
        $task['name'] = $item['title'];
        if ($item['critical_time'] != NULL) {
            $task['data'] = date('d.m.Y', strtotime($item['critical_time']));
        }
        if ($item['file'] != NULL) {
            $task['file'] = $item['file'];
        }
        $task['category'] = $item['project'];
        $task['isDone'] = ($item['state'] === 1);
        $task['id'] = ($item['id']);
        array_push($data, $task);
    };
}

function countCategory($elements, $category)
{
    $count = 0;
    foreach ($elements as $key => $item) {
        if ($item["category"] === $category) {
            $count++;
        }
    }
    return $count;
}


function isTaskTime($taskData)
{
    $currentTime = time();
    $taskTime = strtotime($taskData);
    $criticalTaskTime = 3600;  //количество секунд в часе
    return $taskTime - $currentTime < $criticalTaskTime && $taskTime != 0;
}

function is_date_interval($interval, $date)
{
    $current_interval = strtotime($date) + 86400 - time();
    return ($current_interval > $interval['min'] || $interval['min'] === NULL)
        && ($current_interval < $interval['max'] || $interval['max'] === NULL);
}
