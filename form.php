<?php

// Include the necessary files
include 'classes/formController.php';
include 'classes/Db.php';


// Load the database configuration
$config = require_once 'config.php';

// Get user ID from the URL query parameter if provided, otherwise set it to null
$get_id = isset($_GET['id']) ? $_GET['id'] : null;


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

// delete data view changing flag value to 0 
if (isset($_POST['delete'])) {

    $tableName = isset($_POST['table']) ? $_POST['table'] : '';
    $flag = isset($_POST['flag']) ? $_POST['flag'] : '';
    $dataID = isset($_POST['id']) ? $_POST['id'] : '';

    if ($tableName && $flag && $dataID) {
        // Create an instance of FormController
        $formController = new FormController($config['db']);

        // Call the method to delete the data
        $result = $formController->deleteDataView($tableName, $flag, $dataID);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Item deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete item']);
        }
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
        exit();
    }
}

if (isset($_POST['edit'])) {
    $tableName = isset($_POST['table']) ? $_POST['table'] : '';
    $dataJson = isset($_POST['dataTable']) ? $_POST['dataTable'] : '';
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    if ($tableName && $dataJson && $id) {
        // Декодуємо JSON в асоціативний масив
        $data = json_decode($dataJson, true);
        // echo $data;

        // Перевірка на помилки JSON
        if (json_last_error() === JSON_ERROR_NONE) {
            $formController = new FormController($config['db']);

            $result = $formController->editTable($tableName, $data, $id);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Item updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update item']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
        }
    }
}
