<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Certificado</title>
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

        h2 {
            margin-bottom: 20px;
            color: #333333;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .resultado {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="img/logo.png" alt="Logo de la empresa" class="logo">
        <h2>Consulta de Certificado</h2>
        <input type="text" id="documento" placeholder="Ingrese su número de cédula o pasaporte" required>
        <button onclick="buscarCertificado()">Consultar</button>
        <div class="resultado" id="resultado"></div>
    </div>

    <script>
        let certificados = {};

        // Cargar el CSV al iniciar
        fetch('data.csv')
            .then(response => response.text())
            .then(data => {
                const filas = data.trim().split('\n');
                filas.forEach(fila => {
                    const [documento, nombre, apellido, estado] = fila.split(',');
                    certificados[documento] = {
                        nombre,
                        apellido,
                        estado: parseInt(estado)
                    };
                });
            });

        function buscarCertificado() {
            const doc = document.getElementById('documento').value.trim();
            const resultado = document.getElementById('resultado');

            if (!doc || !certificados[doc]) {
                resultado.innerHTML = "❌ Documento no encontrado. 🚗";
                resultado.style.color = "#dc3545";
                return;
            }

            const datos = certificados[doc];
            const mensajes = {
                1: ["¡Tu certificado ya está disponible en la escuela para ser retirado! 🚗", "#28a745", "✅"],
                2: [`El certificado vinculado al número <strong>${doc}</strong> está en proceso de registro en la Autoridad de Tránsito. ¡Pronto estará listo! 🚗`, "#ffc107", "⏳"],
                3: ["Tu certificado está siendo impreso en este momento. ¡Ya casi está listo para ser enviado a la Autoridad de Tránsito! 🚗", "#17a2b8", "🖨️"],
                4: ["El certificado aún no está disponible, ya que el proceso académico no ha finalizado. Por favor, vuelve a consultar más adelante. 🚗", "#dc3545", "❌"]
            };

            const [mensaje, color, icono] = mensajes[datos.estado] || ["Estado desconocido", "#6c757d", "❓"];
            resultado.innerHTML = `${icono} Hola <strong>${datos.nombre} ${datos.apellido}</strong>, ${mensaje}`;
            resultado.style.color = color;
        }
    </script>
</body>
</html>
