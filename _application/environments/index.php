<?php
/**
 * The manifest of files that are local to specific environment.
 * This file returns a list of environments that the application
 * may be installed under. The returned data must be in the following
 * format:
 *
 * ```php
 * return [
 *     'environment name' => [
 *         'path' => 'directory storing the local files',
 *         'setWritable' => [
 *             // list of directories that should be set writable
 *         ],
 *         'setExecutable' => [
 *             // list of directories that should be set executable
 *         ],
 *         'setCookieValidationKey' => [
 *             // list of config files that need to be inserted with automatically generated cookie validation keys
 *         ],
 *         'createSymlink' => [
 *             // list of symlinks to be created. Keys are symlinks, and values are the targets.
 *         ],
 *     ],
 * ];
 * ```
 */
return [
    'Development' => [
        'path' => 'dev',
        'setWritable' => [
            '_application/backend/runtime',
            '_application/frontend/runtime',
            '_application/frontend/runtime/mail',
            '_application/console/runtime',

            '/web/assets',
            '/web/backend/assets',

            '/web/themes/cerulean/compiled',
            '/web/themes/default/compiled',
            '/web/themes/slate/compiled',
            '/web/themes/spacelab/compiled',

            '/web/backend/themes/cerulean/compiled',
            '/web/backend/themes/default/compiled',
            '/web/backend/themes/slate/compiled',
            '/web/backend/themes/spacelab/compiled',
        ],
        'setExecutable' => [
            '_application/yii',
        ],
        'setCookieValidationKey' => [
            '_application/backend/config/main-local.php',
            '_application/frontend/config/main-local.php',
        ],
    ],
    'Production' => [
        'path' => 'prod',
        'setWritable' => [
            '_application/backend/runtime',
            '_application/frontend/runtime',
            '_application/frontend/runtime/mail',
            '_application/console/runtime',
            '/web/assets',
            '/web/backend/assets',
            '/web/compiled',
            '/web/backend/compiled',
        ],
        'setExecutable' => [
            '_application/yii',
            '_application/frontend/runtime/mail',
        ],
        'setCookieValidationKey' => [
            '_application/backend/config/main-local.php',
            '_application/frontend/config/main-local.php',
        ],
    ],
    'Staging' => [
        'path' => 'staging',
        'setWritable' => [
            '_application/backend/runtime',
            '_application/frontend/runtime',
            '_application/frontend/runtime/mail',
            '_application/console/runtime',
            '/web/assets',
            '/web/backend/assets',
            '/web/compiled',
            '/web/backend/compiled',
        ],
        'setExecutable' => [
            '_application/yii',
        ],
        'setCookieValidationKey' => [
            '_application/backend/config/main-local.php',
            '_application/frontend/config/main-local.php',
        ],
    ],
];
