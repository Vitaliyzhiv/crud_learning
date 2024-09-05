$(document).ready(function () {

    function showAlertError(message) {
        $('#modalBodyError').text(message);
        $('#alertModalError').modal('show');
    }

    function showAlertSuccess(message) {
        $('#modalBodySuccess').text(message);
        $('#alertModalSuccess').modal('show');
    }

    $('#btn-form2').on('click', function (e) {
        e.preventDefault();  // prevent standard behaviour 

        var userName = $('#data-name').val();
        var userPhone = $('#data-phone').val();
        var agree = $('#checkbox-2').is(':checked'); // no need for ? : since it will be true/false
        console.log('Checkbox 2: ', agree);

        function validatePhone(phone) {
            var re = /^\+?[0-9]{1,12}$/;
            return re.test(phone);
        }

        if (!validatePhone(userPhone)) {
            $('.errors').html('<p style="color: red;">Please enter a valid phone number.</p>');
            return;
        }

        var data = {
            'name': userName,
            'phone': userPhone,
            'checkbox': agree,
            'new-data-btn': true
        };

        console.log('Data to be sent: ', data);


        $.ajax({
            url: 'core/models/form.php',
            type: 'POST',
            data: data,
            success: function (response) {
                $('.errors').html(response);
            },
            error: function (jqXHR, exception) {
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

    $('#btn-form').on('click', function (e) {
        e.preventDefault();  // prevent standard behaviour

        var userName = $('#data-user').val();
        var userEmail = $('#data-email').val();
        var agree = $('#checkbox-1').is(':checked'); // no need for ? : since it will be true/false
        console.log('Checkbox 1: ', agree);

        function validateEmail(email) {
            var re = /\S+@\S+\.\S+/;
            return re.test(email);
        }

        if (!validateEmail(userEmail)) {
            $('.errors').html('<p style="color: red;">Please enter a valid email address.</p>');
            return;
        }

        var data = {
            'name': userName,
            'email': userEmail,
            'checkbox': agree,
            'data-button': true
        };

        console.log('Data to be sent: ', data);

        $.ajax({
            url: 'core/models/form.php',
            type: 'POST',
            data: data,
            success: function (response) {
                $('.errors').html(response);
            },
            error: function (jqXHR, exception) {
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

    $('.delete-phones-btn').on('click', function (event) {
        event.preventDefault();

        var button = $(this);
        var id = button.data('id'); // Get the ID 

        // Confirm before deleting
        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: 'core/models/form.php',
                type: 'POST',
                data: {
                    delete: true,
                    table: 'users_phones',
                    flag: 'checkbox', // the flag column
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Remove the row from the table

                        alert('Item deleted successfully');

                        button.closest('tr').remove();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function () {
                    alert('An error occurred');
                }
            });
        }
    });

    $('.delete-emails-btn').on('click', function (event) {
        event.preventDefault();

        var button = $(this);
        var id = button.data('id'); // Get the ID 

        // Confirm before deleting
        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: 'core/models/form.php',
                type: 'POST',
                data: {
                    delete: true,
                    table: 'data_users',
                    flag: 'checkbox', // the flag column
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {

                        // Remove the row from the table
                        alert('Item deleted successfully');

                        button.closest('tr').remove();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function () {
                    alert('An error occurred');
                }
            });
        }
    });

    $('.calc-btn').on('click', function (e) {
        e.preventDefault();

        // get current btn value
        var btnValue = $(this).val();

        // Insert value to input
        $('.form-calc-input').val(function (index, oldValue) {
            return oldValue + btnValue;
        });

    });

    $('#calc-result').on('click', function (e) {
        e.preventDefault();

        // function validate expression 
        /*
        This function validates that input have only alowed symbols
        */

        // check Math expression
        function validateMathExpression(expression) {

            // check if expression have at least one operator 
            const haveOperator = /[+\-*^/]/;
            
            if (!haveOperator.test(expression)) {
                // add alert
                showAlertError("Expression is not valid:  Math expression should contain at least one operator " + expression);
                return true;
            }

            // first check symbols in expression 
            const regex = /^[0-9+\-*^/.]+$/;

            if (!regex.test(expression)) {
                // add alert
                showAlertError("Expression is not valid for math: " + expression);
                return true;
            }


            // check for numbers starts with 0
            const invalidNumberRegex = /(^|[\+\-^\*\/])0\d+/;

            if (invalidNumberRegex.test(expression)) {
                // add alert 
                showAlertError("Expression is not valid:  Integer type numbers can't start with 0  Your expression: " + expression);

                return true;
            }

            // Check for incorrect consecutive operators
            const invalidOperatorSequenceRegex = /[\+\-^\*\/\.]{2,}/;

            if (invalidOperatorSequenceRegex.test(expression)) {
                // add alert
                showAlertError("Expression is not valid: Expression can`t have consecutive operators " + expression);
          
                return true;
            }

            // Check for decimal numbers 
            const invalidDecimalRegex = /\d+([.,]\d+){2,}/;

            if (invalidDecimalRegex.test(expression)) {
                // add alert
                showAlertError("Expression is not valid:  Incorrect decimal numbers " + expression);
       
                return true;
            }

            // check starts or ends with operatos
            const operatorsStartOrEnd = /^[-+*^/.]|[-+*^/.]$/;

            if (operatorsStartOrEnd.test(expression)) {
                // add alert
                showAlertError("Expression is not valid:  Expression can`t starts or ends with operator " + expression);
               
                return true;
            }

            const divideByZero = /\/0\b(?!\.\d)/;

            if (divideByZero.test(expression)) {
                // add alert
                showAlertError("Expression is not valid:  Division by zero " + expression);
               
                return true;
            }

            // if all checks is completed return false as we don`t have any errors
            return false;
        }


        var calcInput = $('.form-calc-input').val();

        calcInput = calcInput.replace(/\s+/g, '');

        // start check

        if (!validateMathExpression(calcInput)) {
            console.log('Expression is valid');
            $.ajax({
                url: 'core/models/calculator.php',
                type: 'POST',
                data: {
                    expression: calcInput,
                    calc_btn: true
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('.form-calc-result').val(response.result);
                        $('.success').html('<p style="color: green;">' + response.message + '</p>');
                        setTimeout(function () {
                            $('.success').html('');
                        }, 1000);
                    } else {
                        console.log('Error: ' + response.message);
                    }
                },
                error: function (jqXHR, exception) {
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
        }
    });


    $('.btn-reset').on('click', function (e) {
        e.preventDefault();

        var btnValue = $(this).val();

        if (btnValue === 'clear-last') {
            // deletes last symbol from input
            $('.form-calc-input').val(function (index, oldValue) {
                return oldValue.slice(0, -1);
            });
        } else if (btnValue === 'reset') {
            // clears all symbols from input
            $('.form-calc-input').val('');
        }
    });



});
