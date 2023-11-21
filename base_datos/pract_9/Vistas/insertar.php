<form action="index.php" method="post" >
    <p>
        <label for="titulo">Título: </label>
        <input type="text" name="titulo" id="titulo">
    </p>
    <p>
        <label for="director">Director: </label>
        <input type="text" name="director" id="director" >
    </p>
    <p>
        <label for="sinopsis">Sinopsis:</label>
        <textarea name="sinopsis" id="sinopsis" cols="20" rows="5"></textarea>
    </p>
    <p>
        <label for="tematica">Temática</label>
        <input type="text" name="tematica" id="tematica" >
    </p>
    <p>
        <label for="caratula">Carátula: </label>
        <input type="file" name="caratula" id="caratula" accept="image/*" >
    </p>
    <button>Insertar</button> <button>Atrás</button>
</form>