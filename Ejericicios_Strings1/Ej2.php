<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
    <style>
    #cajaForm {background-color: lightblue;border: 1px solid black;margin-bottom: 10px;padding:10px} 
    #cajaRes1 {background-color: lightgreen;border: 1px solid black;padding:10px} 
    h2 {text-align: center;}
    </style>
</head>
<body>
    <div id="cajaForm">
    <h2>Palíndromos / capícuas - Formulario</h2>
    <form action="Ej2.php" method="post" enctype="multipart/form-data">
    <p>Dime una palabra o un número y te diré si es un palíndromo o un número capicúa.</p>
    <p>
        <label for="p1">Palabra o número: </label> <input type="text" name="p1" id="p1" />
    </p>
    
    <p><input type="submit" value="Comprobar" name="btnEnviar" /></p>
    </form>
    </div>
    
    
    <?php
        if (isset($_POST["btnEnviar"])){
            ?>
            <div id="cajaRes1">
            <h2>Palíndromos / capícuas - Resultado</h2>
            <?php
                $str = trim($_POST["p1"]);
                if ($_POST["p1"] == ""){
                    echo "<p>No has puesto nada.</p>";
                } else if (substr($_POST["p1"], 0, floor((strlen($_POST["p1"]) - 1) / 2)) == substr($_POST["p1"], -floor((strlen($_POST["p1"]) - 1) / 2))){
                    echo "<p>".$_POST["p1"]." es un palíndromo.</p>";
                } else {
                    echo "<p>".$_POST["p1"]." no es un palíndromo.</p>";
                }
            ?>
            </div>
            <?php
        } 
    ?>
    

</body>
</html>