<?php

require 'config.php';

try {
    $conn = new PDO("mysql:host=". DB_HOST. ";dbname=". DB_DATABASE , DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $err) {
    die("<h1>Database connection failed</h1>" . DB_DATABASE . ": " . $err->getMessage());
}
?>