<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Isekai API</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Fondo con imagen y overlay oscuro */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('/images/fondo2.jpg') no-repeat fixed center;
            background-size: cover;
            position: relative;
        }

        /* Capa oscura encima del fondo */
        .overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6); /* oscuro semi-transparente */
            z-index: 0;
        }

        /* Contenido encima del overlay */
        .content {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 4rem 2rem;
            color: white;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
        }

        .button-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            max-width: 800px;
            margin: 0 auto;
        }

        a.button {
            background: #3498db;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s ease-in-out;
        }

        a.button:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>

    <div class="content">
        <h1>Isekai API - Portal de Endpoints</h1>

        <div class="button-grid">
            <a class="button" href="/api/v1/info/species" target="_blank">Listado de Especies</a>
            <a class="button" href="/api/v1/info/strata" target="_blank">Listado de Estratos</a>
            <a class="button" href="/api/v1/info/genders" target="_blank">Listado de Géneros</a>
            <a class="button" href="/api/v1/stats/count?speciesCode=HU&strataCode=5&genderCode=M" target="_blank">Estadística: Conteo</a>
            <a class="button" href="/api/v1/stats/age?speciesCode=HU&strataCode=5&genderCode=M"   target="_blank">Estadística: Edad</a>
            <a class="button" href="/api/documentation" target="_blank">Ver Documentación</a>
        </div>
    </div>
</body>
</html>
