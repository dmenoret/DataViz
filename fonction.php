<?php
        $db = new mysqli('localhost', 'id21662321_root', '04Roots.', 'id21662321_dataviz');
        if ($db->connect_error) {
            echo 'bad co';
            die("échec de la connexion à la base de données:".$conn->connect_error);
        }
?>