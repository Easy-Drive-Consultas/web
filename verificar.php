<?php
session_start();

// Ruta del archivo CSV
/public_html
│
├── index.php
├── verificar.php
└── data.csv // Ruta absoluta

// Comprobar si el archivo CSV existe
if (file_exists($archivo_csv)) {
    $archivo = fopen($archivo_csv, 'r');
    $certificados = [];

    while (($linea = fgetcsv($archivo)) !== FALSE) {
        $documento = $linea[0];
        $nombre = $linea[1];
        $apellido = $linea[2];
        $estado = (int)$linea[3];

        $certificados[$documento] = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'estado' => $estado
        ];
    }

    fclose($archivo);
    $_SESSION['certificados'] = $certificados;
} else {
    echo "Error: El archivo de datos no se encuentra.";
    exit();
}

if (!isset($_SESSION['certificados'])) {
    echo "<h3>No se han cargado los datos de los certificados. Por favor, cargue un archivo CSV.</h3>";
    exit();
}

$certificados = $_SESSION['certificados'];

// Función para mostrar mensajes con formato
function mostrarMensaje($mensaje, $color = "#dc3545", $icono = "❌") {
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Resultado de Consulta</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f4f8;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }

            .container {
                background-color: #ffffff;
                padding: 30px 40px;
                border-radius: 15px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                text-align: center;
                width: 100%;
                max-width: 500px;
            }

            .logo {
                width: 360px;
                height: auto;
                margin-bottom: 20px;
            }

            h3 {
                margin-bottom: 20px;
                color: {$color};
            }

            a {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 20px;
                background-color: #e60000; /* Rojo vivo */
                color: white;
                text-decoration: none;
                border-radius: 8px;
                transition: background-color 0.3s ease;
            }

            a:hover {
                background-color: #b30000;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <img src="logo.png" alt="" class="logo">
            <h3>$icono $mensaje</h3>
            <a href='index.php'>Volver</a>
        </div>
    </body>
    </html>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $_POST['documento'];

    if (array_key_exists($documento, $certificados)) {
        $estado = $certificados[$documento]['estado'];
        $nombre = $certificados[$documento]['nombre'];
        $apellido = $certificados[$documento]['apellido'];

        $mensajes = [
            1 => ["¡Tu certificado ya está disponible en la escuela para ser retirado! 🚗", "#28a745", "✅"],
            2 => ["El certificado vinculado al número de cédula o pasaporte <strong>$documento</strong> está en proceso de registro en la Autoridad de Tránsito. ¡Pronto estará listo! 🚗", "#ffc107", "⏳"],
            3 => ["Tu certificado está siendo impreso en este momento. ¡Ya casi está listo para ser enviado a la Autoridad de Tránsito! 🚗", "#17a2b8", "🖨️"],
            4 => ["El certificado aún no está disponible, ya que el proceso académico no ha finalizado. Por favor, vuelve a consultar más adelante. 🚗", "#dc3545", "❌"],
        ];

        [$mensaje, $color, $icono] = $mensajes[$estado];

        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Resultado de Consulta</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f2f4f8;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }

                .container {
                    background-color: #ffffff;
                    padding: 30px 40px;
                    border-radius: 15px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    width: 100%;
                    max-width: 500px;
                }

                .logo {
                    width: 360px;
                    height: auto;
                    margin-bottom: 20px;
                }

                h3 {
                    margin-bottom: 20px;
                    color: {$color};
                }

                a {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 10px 20px;
                    background-color: #e60000; /* Rojo vivo */
                    color: white;
                    text-decoration: none;
                    border-radius: 8px;
                    transition: background-color 0.3s ease;
                }

                a:hover {
                    background-color: #b30000;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <img src="logo.png" alt="" class="logo">
                <h3>$icono Hola $nombre $apellido, $mensaje</h3>
                <a href='index.php'>Volver</a>
            </div>
        </body>
        </html>";
    } else {
        mostrarMensaje("Cédula o pasaporte no encontrado.");
    }
} else {
    mostrarMensaje("Acceso no permitido.");
}
?>
