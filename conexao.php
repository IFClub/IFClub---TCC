<?php

$user = 'root';
$pass = '';


    try {
        $con = new PDO('mysql:host=localhost;dbname=mydb', $user, $pass);
        
    } catch (PDOException $error) {
        echo 'Erro na conexão' . $error->getMessage();
    }

?>