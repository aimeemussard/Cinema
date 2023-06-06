<?php
    try{
        //connexion à la base de données
        $dsn = 'mysql:dbname=cinema;port=3306;host=127.0.0.1';
        $user = 'aimeemussard';
        $password = 'dididu974';
        $database = new PDO($dsn, $user, $password);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
?>