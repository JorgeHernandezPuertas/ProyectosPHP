<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rellena tu CV</title>
</head>

<body>
    <h1>Rellena tu CV</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="nombre">Nombre:</label><br/>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre..." />
        </p>
        <p>
            <label for="usuario">Usuario:</label><br/>
            <input type="text" id="usuario" name="usuario" placeholder="Usuario..." />
        </p>
        <p>
            <label for="password">Contraseña</label><br/>
            <input type="password" name="password" id="password" placeholder="Contraseña..." />
        </p>
        <p>
            <label for="dni">DNI:</label><br/>
            <input type="text" name="dni" id="dni" placeholder="DNI: 11223344Z" />
        </p>
        <p>
            <label>Sexo:</label><br />
            <input type="radio" name="sexo" value="hombre" id="hombre" />
            <label for="hombre">Hombre</label><br/>
            <input type="radio" name="sexo" value="mujer" id="mujer" />
            <label for="mujer">Mujer</label>
        </p>
        <p>
            <label for="imagen">Incluir mi foto (Archivo de tipo imagen Máx. 500KB): </label>
            <input type="file" name="imagen" id="imagen" />
        </p>
        <p>
            <input type="checkbox" name="sub" id="sub" />
            <label for="sub">Subcribirme al boletín de Novedades.</label>
        </p>
        <input type="submit" value="Guardar cambios" name="btnEnviar" /> 
        <input type="submit" value="Borrar los datos introducidos" name="btnReset" />
    </form>
</body>

</html>