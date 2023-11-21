<?php
function connection()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "db_17setiembre";

    $cnx = mysqli_connect($host, $user, $pass, $db);

    return $cnx;
}
