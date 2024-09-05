<?php 
use App\Templates\Header;
use App\Templates\Footer;

$header = new Header();
$header->render();
?>

<div class="container mt-5">
    <!--  return to main page button -->
    <a href="http://localhost/" class="btn btn-outline-primary w-100 mb-5">Back to main page</a>
    <p class="errors h1 text-center">
        <strong> 404 Page not found</strong>
    </p>
</div>

<?php $footer = new Footer();
$footer->render();