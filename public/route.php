    <?php

    require_once __DIR__ . '/../vendor/autoload.php';  // Include the autoloader

    // Get the request URI
    $requestUri = $_SERVER['REQUEST_URI'];

    echo '<pre>';
    echo " Route.php is being accessed. {$requestUri} ";
    echo '</pre>';

    // Remove query string if present
    $parsedUrl = parse_url($requestUri);
    $path = $parsedUrl['path'];

    // Routing configuration
    switch ($path) {
        case '/':
        case '/index.php':
            require __DIR__ . '/../index.php';  // This is main page of project
            break;

        case '/users-phones.php':
            require __DIR__ . '/../users-phones.php';  // This is page where table-user phones are displayed
            break;

        case '/users-emails.php':
            require __DIR__ . '/../users-emails.php';  // This is page where table-user emails are displayed
            break;
        
        case '/calculator-form.php':
            require __DIR__ . '/../calculator-form.php';  // This is page for calculator
            break;
        
        default:
            require __DIR__ . '/../404.php';  // Page not found
            break;
    }
