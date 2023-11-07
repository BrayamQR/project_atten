<?php
    session_start();
    if(!$_SESSION['Id_Usuario']){
        session_destroy();
        header("location: login.php");
    }
    include("cnx.php");
    $cnx = connection();
    $id = $_GET['id'];
    $table = $_GET['table'];

    if($table == 'user'){
        $sql = "DELETE FROM usuario WHERE Id_Usuario = $id";
        $query=mysqli_query($cnx,$sql);
        if($query){
            header("location: ../src/user.php");
        }
    }
    else if($table == 'product'){
        $sql = "DELETE FROM producto WHERE Id_Producto = $id";
        $query=mysqli_query($cnx,$sql);
        if($query){
            header("location: ../src/product.php");
        }
    }
    else if($table == 'stock'){
        $sql = "DELETE FROM stock WHERE Id_Stock = $id";
        $query=mysqli_query($cnx,$sql);
        if($query){
            header("location: ../src/stock.php");
        }
    }
    else if($table == 'supplier'){
        $sql = "DELETE FROM proveedor WHERE Id_Proveedor = $id";
        $query=mysqli_query($cnx,$sql);
        if($query){
            header("location: ../src/supplier.php");
        }
    }
?>