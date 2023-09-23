<?php

declare(strict_types=1);

// +----------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://www.logad.net
// | @author_email  : michael@logad.net
// | @date          : 10 Sep, 2023 12:11 PM
// +----------------------------------------------------+

use Pecee\SimpleRouter\SimpleRouter;

// Include the composer autoloader
require dirname(__FILE__, 2) . '/app/bootstrap.php';

// Include routes
require ROUTES_PATH . '/api.php';

SimpleRouter::enableMultiRouteRendering(false);

function apiOrPageError(string $message, int $code): void
{
    if (request()->getUrl()->contains('/api')) {
        response()->httpCode($code)->json([
            'error' => true,
            'message' => $message
        ]);
    }
}
try {
    SimpleRouter::start();
} catch (\Pecee\SimpleRouter\Exceptions\HttpException $e) {
    apiOrPageError($e->getMessage(), $e->getCode());
} catch (Exception $e) {
    apiOrPageError("Server Error", 500);
}
