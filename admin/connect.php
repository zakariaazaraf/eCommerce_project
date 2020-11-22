<?php


    //CONNECTION TO DATABASE USING PDO EXTENSION

    $dsn = 'mysql:host=localhost;dbname=shop';

    $user = 'root';

    $password = '';

    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    );


    try{

        // TRY CONNECTION TO DATABASE
        $db = new PDO($dsn, $user, $password, $options);

        // SET THE ERROR MODE TO EXCEPTIONS
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // INSERT QUERY
        $q = "insert into users values (NULL,
            'zikovic', '123456789', 'zakariabensalek@gmail.com', 'zakaria azaraf', 0, 0, 0)";

        //INSERT VALUES TO DATABASE
        $db->exec($q);

        echo '<h1>THE CONNECTION WORK WELL !!!!</h1>';

        


    }catch(PDOException $e){

        // TROUGH EXCEPTION ERROR MESSAGE
        echo $e->getMessage();

    }