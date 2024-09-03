<?php

require_once 'vendor/autoload.php';

use App\Models\Db;
use App\Templates\Header;
use App\Templates\Footer;
$config = require_once 'config/config.php';

// Create a database connection instance
$db = Db::getInstance()->getConnection($config['db']);

// Select all data from table
$sql = 'SELECT * FROM data_users WHERE checkbox = 1';

// Execute the query
$result = $db->query($sql);

// Find all rows(results)
$emails_data = $result->findAll();

// Renders a header
$header = new header();
$header->render();
?>
        
    <div class="container mt-5">
        <p class="errors"></p>
    <!--  return to main page button -->
    <a href="http://localhost/" class="btn btn-outline-primary w-100">Back to main page</a>
    
    <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th> Actions </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($emails_data as $email): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($email['id']); ?></td>
                            <td><?php echo htmlspecialchars($email['user']); ?></td>
                            <td><?php echo htmlspecialchars($email['email']); ?></td>
                            <td>
                            <a href="?id=<?php echo $email['id']; ?>" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#edit<?php echo $email['id']; ?>">
                                Edit
                            </a>
                                <!-- Delete button -->
                                <a href="?id=<?php echo $email['id'];?>" class="btn btn-danger delete-emails-btn" data-id="<?php echo $email['id'];?>" name="delete">Delete</a>
                            </td>
                        </tr>

                         <!-- Modal Edit -->
                    <div class="modal fade" id="edit<?php echo $email['id']; ?>" tabindex="-1" role="dialog"
                        aria-labelledby="editModalLabel<?php echo $email['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?php echo $email['id']; ?>">Изменить
                                        запись</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="editForm<?php echo $email['id']; ?>">
                                        <!-- No form tag here to prevent default submission -->
                                        <div class="form-group">
                                            <small>Имя</small>
                                            <input type="text" class="form-control" id="name<?php echo 
                                            $email['id']; ?>"
                                                value="<?php echo htmlspecialchars($email['user']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <small>Почта</small>
                                            <input type="text" class="form-control"
                                                id="email<?php echo $email['id']; ?>"
                                                value="<?php echo htmlspecialchars($email['email']); ?>">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Закрыть</button>
                                    <button type="button" class="btn btn-primary"
                                        onclick="submitForm(<?php echo $email['id']; ?>)">Редактировать</button>
                                </div>
                                </form>
                            </div>
                        </div>

                        <script>
                            function submitForm(id) {
                                
                                function validateEmail(email) {
                                    var re = /\S+@\S+\.\S+/;
                                    return re.test(email);
                                }
                                
                                var name = $('#name' + id).val();
                                var email = $('#email' + id).val();
                                
                                    if (!validateEmail(email)) {
                                        alert('Please enter a valid email address.');
                                        return;  
                                    }

                                var data = {
                                    'user': name,
                                    'email': email
                                };

                                $.ajax({
                                    url: 'core/models/form.php',
                                    type: 'POST',
                                    data: {
                                        id: id,
                                        table: 'data_users',
                                        dataTable: JSON.stringify(data),
                                        edit: true
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        console.log(response);
                                        if (response.success) {
                                            $('#name' + id).val(name);
                                            $('#email' + id).val(email);


                                            $('tr').each(function () {
                                                var rowId = $(this).find('td:first').text();
                                                if (rowId == id) {
                                                    $(this).find('td:nth-child(2)').text(name);
                                                    $(this).find('td:nth-child(3)').text(email);
                                                }
                                            });

                                            $('#edit' + id).modal('hide');

                                            alert(response.message);
                                        } else {
                                            alert('Failed to update item');
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        console.log(xhr.responseText);
                                        alert('An error occurred');
                                    }
                                });
                            }
                        </script>


                    </div>
                    <?php endforeach; ?>   
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php
// render footer
$footer = new footer();
$footer->render();