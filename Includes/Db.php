<?php
function db_connect(){
    $dbhost="localhost";
    $dbuser= "root";
    $dbpsw= "";
    $db= "contactbooks";
    $conn= mysqli_connect($dbhost,$dbuser,$dbpsw,$db) or die("Db connection error".mysqli_connect_error());
    return $conn;
}
function db_close($conn){
        mysqli_close($conn);
}

?>