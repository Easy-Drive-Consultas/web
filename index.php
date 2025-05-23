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
            max-width: 400px;
        }

        .logo {
            width: 360px; /* Tamaño aumentado 3x */
            height: auto;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
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
            background-color: #e60000; /* Rojo vivo */
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #b30000; /* Rojo más oscuro al pasar el cursor */
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="img/logo.png" alt="Logo de la empresa" class="logo">
        <h2>Consulta de Certificado</h2>
        <form action="verificar.php" method="POST">
            <label for="documento">Número de Documento:</label>
            <input type="text" id="documento" name="documento" required>
            <button type="submit">Consultar</button>
        </form>
    </div>
</body>
</html>
