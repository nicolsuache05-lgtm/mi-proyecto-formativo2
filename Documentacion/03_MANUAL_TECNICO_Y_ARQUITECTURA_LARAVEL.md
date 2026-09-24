# Manual Técnico y Arquitectura del Sistema
## Sistema de Gestión para Salón de Belleza — **Style-Nails (Aleja-Nails)**

---

## 1. Ficha Técnica del Proyecto

| Parámetro | Detalle |
|---|---|
| **Nombre del Sistema:** | Style-Nails / Aleja-Nails |
| **Tipo de Aplicación:** | Aplicación Web Monolítica (MVC) con API interna REST para consultas asíncronas |
| **Framework Back-End:** | Laravel 11.x (PHP 8.2+) |
| **Motor de Base de Datos:** | MySQL 8.0 / MariaDB 10.4+ |
| **Motor de Vistas:** | Blade Template Engine |
| **Front-End & Estilos:** | HTML5 semántico, CSS3 Vanilla profesional (diseño responsive, glassmorphism, paleta estética pastel), JavaScript Vanilla (Fetch API) |
| **Servidor de Desarrollo:** | Laragon (Apache 2.4, PHP 8.2, MySQL 8.0) |
| **Autenticación:** | Multi-Guard nativo de Laravel (`web` para clientes, `admin` para administración) |

---

## 2. Estructura del Código Fuente

A continuación se detalla la estructura física del proyecto en Laravel:

```
Mi-proyecto-formativo2/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php       # Manejo de login, registro de clientes y logout
│   │   │   ├── UsuarioController.php    # Panel cliente, reservas, validación de horas, pagos y facturación
│   │   │   ├── AdminController.php      # Panel administrativo, gestión de reservas, clientes, servicios y pagos
│   │   │   └── Controller.php           # Controlador base
│   │   └── Middleware/                  # Middlewares de seguridad (auth.cliente, auth.admin)
│   └── Models/
│       ├── Administrador.php            # Modelo autenticable para tabla `administrador`
│       ├── Cliente.php                  # Modelo autenticable para tabla `cliente`
│       ├── Empleado.php                 # Modelo para tabla `empleados`
│       ├── Servicio.php                 # Modelo para tabla `servicio`
│       ├── Reserva.php                  # Modelo para tabla `reserva`
│       ├── Pago.php                     # Modelo para tabla `pago`
│       └── DetalleServicio.php          # Modelo para tabla `detalle_servicio`
├── bootstrap/
│   └── app.php                          # Configuración de la aplicación Laravel 11
├── config/
│   ├── auth.php                         # Configuración de Guards y Providers (web y admin)
│   ├── database.php                     # Configuración de conexiones MySQL
│   └── app.php
├── database/
│   └── migrations/                      # Definiciones de esquema de BD en código
├── Documentacion/
│   ├── 01_DOCUMENTO_REQUERIMIENTOS_SRS.md
│   ├── 02_DOCUMENTO_DISENO_SISTEMA_SDD.md
│   ├── 03_MANUAL_TECNICO_Y_ARQUITECTURA_LARAVEL.md
│   └── README.md
├── public/
│   ├── index.php                        # Punto de entrada HTTP
│   └── img/                             # Recursos gráficos, logotipos e imágenes de servicios
├── resources/
│   └── views/
│       ├── layouts/                     # Plantillas base (header, sidebar, footer)
│       ├── usuarios/                    # Vistas del cliente (login, registro, agendar, factura, pago, mis-reservas)
│       ├── dashboard/                   # Paneles principales (cliente, admin, catálogo)
│       ├── admin/                       # Vistas administrativas (clientes, reservas, servicios, pagos)
│       └── inicio.blade.php             # Página pública de bienvenida
├── routes/
│   └── web.php                          # Definición de rutas del sistema
└── .env                                 # Variables de entorno de base de datos y app
```

---

## 3. Configuración del Multi-Guard de Autenticación

Para separar con rigurosidad las sesiones de clientes y administradores, se implementó en `config/auth.php` un sistema de dos *guards* independientes:

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'clientes',
    ],
    'admin' => [
        'driver' => 'session',
        'provider' => 'administradores',
    ],
],

'providers' => [
    'clientes' => [
        'driver' => 'eloquent',
        'model' => App\Models\Cliente::class,
    ],
    'administradores' => [
        'driver' => 'eloquent',
        'model' => App\Models\Administrador::class,
    ],
],
```

### Modelos Autenticables:
- **`Cliente.php`:** Extiende de `Illuminate\Foundation\Auth\User as Authenticatable`. Maneja el campo `password` con hash Bcrypt y valida que el campo `activo == 1`.
- **`Administrador.php`:** Extiende de `Authenticatable`. Permite el acceso al panel administrativo sin colisionar con la sesión de un cliente.

---

## 4. Tabla Maestra de Rutas (`routes/web.php`)

| Método | URI | Nombre de Ruta | Controlador y Acción | Middleware / Protección |
|---|---|---|---|---|
| `GET` | `/` | `home` | Clausura (Redirección condicional / Inicio) | Público |
| `GET` | `/login` | `login` | `AuthController@login` | Público |
| `POST` | `/login` | `login.post` | `AuthController@procesarLogin` | Público (CSRF) |
| `GET` | `/registro` | `registro` | `AuthController@mostrarRegistro` | Público |
| `POST` | `/registro` | `registro.post` | `AuthController@procesarRegistro` | Público (CSRF) |
| `ANY` | `/logout` | `logout` | `AuthController@logout` | Público / Autenticado |
| **Rutas del Cliente** | | | | |
| `GET` | `/dashboard` | `cliente.dashboard` | `UsuarioController@dashboard` | `auth.cliente` |
| `GET` | `/reservas/agendar` | `cliente.agendar` | `UsuarioController@agendarCita` | `auth.cliente` |
| `POST` | `/reservas/agendar` | `cliente.agendar.post` | `UsuarioController@agendarCita` | `auth.cliente` |
| `GET` | `/reservas/horas-ocupadas` | `cliente.horasOcupadas` | `UsuarioController@horasOcupadas` | `auth.cliente` (JSON) |
| `GET` | `/mis-reservas` | `cliente.misReservas` | `UsuarioController@misReservas` | `auth.cliente` |
| `GET` | `/pago` | `cliente.pago` | `UsuarioController@pago` | `auth.cliente` |
| `POST` | `/pago/{id}` | `cliente.pago.registrar` | `UsuarioController@registrarPago` | `auth.cliente` |
| `GET` | `/pago/{id}/factura` | `cliente.pago.factura` | `UsuarioController@verFactura` | `auth.cliente` |
| `GET` | `/cancelar-reserva/{id}` | `cliente.cancelarReserva`| `UsuarioController@cancelarReserva` | `auth.cliente` |
| `GET` | `/catalogo` | `cliente.catalogo` | `UsuarioController@catalogo` | `auth.cliente` |
| **Rutas del Administrador** | | | | |
| `GET` | `/admin/dashboard` | `admin.dashboard` | `AdminController@dashboard` | `auth.admin` |
| `GET` | `/admin/clientes` | `admin.clientes` | `AdminController@listarClientes` | `auth.admin` |
| `POST` | `/admin/clientes/toggle/{id}` | `admin.clientes.toggle` | `AdminController@toggleCliente` | `auth.admin` |
| `GET` | `/admin/reservas` | `admin.reservas` | `AdminController@listarReservas` | `auth.admin` |
| `POST` | `/admin/reservas/actualizar` | `admin.reservas.actualizar` | `AdminController@actualizarReserva` | `auth.admin` |
| `GET` | `/admin/servicios` | `admin.servicios` | `AdminController@listarServicios` | `auth.admin` |
| `POST` | `/admin/servicios/guardar` | `admin.servicios.guardar` | `AdminController@guardarServicio` | `auth.admin` |
| `POST` | `/admin/servicios/actualizar` | `admin.servicios.actualizar` | `AdminController@actualizarServicio` | `auth.admin` |
| `POST` | `/admin/servicios/eliminar` | `admin.servicios.eliminar` | `AdminController@eliminarServicio` | `auth.admin` |
| `GET` | `/admin/pagos` | `admin.pagos` | `AdminController@verPagos` | `auth.admin` |
| `GET` | `/admin/pago/{id}/factura` | `admin.pago.factura` | `AdminController@verFacturaAdmin` | `auth.admin` |

---

## 5. Descripción de Controladores y Métodos

### 5.1 `AuthController.php`
- **`login()`**: Verifica si ya existe sesión activa en alguno de los guards; si es admin redirige a `/admin/dashboard`, si es cliente a `/dashboard`. En caso contrario, renderiza `usuarios.login`.
- **`procesarLogin(Request $request)`**:
  1. Valida campos obligatorios.
  2. Intenta autenticación como Administrador en guard `admin` usando `usuario` o `correo`.
  3. Si no coincide, intenta autenticación como Cliente en guard `web` con el correo. Valida que `activo == 1`.
  4. Redirecciona con mensaje de bienvenida o error según corresponda.
- **`mostrarRegistro()`**: Muestra la vista `usuarios.registro`.
- **`procesarRegistro(Request $request)`**: Aplica validaciones (`required`, `email`, `min:8`, `confirmed`), verifica inexistencia previa del correo, cifra la contraseña con `Hash::make()` y crea el cliente con `activo = 1`.
- **`logout(Request $request)`**: Cierra la sesión activa en el guard correspondiente, invalida la sesión HTTP y regenera el token CSRF.

### 5.2 `UsuarioController.php`
- **`dashboard()`**: Carga el resumen de citas pendientes, citas completadas y accesos directos del cliente autenticado.
- **`catalogo()`**: Consulta todos los servicios activos agrupados por categorías para presentación en tarjetas interactivas.
- **`horasOcupadas(Request $request)`**: Endpoint que recibe un parámetro `fecha` vía GET y devuelve un array JSON con las horas en las que ya existen reservas activas (excluyendo canceladas). Esto alimenta el bloqueo dinámico del front-end.
- **`agendarCita(Request $request)`**:
  - En `GET`: Retorna la vista `usuarios.agendar` con el catálogo de servicios.
  - En `POST`: Valida los datos recibidos, verifica que no exista colisión de horario de última hora, crea la reserva en estado `pendiente`, genera el registro en `detalle_servicio` y redirige a la vista de pago de la cita.
- **`misReservas()`**: Carga el listado cronológico de las reservas del cliente con sus estados y botón para descargar/ver factura.
- **`cancelarReserva($id)`**: Permite al cliente anular una reserva propia en estado `pendiente`.
- **`pago(Request $request)`**: Muestra la vista de pago con los datos de la reserva y métodos disponibles (Nequi, Daviplata, Efectivo).
- **`registrarPago(Request $request, $id)`**: Registra la transacción en la tabla `pago`, actualiza el estado de la reserva a `confirmada` y redirige a la factura.
- **`verFactura($id)`**: Renderiza `usuarios.factura`, con maquetación profesional y estilos optimizados para impresión física o PDF.

### 5.3 `AdminController.php`
- **`dashboard()`**: Muestra métricas clave: total de citas del día, ingresos acumulados, número de clientes registrados y servicios más solicitados.
- **`listarClientes()` / `toggleCliente($id)`**: Listado de clientes registrados con opción de suspender o habilitar cuentas (`activo = 1 / 0`).
- **`listarReservas()` / `actualizarReserva(Request $request)`**: Control total de citas para confirmar, reprogramar fecha/hora o marcar como atendida.
- **`listarServicios()` / `guardarServicio()` / `actualizarServicio()` / `eliminarServicio()`**: CRUD completo del portafolio del salón, incluyendo subida de imágenes a `public/img/servicios/`.
- **`verPagos()` / `verFacturaAdmin($id)`**: Auditoría de cobros y facturación global.

---

## 6. Diccionario de Datos Relacional

A continuación se detallan las tablas de la base de datos `aleja-nails`:

### Tabla: `cliente`
| Campo | Tipo | Nulo | Clave | Descripción |
|---|---|---|---|---|
| `id_cliente` | INT(11) AUTO_INCREMENT | NO | PK | Identificador único del cliente |
| `nombre` | VARCHAR(30) | NO | | Nombre completo del cliente |
| `telefono` | VARCHAR(15) | SÍ | | Número de contacto telefónico / WhatsApp |
| `correo` | VARCHAR(25) | NO | UNIQUE | Correo electrónico para inicio de sesión |
| `password` | VARCHAR(255) | NO | | Contraseña encriptada (Bcrypt) |
| `activo` | TINYINT(1) | NO | | Estado de la cuenta (1: activo, 0: inactivo) |

### Tabla: `administrador`
| Campo | Tipo | Nulo | Clave | Descripción |
|---|---|---|---|---|
| `id_administrador` | INT(11) AUTO_INCREMENT | NO | PK | Identificador del administrador |
| `nombre` | VARCHAR(30) | NO | | Nombre del personal administrativo |
| `usuario` | VARCHAR(20) | NO | UNIQUE | Nombre de usuario para login |
| `correo` | VARCHAR(50) | NO | UNIQUE | Correo de contacto |
| `contrasena` | VARCHAR(255) | NO | | Clave de acceso administrativa |

### Tabla: `servicio`
| Campo | Tipo | Nulo | Clave | Descripción |
|---|---|---|---|---|
| `id_servicio` | INT(11) AUTO_INCREMENT | NO | PK | Identificador único del servicio |
| `nombre_servicio`| VARCHAR(30) | NO | | Título del servicio ofrecido |
| `descripcion` | VARCHAR(255) | SÍ | | Detalle y beneficios del servicio |
| `precio` | DECIMAL(10,0) | NO | | Costo oficial del servicio en COP |
| `categoria` | VARCHAR(50) | SÍ | | Clasificación (Manicura, Pedicura, Capilar, Maquillaje) |
| `imagen` | VARCHAR(255) | SÍ | | Ruta o nombre del archivo de imagen en servidor |
| `id_administrador`| INT(11) | SÍ | FK | Administrador que registró el servicio |

### Tabla: `reserva`
| Campo | Tipo | Nulo | Clave | Descripción |
|---|---|---|---|---|
| `id_reserva` | INT(11) AUTO_INCREMENT | NO | PK | Código único de la cita |
| `fecha` | VARCHAR(20) | NO | | Fecha programada (formato YYYY-MM-DD) |
| `hora` | VARCHAR(10) | NO | | Bloque de horario asignado (HH:MM) |
| `estado` | VARCHAR(25) | NO | | Estado: `pendiente`, `confirmada`, `cancelada`, `completada` |
| `id_cliente` | INT(11) | NO | FK | Cliente titular de la reserva |
| `id_servicio` | INT(11) | NO | FK | Servicio seleccionado |
| `id_empleados` | INT(11) | SÍ | FK | Estilista o profesional asignado |

### Tabla: `pago`
| Campo | Tipo | Nulo | Clave | Descripción |
|---|---|---|---|---|
| `id_pago` | INT(11) AUTO_INCREMENT | NO | PK | Identificador del comprobante de pago |
| `fecha_pago` | VARCHAR(20) | NO | | Fecha en que se efectuó el pago |
| `metodo_pago` | VARCHAR(25) | NO | | Modalidad: `Transferencia`, `Efectivo`, `Nequi`, `Daviplata` |
| `valor_pagado` | DECIMAL(10,0) | NO | | Importe total liquidado |
| `id_reserva` | INT(11) | NO | FK | Reserva asociada al pago |

### Tabla: `detalle_servicio`
| Campo | Tipo | Nulo | Clave | Descripción |
|---|---|---|---|---|
| `id_detalle_servicio` | INT(11) AUTO_INCREMENT | NO | PK | Identificador de línea de detalle |
| `id_reserva` | INT(11) | NO | FK | Cita asociada |
| `id_servicio` | INT(11) | NO | FK | Servicio brindado |
| `cantidad` | VARCHAR(20) | NO | | Unidades o sesiones solicitadas |
| `precio_unitario` | DECIMAL(10,0) | NO | | Precio unitario al momento de apartar cita |
| `subtotal` | DECIMAL(10,0) | NO | | Monto acumulado de la línea |

### Tabla: `empleados`
| Campo | Tipo | Nulo | Clave | Descripción |
|---|---|---|---|---|
| `id_empleados` | INT(11) AUTO_INCREMENT | NO | PK | Identificador del empleado/estilista |
| `nombre` | VARCHAR(30) | NO | | Nombre completo del colaborador |
| `telefono` | VARCHAR(15) | SÍ | | Teléfono de contacto |
| `id_administrador`| INT(11) | SÍ | FK | Administrador responsable |

---

## 7. Guía de Instalación y Puesta en Marcha Local

### Prerrequisitos:
- Laragon instalado en Windows (o XAMPP/WAMP con PHP 8.2+ y MySQL 8.0).
- Composer 2.x instalado globalmente.

### Pasos de Despliegue:

1. **Ubicación del Proyecto:**
   Copiar o clonar la carpeta del proyecto dentro de la raíz web del servidor local:
   `c:\laragon\www\Mi-proyecto-formativo2`

2. **Instalación de Dependencias:**
   Abrir terminal en la carpeta raíz y ejecutar:
   ```bash
   composer install
   ```

3. **Configuración de Variables de Entorno (`.env`):**
   Verificar que el archivo `.env` apunte a la base de datos de Laragon:
   ```env
   APP_NAME="Style-Nails"
   APP_ENV=local
   APP_KEY=base64:...
   APP_DEBUG=true
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=aleja-nails
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generación de Llave de Aplicación y Migraciones:**
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

5. **Iniciar el Servidor de Desarrollo:**
   ```bash
   php artisan serve
   ```
   Acceder desde el navegador a: `http://127.0.0.1:8000`

---

## 8. Cuentas de Acceso para Pruebas del Sistema

| Rol | Usuario / Correo | Contraseña | Destino tras Login |
|---|---|---|---|
| **Administrador** | `admin` (o correo admin configurado) | *(Contraseña configurada en BD)* | `/admin/dashboard` |
| **Cliente de Prueba** | Registro directo desde `/registro` | *(Mínimo 8 caracteres)* | `/dashboard` |
