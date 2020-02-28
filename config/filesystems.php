<?php declare(strict_types=1);

$path = getcwd().DIRECTORY_SEPARATOR.'resources';

return [
    'default' => 'local',
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => getcwd(),
        ],
    ],
    'resources' => [
        'directory' => $path,
        'metadata' => 'resources'.DIRECTORY_SEPARATOR.'libraries.json',
    ]
];
