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
    $sql = "CALL all_stock";
    $query = mysqli_query($cnx,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Stock | Ferreteria</title>
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
                    <h1>STOCK</h1>
                    <div class="content-info">
                        <div class="content-action">
                            <div class="content-search">
                                <!--
                                <a class="fa-solid fa-magnifying-glass btn-search" title="Buscar"></a>
                                <input type="text" placeholder="Buscar..." name="" id="" >
                                -->
                            </div>
                            <div class="content-btn">
                                <?php
                                    if($user_rol == "Administrador"){
                                ?>
                                <a href="stockform.php?action=Agregar" class="fa-solid fa-plus" title="Agregar"></a>
                                <?php
                                    }
                                ?>
                                <label for="btn-modal-export" class="fa-regular fa-file-pdf" title="Exportar"></label>
                            </div>
                        </div>
                        <table>
                            <thead>
                                <th>#</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Unidad</th>
                                <th>Proveedor</th>
                                <th>Fecha</th>
                                <th>Compra</th>
                                <th>Venta</th>
                                <?php
                                    if($user_rol == "Administrador"){
                                ?>
                                <th>Acciones</th>
                                <?php
                                    }
                                ?>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 0; 
                                    while ($row = mysqli_fetch_array($query)){
                                        $i++;
                                ?>
                                <tr>
                                    <td class="opacity"><?php echo $i;?></td>
                                    <td data-label="Producto" class="rcab"><?php echo $row['Nom_Producto']?></td>
                                    <td data-label="Cantidad"><?php echo $row['Can_Stock']?></td>
                                    <td data-label="Unidad de medida"><?php echo $row['Unidad']?></td>
                                    <td data-label="Proveedor"><?php echo $row['Nom_Proveedor']?></td>
                                    <td data-label="Fecha de compra"><?php echo $row['Fech_Compra']?></td>
                                    <td data-label="Precio de compra"><?php echo $row['Pre_Compra']?></td>
                                    <td data-label="Pre_Venta"><?php echo $row['Nom_Producto']?></td>
                                    <?php
                                        if($user_rol == "Administrador"){
                                    ?>
                                    <td data-label="Acciones">
                                        <div class="data-action">
                                            <a href="stockform.php?id=<?php echo $row['Id_Stock']?>&action=Modificar" class="fa-solid fa-tags" title="Modificar"></a>
                                            <a href="../php/delete.php?id=<?php echo $row['Id_Stock']?>&table=stock" class="fa-solid fa-trash-can" title="Eliminar"></a>
                                        </div>
                                    </td>
                                    <?php
                                        }
                                    ?>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <input type="checkbox" class="btn-modal" id="btn-modal-export">
                    <div class="modal" id="modal-export">
                        <div class="content-modal">
                            <div class="modal-title">
                                <h5>Generar reporte</h5>
                                <label for="btn-modal-export">X</label>
                            </div>
                            <div class="cont-modal">
                                <h6>GENERAL REPORTE</h6>
                                <form action="reporte.php" method="POST">
                                    <div class="content-input-modal">
                                        <i class="fa-solid fa-calendar-days"></i>
                                        <select name="reporte" class="select-option" required>
                                            <option disabled selected value="">Selecione una unidad de medida</option>
                                            <?php
                                                $cnx = connection();
                                                $consulta = "SELECT Fech_Compra FROM stock GROUP BY Fech_Compra";
                                                $lista = mysqli_query($cnx,$consulta);
                                                while($rows = mysqli_fetch_array($lista)){
                                            ?>
                                            <option value="<?php echo $rows['Fech_Compra'];?>"><?php echo $rows['Fech_Compra'];?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <input type="submit" value="Generar" name="submit-modal">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="../js/main.js" ></script>
    <script src="https://kit.fontawesome.com/529e500c00.js" crossorigin="anonymous"></script>
</body>
</html>