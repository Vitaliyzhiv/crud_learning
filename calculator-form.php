<?php

require_once 'vendor/autoload.php';

use App\Templates\Header;
use App\Templates\Footer;
use App\Templates\Alert;

// Use the fully qualified class name for MobileDetect
$detect = new \Detection\MobileDetect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
echo $deviceType;

$config = require_once 'config/config.php';  // Updated path

// Use the class name for Db
use App\Models\Db;
use App\Models\form;

$db = Db::getInstance()->getConnection($config['db']);

// Select all data from table
$sql = 'SELECT * FROM calculations';

// Execute the query
$result = $db->query($sql);

// Find all rows(results)
$calculations = $result->findAll();

// Renders a header 
$header = new Header();
$header->render();

?>

<style>
    .calculator-container {
        max-width: 400px;
        margin: 0 auto;
        top: 20px;
        ;
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
    <p class="success text-center"></p>
    <!--  return to main page button -->
    <a href="http://localhost/" class="btn btn-outline-primary w-100">Back to main page</a>
</div>

<div class="container calculator-container mb-5">
    <div class="col-12">
        <div class="row">
            <div class="col-8">
                <input class="form-calc-input" type="text" id="result">
            </div>
            <div class="col-4">
                <input class="form-calc-result" type="text" id="result" readonly>
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
            <div class="col ">
                <button class=" btn calc-btn btn-primary btn-block" value="^">^</button>
            </div>
            <div class="col">
                <button class="btn calc-btn btn-primary btn-block" value="+">+</button>
            </div>
        </div>
        <div class="row">
            <div class="col ">
                <button class=" d-none btn calc-btn btn-primary btn-block" value="^">^</button>
            </div>
            <div class="col ">
                <button class=" d-none btn calc-btn btn-primary btn-block" value="^">^</button>
            </div>
            <div class="col ">
                <button class=" d-none btn calc-btn btn-primary btn-block" value="^">^</button>
            </div>
            <div class="col">
                <button type="submit" id="calc-result" class="btn  btn-success btn-block" name="submit-calc" value="=">
                    =
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col">
                <button class="btn btn-reset reset-btn btn-secondary btn-block" value="clear-last">&#9003;</button>
                <!-- Backspace -->
            </div>
            <div class="col-6 col">
                <button class="btn btn-reset reset-btn btn-secondary btn-block" value="reset">Reset</button>
                <!-- Reset -->
            </div>
        </div>
    </div>
</div>

<div class="container">
<div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Expression</th>
                        <th>Result</th>
                        <th> Actions </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($calculations as $calc): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($calc['id']); ?></td>
                            <td><?php echo htmlspecialchars($calc['expression']); ?></td>
                            <td><?php echo htmlspecialchars($calc['result']); ?></td>
                            <td>
                            <a href="?id=<?php echo $calc['id']; ?>" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#edit<?php echo $calc['id']; ?>">
                                Edit
                            </a>
                                <!-- Delete button -->
                                <a href="?id=<?php echo $calc['id'];?>" class="btn btn-danger delete-emails-btn" data-id="<?php echo $calc['id'];?>" name="delete">Delete</a>
                            </td>
                        </tr>

                    <?php endforeach; ?>   
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php

$alert = new Alert();
$alert->render();

$footer = new Footer();
$footer->render();
