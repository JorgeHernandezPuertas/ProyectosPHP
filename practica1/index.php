<!DOCTYPE html5>
<html lang="es">
<head>
    <title>Práctica 1 - Formulario</title>
</head>
<body>
    <h2>Rellena tu CV</h2>
    <form  action="index.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre</label><br/>
        <input type="text" id="nombre" name="nombre"/><br/>

        <label for="apellidos">Apellidos</label><br/>
        <input type="text" id="apellidos" name="apellidos" size="50"/><br/>

        <label for="contra">Contraseña</label><br/>
        <input type="password" id="contra" name="contra"/><br/>

        <label for="dni">DNI</label><br/>
        <input type="text" id="dni" name="dni" size="10"/><br/>

        <label>Sexo</label><br/>
        <input type="radio" id="hombre" name="sexo" value="hombre"/> <label for="hombre">Hombre</label><br/>
        <input type="radio" id="mujer" name="sexo" value="mujer"/> <label for="mujer">Mujer</label>

        <p><label for="archivo">Incluir mi foto:</label> <input type="file" id="archivo" name="archivo" accept="image/*" /></p>

        <p><label for="nacido">Nacido en: </label>
            <select id="nacido" name="nacido">
                <option>Málaga</option>
                <option>Sevilla</option>
                <option selected>Granada</option>
            </select>
        </p>

        <p><label for="comentario">Comentarios:</label>
            <textarea id="comentario" name="comentarios"></textarea>
        </p>

        <p><input type="checkbox" name="subscripcion" id="sub" checked/> <label for="sub">Subscribirse al boletín de Novedades</label></p>

        <input type="submit" name="btnEnviar" value="Guardar Cambios"/> <input type="reset" name="btnReset" value="Borrar los datos introducidos"/>
    </form>
</body>
</html>