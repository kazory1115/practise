<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/a', function () {
    echo 'a';
});




$routes->group('library', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'Library::index');
    //總書籍
    $routes->get('getlist', 'Library::getList');
    //分類
    $routes->get('getGenre', 'Library::getGenres');

    $routes->post('addBook', 'Library::createBook');
});

// 這是測試用的路由
$routes->get('/test', 'Library::test');
$routes->get('/testData', 'Library::createTest');
