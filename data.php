<?php

$tasks = [];
$categories = [];

$intervals = [
    'all' => [],
    'today' => [
        'min' => 0,
        'max' => 86400 //секунд в сутках
    ],
    'tomorrow' => [
        'min' => 86400, //секунд в сутках
        'max' => 172800 //секунд в 2x сутках
    ],
    'overdue' => [
        'max' => 0
    ]
];
