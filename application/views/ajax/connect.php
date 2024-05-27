<?php
    function getConnectionPqsql() {
        $user = 'postgres';
        $mdp = 'root';
        $dns = 'pgsql:host=localhost;port=5432;dbname=eval_construction';
        try {
            $dbh = new PDO($dns, $user, $mdp);
            return $dbh;
        } catch (PDOException $th) {
            throw $th;
        }
    }
?>
