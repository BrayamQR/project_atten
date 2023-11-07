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
    if(isset($_GET['action'])){
        $action = $_GET['action'];
        if($action == 'Modificar'){
            $id = $_GET['id'];
            $sqll = "SELECT Can_Stock, Fech_Compra, Pre_Compra, Pre_Venta FROM stock WHERE Id_Stock = $id";
            $queryy = mysqli_query($cnx,$sqll);
            $rows = mysqli_fetch_array($queryy);
        }
    }
    if(isset($_POST['submit-modal'])){
        $action = $_GET['action'];
        $unidad = ucwords($_POST['unidad']);
        $sql = "INSERT INTO unidad(Unidad) VALUES ('$unidad')";
        $query = mysqli_query($cnx,$sql);
        if($query){
            if($action == 'Agregar'){
                header("location: stockform.php?action=$action");
            }
            else{
                $id = $_GET['id'];
                header("location: stockform.php?id=$id&action=$action");
            }
        }
        else{
            $error = "<p style='padding: 5px; background: rgba(238, 95, 95, 0.2); margin-bottom: 10px; font-size: 15px; color: red; text-align: center; border-radius: 5px;'><i style='margin-right: 10px;'class='fa-solid fa-circle-exclamation'></i>Error al ejecutar la consulta</p>";
            $action = $_GET['action'];
        }
    }
    if(isset($_POST['submit'])){
        $id = $_GET['id'];
        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];
        $unidad = $_POST['unidad'];
        $proveedor =$_POST['proveedor'];
        $fecha = $_POST['fecha'];
        $compra = $_POST['compra'];
        $venta = $_POST['venta'];
        if($_POST['submit'] == 'Agregar'){
            $sql = "call insert_stock($cantidad,'$fecha',$compra,$venta,$unidad,$proveedor,$producto)";
            $query = mysqli_query($cnx,$sql);
            if($query){
                header("location: stock.php");
            }
            else{
                $error = "<p style='padding: 5px; background: rgba(238, 95, 95, 0.2); margin-bottom: 10px; font-size: 15px; color: red; text-align: center; border-radius: 5px;'><i style='margin-right: 10px;'class='fa-solid fa-circle-exclamation'></i>Error al ejecutar la consulta</p>";
                $action = $_POST['submit'];
            }
        }
        if($_POST['submit'] == 'Modificar'){
            $sql = "call update_stock($id,$cantidad,'$fecha',$compra,$venta,$unidad,$proveedor,$producto)";
            $query = mysqli_query($cnx,$sql);
            if($query){
                header("location: stock.php");
            }
            else{
                $error = "<p style='padding: 5px; background: rgba(238, 95, 95, 0.2); margin-bottom: 10px; font-size: 15px; color: red; text-align: center; border-radius: 5px;'><i style='margin-right: 10px;'class='fa-solid fa-circle-exclamation'></i>Error al ejecutar la consulta</p>";
                $action = $_POST['submit'];
            }
        }
    }
    if(isset($_GET['ruta'])){
        if($_GET['ruta'] == "modal"){
            $id = $_GET['id'];
            $action = $_GET['action'];
            $sql = "DELETE FROM unidad WHERE Id_Unidad = $id";
            $query = mysqli_query($cnx,$sql);
            if(!$query){
                $error = "<p style='padding: 5px; background: rgba(238, 95, 95, 0.2); margin-bottom: 10px; font-size: 15px; color: red; text-align: center; border-radius: 5px;'><i style='margin-right: 10px;'class='fa-solid fa-circle-exclamation'></i>Error al ejecutar la consulta</p>";
            }
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Información del stock | Ferretería</title>
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
                <?php if(isset($error)) echo $error; ?>
                <div class="data-info">
                    <h1>INFORMACIÓN DEL STOCK</h1>
                    <div class="content-info">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?id=<?php if(isset($id)) echo $id;?>" method="POST" id="formulario">
                            <div class="form-input">
                                <div class="formulario-grupo grupo-select" id="grupo-producto">
                                    <div class="input-content input-select select-add">
                                        <i class="fa-solid fa-toolbox"></i>
                                        <select name="producto" class="select-option" required>
                                            <?php
                                                if($action == 'Agregar'){
                                            ?>
                                            <option disabled selected value="">Selecione un producto</option>
                                            <?php
                                                }else{
                                                $sql ="SELECT producto.Id_Producto,producto.Nom_Producto FROM stock INNER JOIN producto ON stock.Id_Producto=producto.Id_Producto WHERE stock.Id_Stock = $id";
                                                $query = mysqli_query($cnx,$sql);
                                                $row = mysqli_fetch_array($query);
                                            ?>
                                            <option selected value="<?php echo $row['Id_Producto']; ?>"><?php echo $row['Nom_Producto']; ?></option>
                                            <?php
                                                }
                                                $sql = "SELECT Id_Producto, Nom_Producto FROM producto";
                                                $query = mysqli_query($cnx,$sql);
                                                while($row = mysqli_fetch_array($query)){
                                            ?>
                                            <option value = "<?php echo $row['Id_Producto'];?>"><?php echo $row['Nom_Producto'];?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="select-action">
                                        <a href="product.php" class="fa-solid fa-magnifying-glass label-search" title="Mostrar productos"></a>
                                        <a href="productform.php?action=Agregar" class="fa-solid fa-plus label-add" title="Agregar producto"></a>
                                    </div>
                                </div>
                                <div class="formulario-grupo" id="grupo-cantidad">
                                    <div class="input-content">
                                        <i class="fa-solid fa-cart-flatbed-suitcase"></i>
                                        <input type="text" name="cantidad" placeholder="Cantidad" value="<?php if(isset($rows['Can_Stock'])) echo $rows['Can_Stock'];?>" maxlength="5" required>
                                        <i class="formulario-validacion-estado fas fa-times-circle"></i>
                                    </div>
                                    <p class="formulario-input-error">la cantidad solo debe contener numeros (De 1 a 5 caracteres)</p>
                                </div>
                                <div class="formulario-grupo grupo-select" id="grupo-unidad">
                                    <div class="input-content input-select select-add">
                                        <i class="fa-solid fa-scale-balanced"></i>
                                        <select name="unidad" class="select-option" required>
                                            <?php
                                                if($action == 'Agregar'){
                                            ?>
                                            <option disabled selected value="">Selecione una unidad de medida</option>
                                            <?php
                                                }else{
                                                $sql ="SELECT unidad.Id_Unidad,unidad.Unidad FROM stock INNER JOIN unidad ON stock.Id_Unidad=unidad.Id_Unidad WHERE stock.Id_Stock = $id";
                                                $query = mysqli_query($cnx,$sql);
                                                $row = mysqli_fetch_array($query);
                                            ?>
                                            <option selected value ="<?php echo $row['Id_Unidad']; ?>"><?php echo $row['Unidad']; ?></option>
                                            <?php
                                                }
                                                $sql = "SELECT * FROM unidad";
                                                $query = mysqli_query($cnx,$sql);
                                                while($row = mysqli_fetch_array($query)){
                                            ?>
                                            <option value="<?php echo $row['Id_Unidad'];?>"><?php echo $row['Unidad'];?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="select-action">
                                        <label for="btn-modal-mostrar" class="fa-solid fa-magnifying-glass label-search" title="Mostrar unidades"></label>
                                        <label for="btn-modal-add" class="fa-solid fa-plus label-add" title="Agregar unidad"></label>
                                    </div>
                                </div>
                                <div class="formulario-grupo grupo-select" id="grupo-proveedor">
                                    <div class="input-content input-select select-add">
                                        <i class="fa-solid fa-building-user"></i>
                                        <select name="proveedor" class="select-option" required>
                                            <?php
                                                if($action == 'Agregar'){
                                            ?>
                                            <option disabled selected value="">Selecione un proveedor</option>
                                            <?php
                                                }else{
                                                $sql ="SELECT proveedor.Id_Proveedor, proveedor.Nom_Proveedor FROM stock INNER JOIN proveedor ON stock.Id_Proveedor = proveedor.Id_Proveedor WHERE stock.Id_Stock = $id";
                                                $query = mysqli_query($cnx,$sql);
                                                $row = mysqli_fetch_array($query);
                                            ?>
                                            <option selected value="<?php echo $row['Id_Proveedor']; ?>"><?php echo $row['Nom_Proveedor']; ?></option>
                                            <?php
                                                }
                                                $sql = "SELECT Id_Proveedor,Nom_Proveedor FROM proveedor";
                                                $query = mysqli_query($cnx,$sql);
                                                while($row = mysqli_fetch_array($query)){
                                            ?>
                                            <option value="<?php echo $row['Id_Proveedor'];?>"><?php echo $row['Nom_Proveedor'];?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="select-action">
                                        <a href="supplier.php" class="fa-solid fa-magnifying-glass label-search" title="Mostrar proveedores"></a>
                                        <a href="supplierform.php?action=Agregar" class="fa-solid fa-plus label-add" title="Agregar proveedor"></a>
                                    </div>
                                </div>
                                <div class="formulario-grupo" id="grupo-fecha">
                                    <div class="input-content">
                                        <i class="fa-solid fa-calendar-days"></i>
                                        <input type="date" name="fecha" placeholder="Fecha de compra" value="<?php if(isset($rows['Fech_Compra'])) echo $rows['Fech_Compra'];?>" required>
                                    </div>
                                </div>
                                <div class="formulario-grupo" id="grupo-compra">
                                    <div class="input-content">
                                        <i class="fa-solid fa-sack-dollar"></i>
                                        <input type="text" name="compra" placeholder="Precio de compra" value="<?php if(isset($rows['Pre_Compra'])) echo $rows['Pre_Compra'];?>" maxlength="7" required>
                                        <i class="formulario-validacion-estado fas fa-times-circle"></i>
                                    </div>
                                    <p class="formulario-input-error">El precio de compra solo debe contener numeros (7 caracteres, maximo 2 decimales)</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-venta">
                                    <div class="input-content">
                                        <i class="fa-solid fa-sack-dollar"></i>
                                        <input type="text" name="venta" placeholder="Precio de venta" value="<?php if(isset($rows['Pre_Venta'])) echo $rows['Pre_Venta'];?>" maxlength="7" required>
                                        <i class="formulario-validacion-estado fas fa-times-circle"></i>
                                    </div>
                                    <p class="formulario-input-error">El precio de venta solo debe contener numeros (7 caracteres, maximo 2 decimales)</p>
                                </div>
                            </div>
                            <div class="form-action">
                                <input type="submit" value="<?php echo $action; ?>" name="submit">
                                <a href="stock.php">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
                <input type="checkbox" class="btn-modal" id="btn-modal-add">
                <div class="modal" id="modal-add">
                    <div class="content-modal">
                        <div class="modal-title">
                            <h5>Agregar unidad</h5>
                            <label for="btn-modal-add">X</label>
                        </div>
                        <div class="cont-modal">
                            <?php
                                if($action == 'Agregar'){
                            ?>
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?action=<?php echo $action;?>" method="POST">
                            <?php
                                }else{
                            ?>
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?id=<?php echo $id?>&action=<?php echo $action;?>" method="POST">
                            <?php
                                }
                            ?>
                                <div class="content-input-modal">
                                    <i class="fa-solid fa-scale-balanced"></i>
                                    <input type="text" name="unidad" placeholder="Unidad de medida">
                                </div>
                                <input type="submit" value="Ejecutar" name="submit-modal">
                            </form>
                        </div>
                    </div>
                </div>
                <input type="checkbox" class="btn-modal" id="btn-modal-mostrar">
                <div class="modal" id="modal-mostrar">
                    <div class="content-modal">
                        <div class="modal-title">
                            <h5>Listado de unidades</h5>
                            <label for="btn-modal-mostrar">X</label>
                        </div>
                        <div class="cont-modal">
                            <h6>LISTADO DE UNIDADES</h6>
                            <div class="table-modal">
                                <table>
                                    <thead>
                                        <th>#</th>
                                        <th>Unidad de medida</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $cnx = connection();
                                            $sql = "SELECT * FROM unidad";
                                            $query = mysqli_query($cnx,$sql);
                                            $i = 0;
                                            while($row = mysqli_fetch_array($query)){
                                                $i++;
                                        ?>
                                        <tr>
                                            <td class="opacity"><?php echo $i; ?></td>
                                            <td data-label="Categoría" class="rcab"><?php echo $row['Unidad']; ?></td>
                                            <td data-label="Acciones">
                                                <div class="data-action">
                                                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?id=<?php echo $row['Id_Unidad']?>&ruta=modal&action=<?php echo $action?>" class="fa-solid fa-trash-can" title="Eliminar"></a>
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
                </div>
            </div>
        </main>
    </div>
    <script src="../js/main.js" ></script>
    <script src="../js/validform.js"></script>
    <script src="https://kit.fontawesome.com/529e500c00.js" crossorigin="anonymous"></script>
</body>
</html>