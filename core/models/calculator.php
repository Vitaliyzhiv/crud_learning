<?php 
namespace App\Models;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Controllers\calculatorEval;
use Exception;

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
        $result = $calc->calculate($expression);
        
        // Populate the response
        $response['success'] = true;
        $response['result'] = $result;
    } catch (Exception $e) {
        // Handle calculation errors
        $response['message'] = 'Error calculating expression: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'No expression provided.';
}

// Output JSON response
echo json_encode($response);
