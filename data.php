<?php
$show_complete_tasks = rand(0, 1);

$categories = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];

$tasks = [
    [
        "name" => "Собеседование в IT компании",
        "data" => "01.12.2019",
        "category" => $categories[2],
        "isDone" => false
    ],
    [
        "name" => "Выполнить тестовое задание",
        "data" => "25.12.2019",
        "category" => $categories[2],
        "isDone" => false
    ],
    [
        "name" => "Сделать задание первого раздела",
        "data" => "21.12.2019",
        "category" => $categories[1],
        "isDone" => true
    ],
    [
        "name" => "Встреча с другом",
        "data" => "22.12.2019",
        "category" => $categories[0],
        "isDone" => false
    ],
    [
        "name" => "Купить корм для кота",
        "data" => "",
        "category" => $categories[3],
        "isDone" => false
    ],
    [
        "name" => "Заказать пиццу",
        "data" => "",
        "category" => $categories[3],
        "isDone" => false
    ]
];