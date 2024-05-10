<style>
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

    #productoJSON {
        width: 100%;
        height: 150px;
        margin-top: 10px;
    }

    #resultados {
        height: 150px;
        overflow-y: scroll;
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 20px;
        white-space: pre-wrap;
    }
</style>
</head>

<body>
    <div class="acordeon">
        <div class="acordeon-header" id="acordeonHeader">Enviar Producto</div>
        <div class="acordeon-body" id="acordeonBody">
            <textarea id="productoJSON" placeholder="Introduce tu producto en formato JSON"></textarea>
            <button id="enviarBtn">Enviar</button>
            <button id="borrarBtn">Borrar</button>
            <pre id="resultados"></pre>
        </div>
    </div>

    <script>
        var header = document.getElementById('acordeonHeader');
        var body = document.getElementById('acordeonBody');
        var productoJSON = document.getElementById('productoJSON');
        var enviarBtn = document.getElementById('enviarBtn');
        var borrarBtn = document.getElementById('borrarBtn');
        var resultados = document.getElementById('resultados');

        header.addEventListener('click', function(event) {
            body.style.display = body.style.display === 'none' ? 'block' : 'none';
        });

        enviarBtn.addEventListener('click', function(event) {
            event.stopPropagation();

            try {
                var producto = JSON.parse(productoJSON.value);
                enviarProducto(producto);
            } catch (error) {
                console.error('Error al parsear el producto:', error);
            }
        });

        borrarBtn.addEventListener('click', function(event) {
            productoJSON.value = '';
            resultados.textContent = '';
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
                    resultados.textContent = JSON.stringify(data, null, 2);
                })
                .catch(error => console.error('Error al enviar el producto:', error));
        }
    </script>
</body>
