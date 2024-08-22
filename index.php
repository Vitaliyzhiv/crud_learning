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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  </head>
  <body>
    
    <form  action="form.php" method="post">
        <input  id="data-user"name="data" type="text"></input>
        <input id="data-email" name="data-2" type="text"></input>
        <input type="checkbox" name="checkbox" id="checkbox-1" >
        <button id="btn-form" type="submit" name="data-button" >
            <h1>click</h1>  
        </button>
    </form>
    <p class="errors"></p>


    <script>
        // Add js to form.form.php
        $(document).ready(function() {
    $('#btn-form').on('click', function(e) {
        e.preventDefault();  // Отменяем стандартное поведение

        var userName = $('#data-user').val();
        var userEmail = $('#data-email').val();
        var agree = $('#checkbox-1').is(':checked');
        console.log(agree);

        var data = {
            'user': userName,
            'email': userEmail,
            'checkbox': agree,
            'data-button': true
        };


        $.ajax({
            url: 'form.php',
            type: 'POST',
            data: data,
            success: function(response) {
                $('.errors').html(response);
            },
            error: function(jqXHR, exception) {
                if (jqXHR.status === 0) {
                    console.log('Not connect. Verify Network.');
                } else if (jqXHR.status == 404) {
                    console.log('Requested page not found (404).');
                } else if (jqXHR.status == 500) {
                    console.log('Internal Server Error (500).');
                } else if (exception === 'parsererror') {
                    console.log('Requested JSON parse failed.');
                } else if (exception === 'timeout') {
                    console.log('Time out error.');
                } else if (exception === 'abort') {
                    console.log('Ajax request aborted.');
                } else {
                    console.log('Uncaught Error. ' + jqXHR.responseText);
                }
            }
        });
    });
});

    </script>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>