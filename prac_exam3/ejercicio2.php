<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
</head>

<body>
    <h2>Ejercicio 2. Longitud de las palabras extraídas</h2>
    <form action="ejercicio2.php" method="post">
        <label for="texto">Introduzca un Texto: </label>
        <input type="text" name="texto" id="texto">
        <label for="separador">Elija el Separador: </label>
        <select name="separador" id="separador">
            <option value=";" <?php if (isset($_POST[""])) ?>>;</option>
            <option value="/">/</option>
            <option value=":">:</option>
            <option value=".">.</option>
            <option value=",">,</option>
        </select>
    </form>
</body>

</html>