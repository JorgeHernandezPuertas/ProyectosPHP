const DIR_SERV = "http://localhost/Proyectos/js-php/tarea1/servicios/servicios_rest"

// Vamos a hacer la tabla con los productos
function obtener_productos () {
  $.ajax({
    url: DIR_SERV + "/productos",
    dataType: "json",
    type: "GET",
  }).done(function (data) {
    if (data.mensaje_error) {
      $("#respuesta").html(data.mensaje_error)
    } else {

      // Vamos a crear una tabla con los productos
      let tabla_productos = "<table>"
      tabla_productos += `<tr><th>COD</th><th>Nombre corto</th><th>PVP</th><th><button class='enlace' onclick='nuevoProducto()'>Producto +</button></th></tr>`

      // Recorremos el json
      $.each(data.productos, function (key, tupla) {
        tabla_productos += "<tr>"
        tabla_productos += `<td><button class='enlace' onclick='obtener_detalles("${tupla.cod}")'>  ${tupla.cod}  </button></td>`
        tabla_productos += "<td>" + tupla["nombre_corto"] + "</td>"
        tabla_productos += "<td>" + tupla["PVP"] + "</td>"
        tabla_productos += `<td><button class='enlace' onclick='crearFormEditar("${tupla.cod}")'>Editar</button> - <button class='enlace' onclick='eliminarProducto("${tupla.cod}")'>Borrar</button></td>`
        tabla_productos += "</tr>"
      });
      tabla_productos += "</table>"
      $("#respuesta").html(tabla_productos);
    }
  })
}

function editarProducto (cod) {

}

function eliminarProducto (cod) {
  resetHtml()
  $.ajax({
    url: `${DIR_SERV}/producto/borrar/${cod}`,
    dataType: 'json',
    type: 'delete'
  }).done(function (data) {
    if (data.mensaje_error) {
      $("#acciones").html(data.mensaje_error)
    } else {
      $("#acciones").html(`<p class='mensaje' >El producto con código ${cod} se ha borrado con éxito</p>`)
      obtener_productos()
    }
  })
}

async function nuevoProducto () {
  resetHtml()
  let formulario = `<form onsubmit='crearProducto(event)' method='post' action='.'>
                    <h2>Añadir un producto</h2>
                    <p>
                      <label for='cod'><strong>Código: </strong></label><input type='text' name='cod' id='cod' required />
                      <span class='error'></span>
                    </p>
                    <p>
                      <label for='nombre'><strong>Nombre: </strong></label><input type='text' name='nombre' id='nombre' />
                      <span class='error'></span>
                    </p>
                    <p>
                      <label for='nombre_corto'><strong>Nombre corto: </strong></label><input type='text' name='nombre_corto' id='nombre_corto' required/>
                      <span class='error'></span>
                    </p>
                    <p>
                      <label for='descripcion'><strong>Descripción: </strong></label><textarea name='descripcion' id='descripcion' required ></textarea>
                      <span class='error'></span>
                    </p>
                    <p>
                      <label for='PVP'><strong>PVP: </strong></label><input type='number' name='PVP' id='PVP' required />
                      <span class='error'></span>
                    </p>
  `
  // añado las familias del select
  const respuesta = await $.ajax({
    url: DIR_SERV + "/familias",
    dataType: "json",
    type: "GET",
  })

  // Si devuelve error lo pongo
  if (respuesta.error) { // Error del propio jquery
    $("#acciones").html(respuesta.error)
  } else if (respuesta.mensaje_error) {
    $("#acciones").html(respuesta.mensaje_error)
  } else {
    // Si no devuelve error, pongo el select con las familias
    formulario += `<p>
                  <label for='familia'><strong>Familia: </strong></label>
                  <select name='familia' id='familia'>`
    $.each(respuesta.familias, function (key, tupla) {
      formulario += `<option value='${tupla.cod}' >${tupla.nombre}</option>`
    })
    formulario += `</select></p>
                  <p><button type='submit'>Añadir</button> <button onClick='event.preventDefault(); resetHtml()'>Volver</button></p>
                  </form>`
    $("#acciones").html(formulario)
  }
}

async function comprobarRepetidoExcluido (tabla, columna, valor, colId, id) {
  const respuesta = await $.ajax({
    url: encodeURI(`${DIR_SERV}/repetido/${tabla}/${columna}/${valor}/${colId}/${id}`),
    dataType: 'json',
    type: 'get'
  })

  if (respuesta.error) return true

  if (respuesta.mensaje_error) return true

  return respuesta.repetido
}

async function comprobarRepetido (tabla, columna, valor) {
  const respuesta = await $.ajax({
    url: encodeURI(`${DIR_SERV}/repetido/${tabla}/${columna}/${valor}`),
    dataType: 'json',
    type: 'get'
  })

  if (respuesta.error) return true

  if (respuesta.mensaje_error) return true

  return respuesta.repetido
}

async function crearProducto (event) {
  event.preventDefault()
  const FORM = event.target


  let codRepetido = await comprobarRepetido('producto', 'cod', FORM.cod.value)
  let nombreCorRepetido = await comprobarRepetido('producto', 'nombre_corto', FORM.nombre_corto.value)
  if (codRepetido) {
    $(FORM.cod).siblings("span.error").html('* Código repetido *')
  }
  if (nombreCorRepetido) {
    $(FORM.nombre_corto).siblings("span.error").html('* Nombre corto repetido *')
  }

  if (!codRepetido && !nombreCorRepetido) {
    // Mapeo el formulario
    const FORM_DATA = new FormData(FORM)
    const ENTRIES = FORM_DATA.entries()
    let datos = {}

    for (var tupla of ENTRIES) {
      datos[tupla[0]] = tupla[1]
    }
    // Inserto el producto válido
    await $.ajax({
      url: encodeURI(`${DIR_SERV}/producto/insertar`),
      dataType: 'json',
      type: 'post',
      data: datos
    })

    // Pongo el mensaje
    $("#acciones").html(`<p class='mensaje'>El producto ha sido creado con éxito</p>`)
    // Refresco la página
    obtener_productos()
  }
}

// Vamos a hacer la tabla con los productos
async function obtener_detalles (cod) {
  $.ajax({
    url: DIR_SERV + "/productos/" + cod,
    dataType: "json",
    type: "GET",
  }).done(async function (data) {
    if (data.mensaje_error) {
      $("#acciones").html(data.mensaje_error)
    } else {
      // Vamos a crear una tabla con los productos
      let detalles = `<h2>Detalles del producto: ${data.producto.cod}</h2>`
      detalles += `<p><strong>COD:</strong> ${data.producto.cod}</p>`
      detalles += `<p><strong>Nombre:</strong> ${data.producto.nombre ?? ''}</p>`
      detalles += `<p><strong>Nombre corto:</strong> ${data.producto.nombre_corto}</p>`
      detalles += `<p><strong>Descripción:</strong> ${data.producto.descripcion}</p>`
      detalles += `<p><strong>PVP:</strong> ${data.producto.PVP}</p>`

      // Pido el nombre de la familia a la API
      const respuesta = await $.ajax({
        url: DIR_SERV + "/familia/" + data.producto.familia,
        dataType: "json",
        type: "GET",
      })

      if (respuesta.error) return $("#acciones").html(respuesta.error)

      if (respuesta.mensaje_error) return $("#acciones").html(respuesta.mensaje_error)

      detalles += `<p><strong>Familia: </strong> ${respuesta.familia.nombre}</p>`

      detalles += `<p><button onclick='resetHtml()' >volver</button></p>`

      // Pongo el mensaje
      $("#acciones").html(detalles)
    }
  })
}

async function crearFormEditar (cod) {
  resetHtml()
  // Obtengo los datos actuales
  const respuestaDatos = await $.ajax({
    url: DIR_SERV + `/productos/${cod}`,
    dataType: "json",
    type: "GET",
  })

  // Si devuelve error lo pongo
  if (respuesta.error) { // Error del propio jquery
    $("#acciones").html(respuesta.error)
  } else if (respuesta.mensaje_error) {
    $("#acciones").html(respuesta.mensaje_error)
  } else {
    const producto = respuestaDatos.producto
    let formulario = `<form onsubmit='editarProducto(event)' method='post' action='.'>
                    <h2>Editando el producto ${cod}</h2>
                    <p>
                      <label for='nombre'><strong>Nombre: </strong></label><input type='text' name='nombre' id='nombre' value='${producto.nombre}' />
                      <span class='error'></span>
                    </p>
                    <p>
                      <label for='nombre_corto'><strong>Nombre corto: </strong></label><input type='text' name='nombre_corto' id='nombre_corto' value='${producto.nombre_corto}' required/>
                      <span class='error'></span>
                    </p>
                    <p>
                      <label for='descripcion'><strong>Descripción: </strong></label><textarea name='descripcion' id='descripcion' required >${producto.descripcion}</textarea>
                      <span class='error'></span>
                    </p>
                    <p>
                      <label for='PVP'><strong>PVP: </strong></label><input type='number' name='PVP' id='PVP' value='${producto.PVP}' required />
                      <span class='error'></span>
                    </p>
  `
    // añado las familias del select
    const respuesta = await $.ajax({
      url: DIR_SERV + "/familias",
      dataType: "json",
      type: "GET",
    })

    // Si devuelve error lo pongo
    if (respuesta.error) { // Error del propio jquery
      $("#acciones").html(respuesta.error)
    } else if (respuesta.mensaje_error) {
      $("#acciones").html(respuesta.mensaje_error)
    } else {
      // Si no devuelve error, pongo el select con las familias
      formulario += `<p>
                  <label for='familia'><strong>Familia: </strong></label>
                  <select name='familia' id='familia'>`
      $.each(respuesta.familias, function (key, tupla) {
        formulario += tupla.cod == producto.familia ? `<option value='${tupla.cod}' selected >${tupla.nombre}</option>` : `<option value='${tupla.cod}' >${tupla.nombre}</option>`
      })
      formulario += `</select></p>
                  <p><input type='hidden' name='cod' value='${cod}' /><button type='submit'>Editar</button> <button onClick='event.preventDefault(); resetHtml()'>Volver</button></p>
                  </form>`
      $("#acciones").html(formulario)
    }
  }
}

async function editarProducto (event) {
  event.preventDefault()

  const FORM = event.target
  const cod = FORM.cod.value

  let nombreCorRepetido = await comprobarRepetidoExcluido('producto', 'nombre_corto', FORM.nombre_corto.value, 'cod', cod)
  if (nombreCorRepetido) {
    $(FORM.nombre_corto).siblings("span.error").html('* Nombre corto repetido *')
  }

  if (!nombreCorRepetido) {
    // Mapeo el formulario
    const FORM_DATA = new FormData(FORM)
    const ENTRIES = FORM_DATA.entries()
    let datos = {}

    for (var tupla of ENTRIES) {
      if (tupla[0] != "cod")
        datos[tupla[0]] = tupla[1]
    }
    // Inserto el producto válido
    await $.ajax({
      url: encodeURI(`${DIR_SERV}/producto/actualizar/${cod}`),
      dataType: 'json',
      type: 'put',
      data: datos
    })

    // Pongo el mensaje
    $("#acciones").html(`<p class='mensaje'>El producto ha sido editado con éxito</p>`)
    // Refresco la página
    obtener_productos()
  }
}

function resetHtml () {
  $('#acciones').html('')
}

$(document).ready(function () {

  // Nada más cargar la página quiero tener los productos
  obtener_productos();

});