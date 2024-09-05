<?php 

namespace App\Controllers;

require_once __DIR__ . '/../../vendor/autoload.php';

use MathParser\StdMathParser;
use MathParser\Interpreting\Evaluator;
use Exception;

class calculatorEval {
    
    private $parser;
    private $evaluator;

    public function __construct() {
        $this->parser = new StdMathParser();
        $this->evaluator = new Evaluator();
    }

    /** 
     * Calculates the math expression
     * @param string $expression Math expression for calculation
     * @param string $postname POST field name where the result will be saved
     * @return mixed $expression result
     */
    public function calculate(string $expression, string $postname) {
        try {
            // parsing string expression
            $parseExpression = $this->parser->parse($expression);

            // calculating expression
            $result = $parseExpression->accept($this->evaluator);
            
            // storing result in $_POST as asocciative ['result' => $result] example

            $_POST[$postname] = $result;
            
            // returning the result
            return $result;
        } catch (Exception $e) {
            // Log error or handle it accordingly
            error_log($e->getMessage());
            return null;
        }
    }
}

