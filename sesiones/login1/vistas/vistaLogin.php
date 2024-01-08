
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Login</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h2>PRIMER LOGIN</h2>

    <form action="index.php" method="post">
    <p>
        <label for="user">Usuario: </label><input type="text" name="user" id="user" placeholder="Usuario..." value="<?php if (isset($_POST["btnLogin"])) print $_POST["user"] ?>">
        <?php
        if (isset($_POST["btnLogin"]) && $error_form) {
            if ($_POST["user"] == "") {
                print "<span class='error'> * Campo vacío * </span>";
            } else if (isset($_SESSION["userMal"])) {
                print "<span class='error'> * " . $_SESSION["userMal"] . " * </span>";
                session_destroy();
            }
        }
        ?>
    </p>
    <p>
        <label for="psw">Contraseña: </label><input type="password" name="psw" id="psw" placeholder="Contraseña...">
        <?php
        if (isset($_POST["btnLogin"]) && $error_form) {
            if ($_POST["psw"] == "") {
                print "<span class='error'> * Campo vacío * </span>";
            } else if (isset($_SESSION["pswMal"])) {
                print "<span class='error'> * " . $_SESSION["pswMal"] . " * </span>";
                session_destroy();
            }
        }
        ?>
    </p>
    <button name="btnLogin">Log in</button>
</form>
</body>

</html>