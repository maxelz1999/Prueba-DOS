<?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "poleras";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
    else{
        $conn->query("SET NAMES 'utf8'");        
        return $conn;
    } 

?>