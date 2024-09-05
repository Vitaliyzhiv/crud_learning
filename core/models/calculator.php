<?php
namespace App\Models;

use App\Controllers\formController;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Controllers\calculatorEval;
use Exception;
use App\Models\Db;

$config = require_once __DIR__ . '/../../config/config.php';

$db = Db::getInstance()->getConnection($config['db']);

header('Content-Type: application/json');

$response = [
    'success' => false,
    'result' => null,
    'message' => ''
];

if (isset($_POST['calc_btn'])) {
    $calc = new calculatorEval();
    $expression = $_POST['expression'];

    try {
        // Calculate the result
        $result = $calc->calculate($expression, 'result');

        // Populate the response
        $response['success'] = true;
        $response['result'] = $result;

        if ($response['success']) {
            $formController = new formController($config['db']);


            $objnameType = [
                'expression' => 'string',
                'result' => 'integer',
            ];

            $fieldMapping = [
                'expression' => 'expression',
                'result' => 'result',
            ];

            // insert the result into the database
            $response = $formController->insertData($objnameType, 'calculations', $fieldMapping);

        }

  

    } catch (Exception $e) {
        // Handle calculation errors
        $response['message'] = 'Error calculating expression: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'No expression provided.';
}




// Output JSON response
echo json_encode($response);
