<?php
session_start();
if (!$_SESSION['Id_Usuario']) {
    session_destroy();
    header("location: login.php");
}
$user_nombre = $_SESSION['Nom_Usuario'];
$user_rol = $_SESSION['Tip_Usuario'];

include("../php/cnx.php");
$cnx = connection();
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if (isset($_POST['submit-modal'])) {
    $action = $_GET['action'];
    $categoria = ucwords($_POST['categoria']);
    $sql = "INSERT INTO categoria(Categoria) VALUES ('$categoria')";
    $query = mysqli_query($cnx, $sql);
    if ($query) {
        if ($action == 'Agregar') {
            header("location: productform.php?action=$action");
        } else {
            $id = $_GET['id'];
            header("location: productform.php?id=$id&action=$action");
        }
    } else {
        $error = "<p style='padding: 5px; background: rgba(238, 95, 95, 0.2); margin-bottom: 10px; font-size: 15px; color: red; text-align: center; border-radius: 5px;'><i style='margin-right: 10px;'class='fa-solid fa-circle-exclamation'></i>Error al ejecutar la consulta</p>";
        $action = $_GET['action'];
    }
}
if (isset($_POST['submit'])) {
    $id = $_GET['id'];
    $codigo = strtoupper($_POST['codigo']);
    $producto = ucwords($_POST['producto']);
    $categoria = $_POST['categoria'];
    $marca = ucwords($_POST['marca']);
    if ($_POST['submit'] == 'Agregar') {
        $sql = "call insert_product('$codigo','$producto',$categoria,'$marca')";
        $query = mysqli_query($cnx, $sql);
        if ($query) {
            header("location: product.php");
        } else {
            $error = "<p style='padding: 5px; background: rgba(238, 95, 95, 0.2); margin-bottom: 10px; font-size: 15px; color: red; text-align: center; border-radius: 5px;'><i style='margin-right: 10px;'class='fa-solid fa-circle-exclamation'></i>Error al ejecutar la consulta</p>";
            $action = $_POST['submit'];
        }
    } else if ($_POST['submit'] == 'Modificar') {
        $sql = "call update_product($id,'$codigo','$producto',$categoria,'$marca')";
        $query = mysqli_query($cnx, $sql);
        if ($query) {
            header("location: product.php");
        } else {
            $error = "<p style='padding: 5px; background: rgba(238, 95, 95, 0.2); margin-bottom: 10px; font-size: 15px; color: red; text-align: center; border-radius: 5px;'><i style='margin-right: 10px;'class='fa-solid fa-circle-exclamation'></i>Error al ejecutar la consulta</p>";
            $action = $_POST['submit'];
        }
    }
}
if ($action == 'Modificar') {
    $id = $_GET['id'];
    $sql = "SELECT producto.Id_Producto,producto.Cod_Producto,producto.Nom_Producto,producto.Mar_Producto,categoria.Id_Categoria,categoria.Categoria FROM producto INNER JOIN categoria ON producto.Id_Categoria = categoria.Id_Categoria WHERE producto.Id_Producto = $id";
    $query = mysqli_query($cnx, $sql);
    $row = mysqli_fetch_array($query);
}
if (isset($_GET['ruta'])) {
    if ($_GET['ruta'] == "modal") {
        $id = $_GET['id'];
        $action = $_GET['action'];
        $sql = "DELETE FROM categoria WHERE Id_Categoria = $id";
        $query = mysqli_query($cnx, $sql);
        if (!$query) {
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
    <title>Información del producto | Ferretería</title>
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
                <?php if (isset($error)) echo $error; ?>
                <div class="data-info">
                    <h1>INFORMACIÓN DEL PRODUCTO</h1>
                    <div class="content-info">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php if (isset($id)) echo $id; ?>" method="POST" id="formulario">
                            <div class="form-input">
                                <div class="formulario-grupo" id="grupo-codigo">
                                    <div class="input-content">
                                        <i class="fa-solid fa-book"></i>
                                        <input type="text" name="codigo" placeholder="Código" value="<?php if (isset($row['Cod_Producto'])) echo $row['Cod_Producto']; ?>" maxlength="6" required>
                                        <i class="formulario-validacion-estado fas fa-times-circle"></i>
                                    </div>
                                    <p class="formulario-input-error">El código solo debe contener numeros y letras (6 caracteres)</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-producto">
                                    <div class="input-content">
                                        <i class="fa-solid fa-toolbox"></i>
                                        <input type="text" name="producto" placeholder="Producto" value="<?php if (isset($row['Nom_Producto'])) echo $row['Nom_Producto']; ?>" required>
                                        <i class="formulario-validacion-estado fas fa-times-circle"></i>
                                    </div>
                                    <p class="formulario-input-error">El nombre solo puede contener letras, numeros, espacios y /.</p>
                                </div>
                                <div class="formulario-grupo grupo-select" id="grupo-categoria">
                                    <div class="input-content input-select select-add">
                                        <i class="fa-solid fa-screwdriver-wrench"></i>
                                        <select name="categoria" class="select-option" required>
                                            <?php
                                            if ($action == 'Agregar') {
                                            ?>
                                                <option disabled selected value="">Selecione una categoria</option>
                                            <?php
                                            } else {
                                            ?>
                                                <option selected value="<?php echo $row['Id_Categoria']; ?>"><?php echo $row['Categoria']; ?></option>
                                            <?php
                                            }
                                            $sql = "SELECT * FROM categoria;";
                                            $query = mysqli_query($cnx, $sql);
                                            while ($rows = mysqli_fetch_array($query)) {
                                            ?>
                                                <option value="<?php echo $rows['Id_Categoria']; ?>"><?php echo $rows['Categoria']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="select-action">
                                        <label for="btn-modal-mostrar" class="fa-solid fa-magnifying-glass label-search" title="Mostrar categorías"></label>

                                        <label for="btn-modal-add" class="fa-solid fa-plus label-add" title="Agregar categoría"></label>
                                    </div>
                                </div>
                                <div class="formulario-grupo" id="grupo-marca">
                                    <div class="input-content">
                                        <i class="fa-solid fa-language"></i>
                                        <input type="text" name="marca" placeholder="Marca" value="<?php if (isset($row['Mar_Producto'])) echo $row['Mar_Producto']; ?>" required>
                                        <i class="formulario-validacion-estado fas fa-times-circle"></i>
                                    </div>
                                    <p class="formulario-input-error">La marca solo debe contener letras, espacios y numeros.</p>
                                </div>
                            </div>
                            <div class="form-action">
                                <input type="submit" value="<?php echo $action; ?>" name="submit">
                                <a href="product.php">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
                <input type="checkbox" class="btn-modal" id="btn-modal-add">
                <div class="modal" id="modal-add">
                    <div class="content-modal">
                        <div class="modal-title">
                            <h5>Agregar categoría</h5>
                            <label for="btn-modal-add">X</label>
                        </div>
                        <div class="cont-modal">
                            <h6>AGREGAR CATEGORÍA</h6>
                            <?php
                            if ($action == 'Agregar') {

                            ?>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?action=<?php echo $action; ?>" method="POST">
                                <?php
                            } else {
                                ?>
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $id ?>&action=<?php echo $action; ?>" method="POST">
                                    <?php
                                }
                                    ?>
                                    <div class="content-input-modal">
                                        <i class="fa-solid fa-screwdriver-wrench"></i>
                                        <input type="text" name="categoria" placeholder="Categoría">
                                    </div>
                                    <input type="submit" value="Registrar" name="submit-modal">
                                    </form>
                        </div>
                    </div>
                </div>

                <input type="checkbox" class="btn-modal" id="btn-modal-mostrar">
                <div class="modal" id="modal-mostrar">
                    <div class="content-modal">
                        <div class="modal-title">
                            <h5>Listado de categorías</h5>
                            <label for="btn-modal-mostrar">X</label>
                        </div>
                        <div class="cont-modal">
                            <h6>LISTADO DE CATEGORÍAS</h6>
                            <div class="table-modal">
                                <table>
                                    <thead>
                                        <th>#</th>
                                        <th>Categoria</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cnx = connection();
                                        $sql = "SELECT * FROM categoria";
                                        $query = mysqli_query($cnx, $sql);
                                        $i = 0;
                                        while ($row = mysqli_fetch_array($query)) {
                                            $i++;
                                        ?>
                                            <tr>
                                                <td class="opacity"><?php echo $i; ?></td>
                                                <td data-label="Categoría" class="rcab"><?php echo $row['Categoria']; ?></td>
                                                <td data-label="Acciones">
                                                    <div class="data-action">
                                                        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $row['Id_Categoria'] ?>&ruta=modal&action=<?php echo $action ?>" class="fa-solid fa-trash-can" title="Eliminar"></a>
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
    <script src="../js/main.js"></script>
    <script src="../js/validform.js"></script>
    <script src="https://kit.fontawesome.com/529e500c00.js" crossorigin="anonymous"></script>
</body>

</html>