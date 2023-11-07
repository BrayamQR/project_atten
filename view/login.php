<?php
session_start();
include("../config/cnx.php");
$cnx = connection();
if (isset($_POST['submit'])) {
    $user = $_POST['user'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM usuario INNER JOIN tipousuario ON usuario.Id_TipoUsuario = tipousuario.Id_TipoUsuario WHERE User_Usuario = '$user' AND Pass_Usuario = '$password'";
    $query = mysqli_query($cnx, $sql);

    if ($row = mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
        $_SESSION['Id_Usuario'] = $row['Id_Usuario'];
        $_SESSION['Nom_Usuario'] = $row['Nom_Usuario'];
        $_SESSION['Desc_TipoUsuario'] = $row['Desc_TipoUsuario'];
        header("location: home.php");
    } else {
        $error = "<p style='padding: 5px; background: rgba(238, 95, 95, 0.2); margin-bottom: 10px; font-size: 15px; color: red; text-align: center; border-radius: 5px;'><i style='margin-right: 10px;'class='fa-solid fa-circle-exclamation'></i>Usuario o contraseña incorrectos</p>";
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
    <title>Iniciar Sesión | Ferretería</title>
</head>

<body>
    <div class="container-login">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <h2>INICIAR SESIÓN</h2>
            <div class="content-login-input">
                <i class="fa-solid fa-user-shield"></i>
                <input type="text" name="user" placeholder="Usuario" value="<?php if (isset($user)) echo $user; ?>" required>
            </div>
            <div class="content-login-input">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="password" placeholder="Contraseña" value="<?php if (isset($password)) echo $password; ?>" required>
            </div>
            <?php if (isset($error)) echo $error ?>
            <div class="content-login-action">
                <input type="submit" value="Ingresar" name="submit">
            </div>

        </form>
    </div>
    <script src="https://kit.fontawesome.com/529e500c00.js" crossorigin="anonymous"></script>
</body>

</html>