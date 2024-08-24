$(document).ready(function() {
    $('#btn-form2').on('click', function(e) {
        e.preventDefault();  // prevent standard behaviour 

        var userName = $('#data-name').val();
        var userPhone = $('#data-phone').val();
        var agree = $('#checkbox-2').is(':checked'); // no need for ? : since it will be true/false
        console.log('Checkbox 2: ', agree);

        var data = {
            'user': userName,
            'phone': userPhone,
            'checkbox': agree,
            'new-data-btn': true
        };

        console.log('Data to be sent: ', data);

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

    $('#btn-form').on('click', function(e) {
        e.preventDefault();  // prevent standard behaviour

        var userName = $('#data-user').val();
        var userEmail = $('#data-email').val();
        var agree = $('#checkbox-1').is(':checked'); // no need for ? : since it will be true/false
        console.log('Checkbox 1: ', agree);

        var data = {
            'user': userName,
            'email': userEmail,
            'checkbox': agree,
            'data-button': true
        };

        console.log('Data to be sent: ', data);

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

   $('.delete-phones-btn').on('click', function(event) {
        event.preventDefault();

        var button = $(this);
        var id = button.data('id'); // Get the ID 

        // Confirm before deleting
        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: 'form.php',
                type: 'POST',
                data: {
                    delete: true,
                    table: 'users_phones',  
                    flag: 'checkbox', // the flag column
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Remove the row from the table

                        alert('Item deleted successfully');

                        button.closest('tr').remove();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred');
                }
            });
        }
    }); 

   $('.delete-emails-btn').on('click', function(event) {
        event.preventDefault();

        var button = $(this);
        var id = button.data('id'); // Get the ID 

        // Confirm before deleting
        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: 'form.php',
                type: 'POST',
                data: {
                    delete: true,
                    table: 'data_users',  
                    flag: 'checkbox', // the flag column
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        
                        // Remove the row from the table
                        alert('Item deleted successfully');

                        button.closest('tr').remove();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred');
                }
            });
        }
    }); 


});
