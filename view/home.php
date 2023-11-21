<?php
include('../config/session.php')
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/logo.png">
    <link rel="stylesheet" href="../css/style.css">
    <title>Colégio 17 Setiembre</title>
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
                </div>
            </div>
        </main>
    </div>
</body>
<?php
include("../config/global_script.php");
?>

</html>