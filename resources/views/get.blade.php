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
        /* Cambia el cursor a una mano */
    }

    .acordeon-body {
        display: none;
        /* Oculta el cuerpo del acordeón por defecto */
        padding: 10px;
    }

    /* Estilos para el contenedor de resultados */
    #resultados {
        height: 400px;
        /* Tamaño predeterminado */
        overflow-y: scroll;
        /* Añade desplazamiento vertical */
        border: 1px solid #ccc;
        /* Añade un borde para visualización */
        padding: 10px;
        /* Añade espacio interno */
        margin-top: 20px;
        /* Añade espacio superior */
        white-space: pre-wrap;
        /* Mantiene el formato del texto dentro de <pre> */
    }
  </style>
</head>
<body>
  <!-- Acordeón -->
  <div class="acordeon">
    <div class="acordeon-header" id="acordeonHeader">Consulta a API</div>
    <div class="acordeon-body" id="acordeonBody">
      <button id="consultaBtn">Consultar API</button>
      <pre id="resultados"></pre>
      <button id="borrarBtn">Borrar</button>
    </div>
  </div>

  <script>
      // Elementos del acordeón
      var header = document.getElementById('acordeonHeader');
      var body = document.getElementById('acordeonBody');
      var resultados = document.getElementById('resultados');
      var consultaBtn = document.getElementById('consultaBtn');
      var borrarBtn = document.getElementById('borrarBtn');

      // Evento clic en el encabezado
      header.addEventListener('click', function(event) {
          body.style.display = body.style.display === 'none' ? 'block' : 'none';
      });

      // Evento clic en el botón de consulta
      consultaBtn.addEventListener('click', function(event) {
          event.stopPropagation(); // Evitar que el clic en el botón propague al encabezado

          fetch('https://productapi-production-a124.up.railway.app/api/products')
              .then(response => response.json())
              .then(data => {
                  // Mostrar los resultados en formato JSON dentro de <pre>
                  resultados.textContent = JSON.stringify(data, null, 2);
              })
              .catch(error => console.error('Error al consultar la API:', error));
      });

      // Evento clic en el botón de borrar
      borrarBtn.addEventListener('click', function(event) {
          resultados.textContent = ''; // Borra el contenido del pre
      });
  </script>
</body>
