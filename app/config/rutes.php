<?php
// Archivo de rutas en app/config/routes.php

return [
    '/' => 'AuthController@login',
    '/login' => 'AuthController@login',
    '/logout' => 'AuthController@logout',
    '/dashboard' => 'DashboardController@index',
    '/contacts' => 'ContactController@index',
    '/edit-profile' => 'ProfileController@edit',
    '/request' => 'RequestController@handleRequest',
];
