<?php
session_start();
include_once __DIR__ . '/controladores/seguridad.class.php';
$controlador = new Controlador_Seguridad(null,'index.php');

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Sign Up !!!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link  rel="stylesheet"  type="text/css" href="utilerias/css/style-main.css">
    </head>
    <body class="body-login-fondo">
        <div id="estructura-main">
            <header>
                <section class='title'>
                    CLI::WEB DB/2 [AS400] v1.0 
                </section>
                <aside class='logotipo'>
                    <img src="utilerias/img/logo.png">
                </aside>
            </header>
            <section class="container">
                <div class="login">
                    <h1>ACCESO::CLI</h1>
                    <form method="post" action=".">
                        <p><input type="text" name="user" vplaceholder="Usuario"></p>
                        <p><input type="password" name="passw"  placeholder="Password"></p>
                        <p class="submit"><input type="submit" value="Validación"></p>
                    </form>
                </div>
                <?php
                if (!empty($_POST)):
                    echo "<div class='display-error'>";
                    $controlador->__isCorrectAuthentication($controlador->__validateCardOfUser($_POST['user'], $_POST['passw']));
                    echo "</div>";
                endif;
                ?>
            </section>
        </div>
    </body>
</html>
