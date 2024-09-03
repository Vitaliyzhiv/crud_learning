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
     * @return float $expression result
     */

    /** 
     * Calculates the math expression
     * @param string $expression Math expression for calculation
     * @return float|null Result of the calculation or null in case of an error
     */
    public function calculate($expression) {
        try {
            // parsing string expression
            $parseExpression = $this->parser->parse($expression);

            // calculating expression
            $result = $parseExpression->accept($this->evaluator);
            
            return $result;
        } catch (Exception $e) {
            // Log error or handle it accordingly
            error_log($e->getMessage());
            return null;
        }
    }
}

