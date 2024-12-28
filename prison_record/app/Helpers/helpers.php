<?php

if (!function_exists('isActive')) {
    function isActive($routes, $activeClass = 'bg-indigo-600 text-white', $inactiveClass = 'hover:bg-gray-800 hover:text-white') {
        // Convert string to array if single route is passed
        $routes = (array)$routes;
        
        foreach($routes as $route) {
            if (Route::is($route)) {
                return $activeClass;
            }
        }
        
        return $inactiveClass;
    }
}