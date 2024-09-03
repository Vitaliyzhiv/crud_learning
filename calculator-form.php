<?php

require_once 'vendor/autoload.php';

use App\Templates\Header;
use App\Templates\Footer;

// Use the fully qualified class name for MobileDetect
$detect = new \Detection\MobileDetect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
echo $deviceType;

$config = require_once 'config/config.php';  // Updated path

// Use the class name for Db
use App\Models\Db;
use App\Models\form;

$db = Db::getInstance()->getConnection($config['db']);

// Renders a header 
$header = new header();
$header->render();

?>

<style>
    .calculator-container {
    max-width: 400px; 
    margin: 0 auto; 
    top: 50px; ;
    position: relative;
    padding: 20px; 
    border: 2px solid #ccc; 
    border-radius: 10px; 
    background-color: #f9f9f9; 
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 

}

.btn-reset {
    width: 100%;
}


.btn-block {
    margin: 5px 0;
}

.col {
    padding: 0 5px; 
    display: flex; 
    justify-content: center;
    align-items: center; 
}

input#result {
    width: 100%;
}
</style>

<div class="container mt-5">
<p class="errors"></p>
    <!--  return to main page button -->
    <a href="http://localhost/" class="btn btn-outline-primary w-100">Back to main page</a>
</div>

<div class="container calculator-container">
    <div class="col-12">
        <div class="row">
        <div class="col-8">
            <input  class="form-calc-input" type="text" id="result">
        </div>
        <div class="col-4">
            <input  class="form-calc-result" type="text" id="result" readonly>
        </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn calc-btn btn-secondary btn-block" value="7">7</button>
            </div>
            <div class="col">
                <button class="btn calc-btn btn-secondary btn-block" value="8">8</button>
            </div>
            <div class="col">
                <button class="btn calc-btn btn-secondary btn-block" value="9">9</button>
            </div>
            <div class="col">
                <button class="btn calc-btn btn-primary btn-block" value="/">/</button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn calc-btn btn-secondary btn-block" value="4">4</button>
            </div>
            <div class="col">
                <button class="btn calc-btn btn-secondary btn-block" value="5">5</button>
            </div>
            <div class="col">
                <button class="btn calc-btn btn-secondary btn-block" value="6">6</button>
            </div>
            <div class="col">
                <button class="btn calc-btn btn-primary btn-block" value="*">*</button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn calc-btn btn-secondary btn-block" value="1">1</button>
            </div>
            <div class="col">
                <button class="btn calc-btn btn-secondary btn-block" value="2">2</button>
            </div>
            <div class="col">
                <button class="btn calc-btn btn-secondary btn-block" value="3">3</button>
            </div>
            <div class="col">
                <button class="btn calc-btn btn-primary btn-block" value="-">-</button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn calc-btn btn-secondary btn-block" value="0">0</button>
            </div>
            <div class="col">
                <button class="btn calc-btn btn-secondary btn-block" value=".">.</button>
            </div>
            <div class="col">
                <button type="submit" id="calc-result" class="btn  btn-primary btn-block" name="submit-calc" value="=">
                    =
                </button>
            </div>
            <div class="col">
                <button class="btn calc-btn btn-primary btn-block" value="+">+</button>
            </div>
        </div>
        <div class="row">
        <div class="col-6 col">
                <button class="btn btn-reset reset-btn btn-secondary btn-block" value="clear-last">&#9003;</button > <!-- Backspace -->
            </div>
            <div class="col-6 col">
                <button class="btn btn-reset reset-btn btn-secondary btn-block" value="reset">Reset</button> <!-- Reset -->
            </div>

        </div>
    </div>
</div>

<?php $footer = new footer();
$footer->render();
