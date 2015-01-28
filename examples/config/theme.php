<?php
/** {license_text}  */
return [
    'filesystem' => [
        // Local path
        'design' => realpath(base_path('resources/design')),
        // Flysystem configuration
        'public' => [
            'driver'     => 'local',
            'path'       => realpath(base_path('public/design'))
        ],
    ],
    'frontend' => [
        'base_url' => function () { return url('design'); }
    ],
    'theme' => [
        'default' => null,
        'current' => null,
    ],
    'package' => null
];
