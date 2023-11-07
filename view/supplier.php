<?php
    session_start();
    if(!$_SESSION['Id_Usuario']){
        session_destroy();
        header("location: login.php");
    }
    $user_nombre = $_SESSION['Nom_Usuario'];
    $user_rol = $_SESSION['Tip_Usuario'];
    
    include("../php/cnx.php");
    $cnx = connection();
    $sql = "SELECT * FROM proveedor";
    $query = mysqli_query($cnx,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Proveedores | Ferretería</title>
</head>
<body>
    <div class="container">
        <?php
            include("../include/sidebar.php");
        ?>
        <main>
            <div class="main-content">
                <?php 
                    include("../include/welcome.php")
                ?>
                <div class="data-info">
                    <h1>PROVEEDORES</h1>
                    <div class="content-info">
                        <div class="content-action">
                            <div class="content-search">
                                <!--
                                <a class="fa-solid fa-magnifying-glass btn-search" title="Buscar"></a>
                                <input type="text" placeholder="Buscar..." name="" id="" >
                                -->
                            </div>
                            <div class="content-btn">
                                <a href="supplierform.php?action=Agregar" class="fa-solid fa-plus" title="Agregar"></a>
                            </div>
                        </div>
                        <table>
                            <thead>
                                <th>#</th>
                                <th>RUC</th>
                                <th>Proveedor</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Dirección</th>
                                <th>Contacto</th>
                                <th>Cargo</th>
                                <th>Celular</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 0; 
                                    while ($row = mysqli_fetch_array($query)){
                                        $i++;
                                ?>
                                <tr>
                                    <td class="opacity"><?php echo $i;?></td>
                                    <td data-label="RUC" class="rcab"><?php echo $row['Ruc_Proveedor'];?></td>
                                    <td data-label="Proveedor"><?php echo $row['Nom_Proveedor'];?></td>
                                    <td data-label="Teléfono"><?php echo $row['Tel_Proveedor'];?></td>
                                    <td data-label="Email"><?php echo $row['Email_Proveedor'];?></td>
                                    <td data-label="Dirección"><?php echo $row['Dir_Proveedor'];?></td>
                                    <td data-label="Contacto"><?php echo $row['Con_Proveedor'];?></td>
                                    <td data-label="Cargo"><?php echo $row['Carg_Contacto'];?></td>
                                    <td data-label="Celular"><?php echo $row['Tel_Contacto'];?></td>
                                    <td data-label="Acciones">
                                        <div class="data-action">
                                            <a href="supplierform.php?id=<?php echo $row['Id_Proveedor'];?>&action=Modificar" class="fa-solid fa-tags" title="Modificar"></a>
                                            <a href="../php/delete.php?id=<?php echo $row['Id_Proveedor'];?>&table=supplier" class="fa-solid fa-trash-can" title="Eliminar"></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="../js/main.js" ></script>
    <script src="https://kit.fontawesome.com/529e500c00.js" crossorigin="anonymous"></script>
</body>
</html>