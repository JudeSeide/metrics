<?php declare(strict_types=1);

return [
    'default' => 'local',
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => getcwd(),
        ],
    ],
    'resources' => [
        'directory' => getcwd().DIRECTORY_SEPARATOR.'resources',
        'artefacts' => getcwd().DIRECTORY_SEPARATOR.'artefacts',
        'metadata' => 'resources'.DIRECTORY_SEPARATOR.'libraries.json',
    ]
];
