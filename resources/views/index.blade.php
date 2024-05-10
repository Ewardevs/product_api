<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar y Consultar Productos</title>
    <style>
        /* Estilos del acordeón */
        .acordeon {
            border: 1px solid #ccc;
            margin-top: 20px;
        }

        .acordeon-header {
            background-color: #f4f4f4;
            padding: 10px;
            cursor: pointer;
        }

        .acordeon-body {
            display: none;
            padding: 10px;
        }

        /* Estilos para el textarea */
        #productoJSON,
        #productoUpdateJSON {
            width: 100%;
            height: 150px;
            margin-top: 10px;
        }

        #resultadosEnvio,
        {
        height: 150px;
        }

        /* Estilos para el contenedor de resultados */
        #resultados,
        #resultadosEnvio,
        #resultadosUpdate,
        #resultadosDelete {
            height: 400px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 20px;
            white-space: pre-wrap;
        }

        #resultadosDelete,
        #resultadosUpdate,
        #resultadosEnvio {
            height: 150px !important;
        }

        .previsualizacion {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            white-space: pre-wrap;
        }
    </style>
</head>

<body>
    <!-- Consultar Producto -->
    <div class="acordeon">
        <div class="acordeon-header" id="acordeonHeaderConsulta">Obtener todos los productos ->
        </div>
        <div class="acordeon-body" id="acordeon" style="display: none;">
            <a
                href="https://productapi-production-a124.up.railway.app/api/products">https://productapi-production-a124.up.railway.app/api/products</a>
            <button id="consultaBtn">Consultar API</button>
            <pre id="resultados"></pre>
            <button id="borrarBtnConsulta">Borrar</button>
        </div>
    </div>

    <!-- Enviar Producto -->
    <div class="acordeon">
        <div class="acordeon-header" id="acordeonHeaderEnvio">Enviar Producto ->
        </div>
        <div class="acordeon-body" id="acordeon" style="display: none;">
            <a
                href="https://productapi-production-a124.up.railway.app/api/products">https://productapi-production-a124.up.railway.app/api/products</a>
            <button id="formatoBtnUpdate">Formato JSON</button>
            <textarea id="productoJSON" placeholder="Introduce tu producto en formato JSON"></textarea>
            <button id="enviarBtn">Enviar</button>

            <pre id="resultadosEnvio"></pre>
            <button id="borrarBtnEnvio">Borrar</button>
        </div>
    </div>

    <!-- Actualizar Producto -->
    <div class="acordeon">
        <div class="acordeon-header" id="acordeonHeaderUpdate">Actualizar Producto: ID -></div>
        <div class="acordeon-body" id="acordeon" style="display: none;">
            <a
                href="https://productapi-production-a124.up.railway.app/api/products/">https://productapi-production-a124.up.railway.app/api/products</a>{ID}
            <br><br>
            <input id="productoUpdateID" placeholder="ID del producto a actualizar">
            <button id="actualizarBtn">Actualizar</button>
            <button id="formatoBtnUpdate">Formato JSON</button>
            <textarea id="productoUpdateJSON" placeholder="Introduce el producto actualizado en formato JSON"></textarea>

            <pre id="resultadosUpdate"></pre>
        </div>
    </div>
    <div class="acordeon">
        <div class="acordeon-header" id="acordeonHeaderDelete">Eliminar producto : ID ->
        </div>
        <div class="acordeon-body" id="acordeon" style="display: none;">
            <a
                href="https://productapi-production-a124.up.railway.app/api/products/">https://productapi-production-a124.up.railway.app/api/products</a>{ID}
            <br>
            <br>
            <input id="productoDeleteID" placeholder="Introduce el producto eliminar">
            <button id="borrarBtn">enviar request</button>


            <pre id="resultadosDelete"></pre>
            <button id="borrarBtnDelete">Borrar</button>
        </div>
    </div>

    <script>
        // Función para manejar el click en los headers de los acordeones
        function toggleAcordeon(acordeonBody) {
            if (acordeonBody.style.display === "block") {
                acordeonBody.style.display = "none";
            } else {
                acordeonBody.style.display = "block";
            }
        }
        // Agregar evento de click a todos los headers de acordeones
        var headers = document.querySelectorAll(".acordeon-header");
        headers.forEach(function(header) {
            header.addEventListener("click", function() {
                var body = this.nextElementSibling;
                toggleAcordeon(body);
            });
        });

        // Consultar Producto
        var bodyConsulta = document.getElementById('acordeonBodyConsulta');
        var resultadosConsulta = document.getElementById('resultados');
        var consultaBtn = document.getElementById('consultaBtn');
        var borrarBtnConsulta = document.getElementById('borrarBtnConsulta');


        consultaBtn.addEventListener('click', function(event) {
            event.stopPropagation();

            fetch('https://productapi-production-a124.up.railway.app/api/products')
                .then(response => response.json())
                .then(data => {
                    resultadosConsulta.textContent = JSON.stringify(data, null, 2);
                })
                .catch(error => console.error('Error al consultar la API:', error));
        });

        borrarBtnConsulta.addEventListener('click', function(event) {
            resultadosConsulta.textContent = '';
        });



        //  Enviar Producto
        var bodyEnvio = document.getElementById('acordeonBodyEnvio');
        var productoJSON = document.getElementById('productoJSON');
        var enviarBtn = document.getElementById('enviarBtn');
        var borrarBtnEnvio = document.getElementById('borrarBtnEnvio');
        var resultadosEnvio = document.getElementById('resultadosEnvio');
        var previsualizacionProducto = document.getElementById('previsualizacionProducto');
        countErrors = 1
        enviarBtn.addEventListener('click', function(event) {
            event.stopPropagation();

            resultadosEnvio.textContent = ""
            try {
                var producto = JSON.parse(productoJSON.value);
                enviarProducto(producto);
            } catch (error) {
                resultadosEnvio.textContent += "esta mal escrito x" + (countErrors);
                countErrors += 1
            }

        });

        borrarBtnEnvio.addEventListener('click', function(event) {
            productoJSON.value = '';
            resultadosEnvio.textContent = '';
        });

        function enviarProducto(producto) {
            fetch('https://productapi-production-a124.up.railway.app/api/products', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(producto)
                })
                .then(response => response.json())
                .then(data => {
                    resultadosEnvio.textContent = JSON.stringify(data, null, 2);
                })
                .catch(error => console.error('Error al enviar el producto:', error));
        }


        //Borrar dato
        var inputId = document.getElementById('productoDeleteID'); // Sin comillas adicionales
        var inputrequest = document.getElementById('borrarBtn');
        var resultadosDelete = document.getElementById("resultadosDelete")

        async function borrarDato(id) {
            try {
                const response = await fetch(
                    `https://productapi-production-a124.up.railway.app/api/products/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            // Puedes incluir cualquier otra cabecera necesaria, como tokens de autorización
                        },
                    });

                // Verificar si la solicitud fue exitosa
                if (response.ok) {
                    const data = await response.json();
                    console.log('Dato borrado exitosamente');
                    resultadosDelete.textContent = JSON.stringify(data);
                } else {
                    // Si la respuesta no es 2xx, algo salió mal
                    const errorMessage = await response.text();
                    resultadosDelete.textContent = errorMessage;
                }
            } catch (error) {
                console.error('Ocurrió un error al intentar borrar el dato:', error);
            }
        }

        inputrequest.addEventListener('click', function(event) {
            borrarDato(inputId.value);
        });

        //actualizar
        var actualizarBtn = document.getElementById('actualizarBtn');
        var resultadosUpdate = document.getElementById("resultadosUpdate");

        async function actualizarProducto(id, nuevoProducto) {
            try {
                const response = await fetch(
                    `https://productapi-production-a124.up.railway.app/api/products/${id}`, {
                        method: 'PUT', // O 'PATCH' según corresponda
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(nuevoProducto)
                    });

                if (response.ok) {
                    const data = await response.json();
                    console.log('Producto actualizado:', data);
                    resultadosUpdate.textContent = JSON.stringify(data);
                } else {
                    const errorMessage = await response.text();
                    console.error('Error al actualizar el producto:', errorMessage);
                    resultadosUpdate.textContent = errorMessage;
                }
            } catch (error) {
                console.error('Ocurrió un error al intentar actualizar el producto:', error);
                resultadosUpdate.textContent = 'Ocurrió un error al intentar actualizar el producto';
            }
        }

        actualizarBtn.addEventListener('click', function(event) {
            var productoID = document.getElementById('productoUpdateID').value;
            var productoJSON = document.getElementById('productoUpdateJSON').value;

            // Intentamos convertir el JSON ingresado a un objeto, si no es válido, se manejará como error
            try {
                productoJSON = JSON.parse(productoJSON);
            } catch (error) {
                console.error('Error al parsear el JSON:', error);
                resultadosUpdate.textContent = 'El JSON ingresado no es válido';
                return; // Salimos de la función si hay un error
            }

            actualizarProducto(productoID, productoJSON);
        });

        function formatoJSON() {
            var textareas = document.querySelectorAll('.productoUpdateJSON');
            textareas.forEach(function(textarea) {
                try {
                    var formattedJSON = JSON.stringify(JSON.parse(textarea.value), null, 4);
                    textarea.value = formattedJSON;
                } catch (error) {
                    console.error('Error al formatear el JSON:', error);
                    alert('El JSON ingresado no es válido.');
                }
            });
        }

        // Botón para formatear JSON en la sección de Actualizar Producto
        var formatoBtnUpdate = document.getElementById('formatoBtnUpdate');
        formatoBtnUpdate.addEventListener('click', formatoJSON);
    </script>
</body>

</html>
