<?php

namespace App\Models;

use App\Controllers\formController;

require_once __DIR__ . '/../../vendor/autoload.php';
use App\Models\Db;

$config = require_once __DIR__ . '/../../config/config.php';

$db = Db::getInstance()->getConnection($config['db']);

// Insert data to user_phones db
if (isset($_POST['new-data-btn'])) {

    $objnameType = [
        'name' => 'string',
        'phone' => 'integer',
        'checkbox' => 'bool'
    ];
    
    $fieldMapping = [
        'name' => 'user',
        'phone' => 'phone',
        'checkbox' => 'checkbox'
    ];
    
    // Create an instance of FormController
    $formController = new formController($config['db']);
    
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
        'name' => 'string',
        'email' => 'string',
        'checkbox' => 'bool'
    ];

    $fieldMapping = [
        'name' => 'user',
        'email' => 'email',
        'checkbox' => 'checkbox'
    ];

    // Create an instance of FormController
    $formController = new formController($config['db']);

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
        $formController = new formController($config['db']);

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
        // Decoding JSON into associative array
        $data = json_decode($dataJson, true);
        // echo $data;

        // Check for JSON errors
        if (json_last_error() === JSON_ERROR_NONE) {
            $formController = new formController($config['db']);

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
