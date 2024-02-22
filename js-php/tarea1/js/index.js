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
        tabla_productos += `<td><button class='enlace' onclick='editarProducto("${tupla.cod}")'>Editar</button> - <button class='enlace' onclick='eliminarProducto("${tupla.cod}")'>Borrar</button></td>`
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
      //TODO: mostrar borrado
    }
  })
}

function nuevoProducto () {

}

// Vamos a hacer la tabla con los productos
function obtener_detalles (cod) {
  $.ajax({
    url: DIR_SERV + "/productos/" + cod,
    dataType: "json",
    type: "GET",
  }).done(function (data) {
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
      detalles += `<p><button onclick='resetHtml()' >volver</button></p>`

      $("#acciones").html(detalles)
    }
  })
}

function resetHtml () {
  $('#acciones').html('')
}

$(document).ready(function () {

  // Nada más cargar la página quiero tener los productos
  obtener_productos();

});