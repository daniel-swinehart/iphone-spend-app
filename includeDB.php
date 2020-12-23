<?php
    define('USER', 'danielma_daniel');
    define('PASSWORD', 'TRoop12719871990!!');
    define('HOST', 'localhost');
    define('DATABASE', 'danielma_personal_expenses');
    try {
        $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
?>