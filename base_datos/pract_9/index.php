<?php
require "src/aux_bd.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD videoclub - Práctica 9</title>
    <style>
        table, th, td {
            border-collapse: collapse;
            border: 1px solid black;
        }
        table {
            width: 80%;
            margin: 0 auto;
        }
        th, td {
            padding: 16px;
            text-align: center;
        }
        .enlace {
            background-color: white;
            border: none;
            color: blue;
            text-decoration: underline;
        }
        img {
            width: 100px;
            height: auto;
        }
        .perfil {
            width: 300px;
        }
    </style>
</head>

<body>
    <h2>Video Club</h2>
    <h3>películas</h3>
    <?php
    if (isset($_POST["btnInsertar"])){
        require "Vistas/insertar.php";
    }
    require "Vistas/tabla.php";
    ?>
    
</body>

</html>