<?php
$show_complete_tasks = rand(0, 1);

$categories = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];

$tasks = [
    [
        "name" => "Собеседование в IT компании",
        "data" => "01.12.2019",
        "category" => "Работа",
        "isDone" => false
    ],
    [
        "name" => "Выполнить тестовое задание",
        "data" => "25.12.2019",
        "category" => "Работа",
        "isDone" => false
    ],
    [
        "name" => "Сделать задание первого раздела",
        "data" => "21.12.2019",
        "category" => "Учеба",
        "isDone" => true
    ],
    [
        "name" => "Встреча с другом",
        "data" => "22.12.2019",
        "category" => "Входящие",
        "isDone" => false
    ],
    [
        "name" => "Купить корм для кота",
        "data" => "10.02.2019", //проверка работы функции isTaskTime
        "category" => "Домашние дела",
        "isDone" => false
    ],
    [
        "name" => "Заказать пиццу",
        "data" => "",
        "category" => "Домашние дела",
        "isDone" => false
    ]
];