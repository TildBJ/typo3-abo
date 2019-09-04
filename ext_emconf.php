<?php
$EM_CONF[$_EXTKEY] = array(
    'title' => 'Abo',
    'description' => 'Simple abo management for TYPO3',
    'category' => 'plugin',
    'author' => 'Dennis Römmich',
    'author_email' => 'dennis@roemmich.e',
    'version' => '1.0.0',
    'shy' => '',
    'dependencies' => '',
    'conflicts' => '',
    'priority' => '',
    'module' => '',
    'state' => 'beta',
    'internal' => '',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'suggests' => [],
    'autoload' => [
        'psr-4' => [
            'TildBJ\\Abo\\' => 'Classes'
        ],
    ],
    'autoload-dev' => [
        'psr-4' => [
            'TildBJ\\Abo\\Tests\\' => 'Tests',
        ],
    ],
);
