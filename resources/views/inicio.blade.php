<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aleja-Nails — Sistema de Belleza</title>
    <link rel="icon" type="image/png" href="{{ asset('img/ico.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(
                135deg,
                #ef86ba,
                #efb4d3,
                #f970bb
            );
        }
        .slide {
            display: none;
        }
        .slide.active {
            display: block;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            transition: 0.3s;
        }
    </style>
</head>
<body class="bg-white text-gray-800">

<!-- NAVBAR -->
<nav class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 flex justify-between h-16 items-center">
        <div class="flex items-center gap-3">
            <img src="{{ asset('img/ico.png') }}" class="w-10 h-10 rounded-lg shadow-sm" onerror="this.src='https://placehold.co/100x100?text=💅'">
            <span class="font-bold text-pink-600 text-2xl tracking-tight">
                Aleja-Nails
            </span>
        </div>
        <div class="hidden md:flex gap-6">
            <a href="#inicio" class="hover:text-pink-600 transition">Inicio</a>
            <a href="#nosotros" class="hover:text-pink-600 transition">Nosotros</a>
            <a href="#servicios" class="hover:text-pink-600 transition">Servicios</a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section id="inicio" class="relative h-[550px] text-white">
    <div class="slide active h-full">
        <img src="{{ asset('img/salon_hero.png') }}"
             class="absolute w-full h-full object-cover"
             style="filter:brightness(0.5)"
             onerror="this.src='https://images.unsplash.com/photo-1604654894610-df63bc536371?q=80&w=1200'">
        <div class="absolute inset-0 gradient-bg opacity-60"></div>
        <div class="relative flex flex-col justify-center items-center h-full text-center px-4">
            <h1 class="text-5xl font-bold">
                Aleja-Nails 💅
            </h1>
            <p class="mt-4 text-lg">
                Belleza, estilo y elegancia en un solo lugar
            </p>

            <!-- BOTONES -->
            <div class="flex gap-4 mt-8">
                <!-- REGISTRO -->
                <a
                    href="{{ route('registro') }}"
                    class="gradient-bg px-8 py-3 rounded-xl text-white font-semibold hover:scale-105 transition shadow-lg"
                >
                    Registrarse
                </a>
                <!-- LOGIN -->
                <a
                    href="{{ route('login') }}"
                    class="gradient-bg px-8 py-3 rounded-xl text-white font-semibold hover:scale-105 transition shadow-lg"
                >
                    Iniciar Sesión
                </a>
            </div>
        </div>
    </div>
</section>

<!-- NOSOTROS -->
<section id="nosotros" class="py-20 text-center">
    <h2 class="text-3xl font-bold text-pink-600 mb-4">
        Sobre Nosotros
    </h2>
    <p class="max-w-xl mx-auto text-gray-600 mb-10 px-4">
        Somos un salón con estilo, elegancia y organización.
        Brindamos una experiencia única en el cuidado de tus uñas
        con servicios modernos y profesionales.
    </p>

    <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto px-4">
        <div class="feature-card bg-pink-50 p-6 rounded-xl shadow-sm border border-pink-100">
            <h3 class="text-xl font-bold text-pink-600 mb-2">
                🎯 Misión
            </h3>
            <p class="text-gray-700">
                Ofrecer servicios de belleza de alta calidad
                que resalten la elegancia y estilo de cada cliente.
            </p>
        </div>

        <div class="feature-card bg-pink-50 p-6 rounded-xl shadow-sm border border-pink-100">
            <h3 class="text-xl font-bold text-pink-600 mb-2">
                💡 Visión
            </h3>
            <p class="text-gray-700">
                Ser un salón reconocido por innovación,
                calidad y atención personalizada.
            </p>
        </div>
    </div>
</section>

<!-- SERVICIOS -->
<section id="servicios" class="py-20 bg-pink-50">
    <h2 class="text-center text-3xl font-bold text-pink-600 mb-10">
        Servicios
    </h2>

    <div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto px-4">
        <div class="bg-white p-6 rounded-xl shadow border border-pink-100">
            <h3 class="font-bold text-pink-600 text-lg mb-2">
                💅 Servicio de Manicure
            </h3>
            <p class="text-gray-600">
                Servicios manicure modernos, elegantes
                y personalizados.
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border border-pink-100">
            <h3 class="font-bold text-pink-600 text-lg mb-2">
                👣 Servicio de Pedicure
            </h3>
            <p class="text-gray-600">
                Pedicure profesional con delicadeza,
                calidad y elegancia.
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border border-pink-100">
            <h3 class="font-bold text-pink-600 text-lg mb-2">
                💆🏽‍♀️ Servicio de Capilar
            </h3>
            <p class="text-gray-600">
                Tratamientos capilares modernos
                para resaltar tu belleza.
            </p>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="text-center py-6 text-sm text-pink-400 bg-white border-t border-pink-100">
    © {{ date('Y') }} Aleja-Nails · Salón de Belleza Profesional
</footer>

</body>
</html>
