<?php

require_once __DIR__ . '/../vendor/autoload.php';  // Include the autoloader

// Get the request URI
$requestUri = $_SERVER['REQUEST_URI'];

// echo '<pre>';
// echo " Route.php is being accessed. {$requestUri} ";
// echo '</pre>';

// Remove query string if present
$parsedUrl = parse_url($requestUri);
$path = $parsedUrl['path'];

// Check if the request is an AJAX request
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

// Avoid processing the current script again
$currentScript = basename($_SERVER['SCRIPT_NAME']);

if ($isAjax) {
    // If it's an AJAX request, handle it and exit
    $ajaxFiles = [
        '/core/models/form.php',
        '/core/models/calculator.php'
    ];

    if (in_array($path, $ajaxFiles)) {
        require __DIR__ . '/../' . ltrim($path, '/');  // Directly require the AJAX file
        exit;
    }
} else {
    // Routing configuration for non-AJAX requests
    switch ($path) {
        case '/':
        case '/index.php':
            require __DIR__ . '/../index.php';  // This is the main page of the project
            break;

        case '/users-phones.php':
            require __DIR__ . '/../users-phones.php';  // This is the page where user phones table is displayed
            break;

        case '/users-emails.php':
            require __DIR__ . '/../users-emails.php';  // This is the page where user emails table is displayed
            break;

        case '/calculator-form.php':
            require __DIR__ . '/../calculator-form.php';  // This is the page for calculator
            break;

        default:
            require __DIR__ . '/../404.php';  // Page not found
            break;
    }
}
