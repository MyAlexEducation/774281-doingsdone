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
};

function countCategory($elements, $category)
{
    $count = 0;
    foreach ($elements as $key => $item) {
        if ($item["category"] === $category) {
            $count++;
        }
    }
    return $count;
};

function esc($str)
{
    $text = htmlspecialchars($str);
    //$text = strip_tags($str);

    return $text;
};

function isTaskTime($taskData)
{
    $currentTime = time();
    $taskTime = strtotime($taskData);
    $criticalTaskTime = 3600;  //количество секунд в часе
    return $taskTime - $currentTime < $criticalTaskTime && $taskTime != 0;
};
