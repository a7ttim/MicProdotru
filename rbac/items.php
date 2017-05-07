<?php
return [
    'pm' => [
        'type' => 1,
    ],
    'pe' => [
        'type' => 1,
    ],
    'dh' => [
        'type' => 1,
    ],
    'pm+pe' => [
        'type' => 1,
        'children' => [
            'pm',
            'pe',
        ],
    ],
    'pm+dh' => [
        'type' => 1,
        'children' => [
            'pm',
            'dh',
        ],
    ],
    'dh+pe' => [
        'type' => 1,
        'children' => [
            'pe',
            'dh',
        ],
    ],
    'super' => [
        'type' => 1,
        'children' => [
            'pe',
            'pm',
            'dh',
        ],
    ],
];
