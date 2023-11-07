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
    }
    if(isset($_POST['submit'])){
        $id = $_GET['id'];
        $ruc = $_POST['ruc'];
        $proveedor = ucwords($_POST['proveedor']);
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $direccion = ucwords($_POST['direccion']);
        $contacto = ucwords($_POST['contacto']);
        $cargo = ucwords($_POST['cargo']);
        $celular = $_POST['celular'];
        if($_POST['submit'] == 'Agregar'){
            $sql = "call insert_supplier('$ruc','$proveedor','$contacto','$cargo','$celular','$direccion','$email','$telefono')";
            $query = mysqli_query($cnx,$sql);
            if($query){
                header("location: supplier.php");
            }
            else{
                $error = "<p style='padding: 5px; background: rgba(238, 95, 95, 0.2); margin-bottom: 10px; font-size: 15px; color: red; text-align: center; border-radius: 5px;'><i style='margin-right: 10px;'class='fa-solid fa-circle-exclamation'></i>Error al ejecutar la consulta</p>";
                $action = $_POST['submit'];
            }
        }
        else if($_POST['submit'] == 'Modificar'){
            $sql = "call update_supplier($id,'$ruc','$proveedor','$contacto', '$cargo','$celular','$direccion','$email','$telefono')";
            $query = mysqli_query($cnx,$sql);
            if($query){
                header("location: supplier.php");
            }
            else{
                $error = "<p style='padding: 5px; background: rgba(238, 95, 95, 0.2); margin-bottom: 10px; font-size: 15px; color: red; text-align: center; border-radius: 5px;'><i style='margin-right: 10px;'class='fa-solid fa-circle-exclamation'></i>Error al ejecutar la consulta</p>";
                $action = $_POST['submit'];
            }
        }
    }

    if($action == 'Modificar'){
        $id = $_GET['id'];
        $sql = "SELECT * FROM proveedor WHERE Id_Proveedor = $id";
        $query = mysqli_query($cnx,$sql);
        $row = mysqli_fetch_array($query);
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Información del proveedor | Ferretería</title>
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
                    <h1>INFORMACIÓN DEL PROVEEDOR</h1>
                    <div class="content-info">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?id=<?php if(isset($id)) echo $id;?>" method="POST" id="formulario">
                            <div class="form-input">
                                <div class="formulario-grupo" id="grupo-ruc">
                                    <div class="input-content">
                                        <i class="fa-solid fa-address-card"></i>
                                        <input type="text" name="ruc" value="<?php if(isset($row['Ruc_Proveedor'])) echo $row['Ruc_Proveedor'];?>" placeholder="RUC" maxlength="11" required>
                                        <i class="formulario-validacion-estado fas fa-times-circle"></i>
                                    </div>
                                    <p class="formulario-input-error">El ruc solo debe contener numeros (11 caracteres).</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-proveedor">
                                    <div class="input-content">
                                        <i class="fa-solid fa-building-user"></i>
                                        <input type="text" name="proveedor" value="<?php if(isset($row['Nom_Proveedor'])) echo $row['Nom_Proveedor'];?>" placeholder="Proveedor" required>
                                        <i class="formulario-validacion-estado fas fa-times-circle"></i>
                                    </div>
                                    <p class="formulario-input-error">El proveeedor solo debe contener letras, numeros y espacios</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-telefono">
                                    <div class="input-content">
                                        <i class="fa-solid fa-phone"></i>
                                        <input type="text" name="telefono" value="<?php if(isset($row['Tel_Proveedor'])) echo $row['Tel_Proveedor'];?>" placeholder="Teléfono" maxlength="9" required>
                                        <i class="formulario-validacion-estado fas fa-times-circle"></i>
                                    </div>
                                    <p class="formulario-input-error">el teléfono solo debe contener numeros (De 6 a 9 caracteres).</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-email">
                                    <div class="input-content">
                                        <i class="fa-solid fa-at"></i>
                                        <input type="email" name="email" value="<?php if(isset($row['Email_Proveedor'])) echo $row['Email_Proveedor'];?>" placeholder="Email" required>
                                        <i class="formulario-validacion-estado fas fa-times-circle"></i>
                                    </div>
                                    <p class="formulario-input-error">El correo no aceptado (Formato: example@example.com).</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-direccion">
                                    <div class="input-content">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <input type="text" name="direccion" value="<?php if(isset($row['Dir_Proveedor'])) echo $row['Dir_Proveedor'];?>" placeholder="Dirección" required>
                                        <i class="formulario-validacion-estado fas fa-times-circle"></i>
                                    </div>
                                    <p class="formulario-input-error">la direccion solo debe contener letras y espacios.</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-contacto">
                                    <div class="input-content">
                                        <i class="fa-solid fa-user-secret"></i>
                                        <input type="text" name="contacto" value="<?php if(isset($row['Con_Proveedor'])) echo $row['Con_Proveedor'];?>" placeholder="Contacto" required>
                                        <i class="formulario-validacion-estado fas fa-times-circle"></i>
                                    </div>
                                    <p class="formulario-input-error">El contacto solo debe contener letras y espacios.</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-cargo">
                                    <div class="input-content">
                                        <i class="fa-solid fa-address-book"></i>
                                        <input type="text" name="cargo" value="<?php if(isset($row['Carg_Contacto'])) echo $row['Carg_Contacto'];?>" placeholder="Cargo" required>
                                        <i class="formulario-validacion-estado fas fa-times-circle"></i>
                                    </div>
                                    <p class="formulario-input-error">El cargo solo debe contener letras y espacios.</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-celular">
                                    <div class="input-content">
                                        <i class="fa-solid fa-phone"></i>
                                        <input type="text" name="celular" value="<?php if(isset($row['Tel_Contacto'])) echo $row['Tel_Contacto'];?>" placeholder="Celular" maxlength="9" required>
                                        <i class="formulario-validacion-estado fas fa-times-circle"></i>
                                    </div>
                                    <p class="formulario-input-error">El celular solo debe contener numeros (de 6 a 9 caracteres).</p>
                                </div>
                            </div>
                            <div class="form-action">
                                <input type="submit" value="<?php echo $action; ?>" name="submit">
                                <a href="supplier.php">Volver</a>
                            </div>
                        </form>
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