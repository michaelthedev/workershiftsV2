<?php

declare(strict_types=1);

return [
    'redis' => [
        'enabled' => $_SERVER['REDIS_ENABLED'],
        'url' => $_SERVER['REDIS_URL'],
    ],
];