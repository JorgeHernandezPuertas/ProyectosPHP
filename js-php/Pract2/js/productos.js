function obtener_productos()
{
    $.ajax({
        url:"servicios_rest_key/productos",
        type:"GET",
        dataType:"json",
        data:{"api_session":localStorage.api_session}
    })
    .done(function(data){
        if(data.mensaje_error)
        {
            $('#errores').html(data.mensaje_error);
            $('#respuestas').html("");
            $('#productos').html("");
        }
        else
        {
            var html_tabla_prod="<table class='centrado'>";
            html_tabla_prod+="<tr><th>COD</th><th>Nombre</th><th>PVP</th><th><button class='enlace' onclick='montar_form_crear();'>Productos+</button></th></tr>";

            $.each(data.productos, function(key, tupla){
                html_tabla_prod+="<tr>";
                html_tabla_prod+="<td><button class='enlace' onclick='detalles(\""+tupla["cod"]+"\")'>"+tupla["cod"]+"</button></td>";
                html_tabla_prod+="<td>"+tupla["nombre_corto"]+"</td>";
                html_tabla_prod+="<td>"+tupla["PVP"]+"</td>";
                html_tabla_prod+="<td><button class='enlace' onclick='confirmar_borrar(\""+tupla["cod"]+"\");'>Borrar</button> - Editar</td>";
                html_tabla_prod+="</tr>";
            });

            html_tabla_prod+="</table>";
            $('#errores').html("");
            $('#productos').html(html_tabla_prod);
        }
    })
    .fail(function(a,b){
        $('#errores').html(error_ajax_jquery(a,b));
        $('#respuestas').html("");
        $('#productos').html("");
    });
}


function obtener_productos_normal()
{
    $.ajax({
        url:"servicios_rest_key/productos",
        type:"GET",
        dataType:"json",
        data:{"api_session":localStorage.api_session}
    })
    .done(function(data){
        if(data.mensaje_error)
        {
            $('#errores').html(data.mensaje_error);
            $('#respuestas').html("");
            $('#productos').html("");
        }
        else
        {
            var html_tabla_prod="<table class='centrado'>";
            html_tabla_prod+="<tr><th>COD</th><th>Nombre</th><th>PVP</th></tr>";

            $.each(data.productos, function(key, tupla){
                html_tabla_prod+="<tr>";
                html_tabla_prod+="<td><button class='enlace' onclick='detalles(\""+tupla["cod"]+"\")'>"+tupla["cod"]+"</button></td>";
                html_tabla_prod+="<td>"+tupla["nombre_corto"]+"</td>";
                html_tabla_prod+="<td>"+tupla["PVP"]+"</td>";
                html_tabla_prod+="</tr>";
            });

            html_tabla_prod+="</table>";
            $('#errores').html("");
            $('#productos').html(html_tabla_prod);
        }
    })
    .fail(function(a,b){
        $('#errores').html(error_ajax_jquery(a,b));
        $('#respuestas').html("");
        $('#productos').html("");
    });
}