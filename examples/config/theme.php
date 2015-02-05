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
    'package' => null,
    'layout' => [
        'element' => [
            'template' => [
                'model' => 'Theme\Element\Type\Template',
                'output_model' => [
                    'html' => 'Theme\Element\Output\Html\Template',
                ],
            ],
            'text' => [
                'model' => 'Theme\Element\Type\Text',
                'output_model' => [
                    'html' => 'Theme\Element\Output\Html\Text',
                ],
            ],
            'document_head' => [
                'model' => 'Theme\Element\Type\Document\Head',
                'output_model' => [
                    'html' => 'Theme\Element\Output\Html\Document\Head',
                    'json' => 'Layout\Element\Output\Json\JsonIgnore'
                ],
            ],
        ],
    ],
];
