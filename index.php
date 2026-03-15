<?php

include __DIR__ . '/inc/all.inc.php';

$container = new \App\Utilities\Container();
$container->bind('countriesRepository', function () {
    return new \App\Repository\CountriesRepository();
});
$container->bind('countriesController', function () use ($container) {
    $countriesRepository = $container->get('countriesRepository');
    return new \App\Controller\CountriesController($countriesRepository);
});
$container->bind('notFoundController', function () use ($container) {
    $countriesRepository = $container->get('countriesRepository');
    return new \App\Controller\NotFoundController($countriesRepository);
});

$route = (@string)($_GET['route'] ?? 'countries');
if ($route === 'countries') {
    $countriesController = $container->get('countriesController');
    $countriesController->index();
} elseif (preg_match('/^country\/([a-zA-Z0-9]+)$/', $route, $matches)) {
    $code = (@string)($matches[1] ?? '');
    $countriesController = $container->get('countriesController');
    $countriesController->country($code);
} else {
    $notFoundController = $container->get('notFoundController');
    $notFoundController->error404();
}
