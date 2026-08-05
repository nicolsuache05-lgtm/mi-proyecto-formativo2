<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error de Configuración de Base de Datos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-pink-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 text-center border-t-4 border-pink-500">
        <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
            ⚠️
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Error de Conexión</h1>
        <p class="text-gray-600 mb-6 leading-relaxed">
            {{ $message ?? 'No se pudo conectar a la base de datos. Revisa la configuración del archivo .env.' }}
        </p>
        <div class="text-sm text-gray-400 bg-gray-50 rounded-lg p-3 inline-block">
            Verifica el host, puerto, base de datos y credenciales en tu archivo <code class="text-pink-600 font-mono font-bold">.env</code>.
        </div>
    </div>
</body>
</html>
