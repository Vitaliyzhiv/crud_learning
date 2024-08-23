<?php

// Include the necessary files
include 'classes/formController.php';
include 'classes/Db.php';

// Load the database configuration
$config = require_once 'config.php';

// Create a database connection instance
$db = (Db::getInstance())->getConnection($config['db']);

// Insert data to user_phones db
if (isset($_POST['new-data-btn'])) {

    $objnameType = [
        'user' => 'string',
        'phone' => 'integer',
        'checkbox' => 'bool'
    ];
    
    $fieldMapping = [
        'user' => 'user',
        'phone' => 'phone',
        'checkbox' => 'checkbox'
    ];
    
    // Create an instance of FormController
    $formController = new FormController($config['db']);
    
    // Process the form data
    $response = $formController->insertData($objnameType, 'users_phones', $fieldMapping);
    
    // Output the response
    if ($response['success']) {
        echo 'Success: ' . $response['message'];
        exit();
    } else {
        echo 'Error: ' . $response['message'];
        exit();
    }
    
}


if (isset($_POST['data-button'])) {
    
    $objnameType = [
        'user' => 'string',
        'email' => 'string',
        'checkbox' => 'bool'
    ];

    $fieldMapping = [
        'user' => 'user',
        'email' => 'email',
        'checkbox' => 'checkbox'
    ];

    // Create an instance of FormController
    $formController = new FormController($config['db']);

    // Process the form data
    $response = $formController->insertData($objnameType, 'data_users', $fieldMapping);

    // Output the response
    if ($response['success']) {
        echo 'Success: ' . $response['message'];
        exit();
    } else {
        echo 'Error: ' . $response['message'];
        exit();
    }
}



$sql_phones = 'SELECT * FROM users_phones';


$sql_users = 'SELECT * FROM data_users';

$result_phones = $db->query($sql_phones);
$result_users = $db->query($sql_users);


$phones_data = $result_phones->findAll();

$users_data = $result_users->findAll();


