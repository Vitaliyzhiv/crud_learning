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
$header = new Header();
$header->render();


?>

<div class="alert alert-secondary text-center" role="alert">
    <p class="errors"></p>
</div>

<div class="container mt-5">
    <div class=" col-6 text-center position-relative mb-4" style="left: 25%;">
        <a href="http://localhost/calculator-form.php" class="btn btn-outline-primary w-100">
            Go to the calculator page
        </a>
    </div>
    <div class="row mb-3">
        <div class="col-6">
            <a href="http://localhost/users-phones.php" class="btn btn-outline-primary w-100">Watch
                users phones
                table
            </a>

            <h2 class="mt-2 text-center"> Users phones </h2>
            <form action="form.php" method="post">

                <h5 class="mb-2"> Name</h5>
                <input id="data-name" name="user" type="text" class="form-control mb-4"></input>
                <h5 class="mb-2"> Phone</h5>
                <input id="data-phone" name="phone" type="text" class="form-control mb-2"></input>
                <input type="checkbox" name="newcheckbox" id="checkbox-2">
                <button id="btn-form2" type="submit" name="new-data-btn" class="btn btn-primary ">
                    <h1 class="h5 mb-0">click</h1>
                </button>
            </form>

        </div>

        <div class="col-6">
            <a href="http://localhost/users-emails.php" class="btn btn-outline-primary w-100">Watch user
                emails
                table</a>

            <h2 class="mt-2 text-center"> Users mails </h2>
            <form action="form.php" method="post">
                <h5 class="mb-2"> Name</h5>
                <input id="data-user" name="data" type="text" class="form-control mb-4"></input>
                <h5 class="mb-2"> Email</h5>
                <input id="data-email" name="data-2" type="email" required class="form-control mb-2"></input>
                <input type="checkbox" name="checkbox" id="checkbox-1">
                <button id="btn-form" type="submit" name="data-button" class="btn btn-primary ">
                    <h1 class="h5 mb-0">click</h1>
                </button>
            </form>
        </div>
    </div>

</div>

<?php
// render footer
$footer = new Footer();
$footer->render();
