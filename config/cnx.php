<?php
function connection()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "project_atten";

    $cnx = mysqli_connect($host, $user, $pass, $db);

    return $cnx;
}
