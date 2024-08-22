<?php

$config = require_once 'config.php';
require_once 'classes/Db.php';

$db = (Db::getInstance())->getConnection($config['db']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['checkbox']) && $_POST['checkbox'] == 'true') {
        $user = isset($_POST['user']);
        $email = isset($_POST['email']);

        if ($user && $email) {
            $query = "INSERT INTO data_users (user, email, checkbox) VALUES (?, ?, ?)";
            $params = [$user, $email, 1];  
            if ($db->query($query, $params)) {
                echo "Data succesfully saved.";
            } else {
                echo "Failed to save data";
            }
        } else {
            echo "Please fill all the fields";
        }
    } else {
        echo "Please agree with terms, press checkbox";
    }
} else {
    echo "Incorrect query";
}

