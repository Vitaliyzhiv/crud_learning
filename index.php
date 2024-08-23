    <?php

    $config = require_once 'config.php';
    require_once 'classes/Db.php';

    $db = (Db::getInstance())->getConnection($config['db']);
    ?>

    <!doctype html>
    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <title>Hello, world!</title>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    </head>
    <body>

    <div class="alert alert-secondary text-center" role="alert">
        <p class="errors"></p>
    </div>

    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col-6">
                <a href="http://localhost/users-phones.php" class="btn btn-outline-primary w-100">Watch users phones table</a>
            </div>
            <div class="col-6">
                <a href="http://localhost/users-emails.php" class="btn btn-outline-primary w-100">Watch user emails table</a>
            </div>
        </div>

        <h2> Users mails </h2>
        <form action="form.php" method="post">
            <input id="data-user" name="data" type="text" class="form-control mb-4"></input>
            <input id="data-email" name="data-2" type="email" required class="form-control mb-4"></input>
            <input type="checkbox" name="checkbox" id="checkbox-1" >
            <button id="btn-form" type="submit" name="data-button" class="btn btn-primary mt-4">
                <h1 class="h5 mb-0">click</h1>
            </button>
        </form>

        <form action="form.php" method="post" class="mt-4">
            <h2> Users phones </h2>
            <input id="data-name" name="user" type="text" class="form-control mb-4"></input>
            <input id="data-phone" name="phone" type="text" class="form-control mb-4"></input>
            <input type="checkbox" name="newcheckbox" id="checkbox-2" >
            <button id="btn-form2" type="submit" name="new-data-btn" class="btn btn-primary mt-4">
                <h1 class="h5 mb-0">click</h1>
            </button>
        </form>

    </div>

        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="/scripts/scripts.js"></script> 
        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        -->
    </body>
    </html>