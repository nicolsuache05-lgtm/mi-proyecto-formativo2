# Documento de Requerimientos de Software (SRS / ERS)
## Sistema de Gestión para Salón de Belleza — **Style-Nails (Aleja-Nails)**

---

### Portada y Control del Documento

| Campo | Detalle |
|---|---|
| **Proyecto:** | Style-Nails (Aleja-Nails) |
| **Documento:** | Especificación de Requerimientos de Software (SRS / ERS) |
| **Programa de Formación:** | Tecnólogo en Análisis y Desarrollo de Software (ADSO) |
| **Ficha:** | 3230026 |
| **Centro de Formación:** | Centro de Formación Agroindustrial – Regional Huila (La Angostura) |
| **Entidad:** | Servicio Nacional de Aprendizaje (SENA) |
| **Autor(a) / Líder de Proyecto:** | Nicolle Xiomara Suache Vanegas |
| **Cliente / Patrocinadora:** | Lugdy Alejandra Vanegas Olaya |
| **Instructora:** | Celia Andrea Saab Cano |
| **Fecha de Elaboración:** | 22 de Septiembre de 2025 / Actualizado 2026 |
| **Versión:** | 1.0 (Definitiva) |

---

### Historial de Versiones

| Fecha | Versión | Autor | Organización | Descripción del Cambio |
|---|---|---|---|---|
| 22/09/2025 | 0.1 | Nicolle Xiomara Suache Vanegas | Aleja-Nails / SENA | Borrador inicial del documento de requerimientos. |
| 15/11/2025 | 0.2 | Nicolle Xiomara Suache Vanegas | Aleja-Nails / SENA | Ajuste de reglas de negocio, detalle de pasarela de pago y catálogo de servicios. |
| 24/03/2026 | 1.0 | Nicolle Xiomara Suache Vanegas | Aleja-Nails / SENA | Versión final adaptada a la implementación completa sobre Laravel y MySQL. |

---

### Información del Proyecto y Aprobaciones

| Rol en el Proyecto | Nombre y Apellidos | Cargo / Organización |
|---|---|---|
| **Cliente / Patrocinadora:** | Lugdy Alejandra Vanegas Olaya | Propietaria de Aleja-Nails |
| **Líder de Proyecto / Analista:** | Nicolle Xiomara Suache Vanegas | Aprendiz ADSO - Ficha 3230026 |
| **Instructora / Aprobador:** | Celia Andrea Saab Cano | Instructora SENA - Centro de Formación Agroindustrial |

---

## 1. Propósito

El propósito de este documento es especificar de forma formal, clara y detallada los requerimientos funcionales y no funcionales para el desarrollo del software de gestión y reservas del emprendimiento de belleza **Style-Nails / Aleja-Nails** (Salón de belleza especializado en manicura, pedicura, estilismo capilar y maquillaje).

Este sistema da solución directa a los inconvenientes operativos que enfrenta la administración y propietarios del establecimiento, tales como la pérdida de citas por cruce de horarios, demoras en la atención al cliente, ausencia de un registro centralizado de pagos y falta de un catálogo interactivo disponible las 24 horas del día. Mediante esta plataforma web, se busca brindar una solución ágil, escalable, robusta y con altos estándares de seguridad y usabilidad.

---

## 2. Alcance del Producto / Software

El sistema de información **Style-Nails** abarca la digitalización y optimización de los siguientes procesos clave de la empresa:

1. **Gestión de Identidad y Accesos:** Registro seguro de clientes y autenticación basada en roles (`Administrador`, `Cliente` y consulta de `Empleado/Estilista`).
2. **Catálogo Digital Interactivo:** Publicación de servicios clasificados por categorías (manicura, pedicura, alisados, peinados, maquillaje) con tarifas, tiempos estimados y fotografías.
3. **Agendamiento Automatizado de Citas:** Calendario inteligente con detección de disponibilidad y bloqueo de horas ocupadas en tiempo real para prevenir solapamientos.
4. **Gestión Administrativa Integral:** Panel de control para el administrador que permite aceptar, reprogramar, monitorear o cancelar citas, además de administrar el estado de las cuentas de usuario y el catálogo de servicios.
5. **Módulo de Facturación y Pagos:** Registro de pagos en línea (transferencia digital) o presenciales en efectivo, emisión instantánea de factura con opción de impresión directa y control contable básico.

**Beneficios esperados:**
- Reducción del 90% en el tiempo invertido en la gestión manual de agendas mediante libretas o mensajes desarticulados.
- Disponibilidad 24/7 para que los clientes agenden citas desde cualquier dispositivo móvil o computador.
- Trazabilidad total de pagos y reservas realizadas.

---

## 3. Clases y Características de Usuarios

| Rol de Usuario | Características y Nivel Técnico | Funcionalidades Principales | Privilegios de Seguridad |
|---|---|---|---|
| **Cliente** | Usuarios particulares con nivel tecnológico básico-medio que acceden desde smartphones o PCs. Valoran la rapidez y confirmación inmediata. | - Registro e inicio de sesión.<br>- Exploración del catálogo.<br>- Agendamiento de reservas en tiempo real.<br>- Consulta de citas en "Mis Reservas".<br>- Registro de comprobante de pago y descarga de factura. | Acceso restringido exclusivamente a sus datos personales, citas propias y facturas. No puede acceder a datos de terceros ni a funciones de administración. |
| **Administrador** | Administradora y dueña del salón (Lugdy Alejandra). Nivel de experiencia medio en gestión operativa. | - Acceso total al panel de administración.<br>- Gestión de usuarios (activar/desactivar clientes).<br>- CRUD completo de servicios (fotos, precios, categorías).<br>- Control total de reservas (aceptar, reprogramar, cancelar).<br>- Auditoría de pagos e impresión de facturas. | Privilegios de superusuario (`guard: admin`). Acceso a todos los módulos y reportes. |
| **Empleado / Estilista** | Personal operativo del salón (manicuristas, estilistas). Nivel de experiencia básico. | - Consulta de su agenda de trabajo asignada.<br>- Visualización de citas diarias y semanales con detalle de servicio y cliente. | Acceso de solo lectura a su cronograma asignado. No tiene permisos para modificar tarifas, crear ni cancelar citas. |

---

## 4. Entorno Operativo

- **Hardware compatible:** Computadores de escritorio, portátiles, tablets y smartphones (diseño 100% responsivo adaptable a pantallas desde 320px de ancho).
- **Sistemas Operativos compatibles:** Windows 10/11, macOS, Linux, Android 8+ y iOS 13+.
- **Navegadores web:** Google Chrome (versión 100+), Microsoft Edge, Mozilla Firefox, Safari, Brave.
- **Conectividad:** Conexión a internet estable (red móvil 4G/5G o WiFi) para transacciones en tiempo real.
- **Entorno del Servidor:** Servidor web Apache / Nginx, PHP 8.2+, Motor de Base de Datos MySQL 8.0 / MariaDB, soporte para extensiones PDO, OpenSSL, Mbstring y GD.

---

## 5. Descripción de Módulos del Sistema

### 5.1. Módulo de Catálogo de Servicios
- Permite la categorización de servicios: Manicura, Pedicura, Cuidado Capilar/Alisados, Maquillaje y Peinados.
- Exposición pública con descripciones atractivas, precios formateados en moneda colombiana (COP) y duración estimada en minutos.
- Panel administrativo para agregar servicios con carga de imagen (`public/img/servicios/`), edición de costos y baja lógica o eliminación.

### 5.2. Módulo de Reservas y Agenda
- Selección de servicio deseado, fecha y bloque de horario disponible.
- Endpoint asíncrono para verificar horas ya reservadas y deshabilitar opciones colisionadas.
- Visualización de estado de la reserva: `pendiente`, `confirmada`, `cancelada`, `completada`.
- Política de cancelación ágil por parte del cliente o administrador.

### 5.3. Módulo de Facturación y Pagos
- Métodos de pago contemplados: Transferencia bancaria (Nequi, Daviplata, Bancolombia) y Pago presencial en caja/efectivo.
- Registro del comprobante o referencia de pago asociada al ID de reserva.
- Generación de comprobante / factura electrónica simplificada con formato limpio para impresión física o guardado en PDF.

### 5.4. Módulo de Usuarios y Seguridad
- Formulario de registro con validaciones de unicidad de correo y longitud de contraseña.
- Doble guard de autenticación (`auth.cliente` y `auth.admin`) que evita la mezcla de sesiones.
- Encriptación de claves mediante algoritmo Bcrypt / Argon2ID.
- Capacidad administrativa de deshabilitar cuentas que incumplan políticas del salón (`activo = 0`).

---

## 6. Requerimientos Funcionales (RF)

### **REQ-1: Registro de Usuarios en el Sistema**
- **Descripción:** Permitir a nuevos clientes registrarse suministrando sus datos personales para interactuar con la plataforma.
- **Prioridad:** Alta.
- **Entradas:** Nombre completo, teléfono, correo electrónico válido, contraseña y confirmación de contraseña.
- **Comportamiento esperado:** El sistema valida que el correo no se encuentre registrado previamente, comprueba que la contraseña tenga mínimo 8 caracteres y crea el registro con estado `activo = 1`.
- **Salida:** Redirección automática a la vista de login con mensaje flash de confirmación de registro exitoso.

### **REQ-2: Inicio y Cierre de Sesión**
- **Descripción:** Autenticar usuarios en el sistema respetando sus privilegios específicos de acuerdo a su rol.
- **Prioridad:** Alta.
- **Entradas:** Correo electrónico / nombre de usuario y contraseña.
- **Comportamiento esperado:** 
  1. Si las credenciales coinciden con la tabla `administrador`, inicia sesión mediante el guard `admin` y redirige a `/admin/dashboard`.
  2. Si coincide con la tabla `cliente`, verifica que `activo == 1` y que el hash de la clave sea válido; inicia sesión mediante el guard `web` y redirige a `/dashboard`.
  3. Si la cuenta está inactiva o las credenciales no son válidas, rechaza el acceso y muestra un mensaje de alerta.
  4. Al pulsar "Cerrar Sesión", invalida los tokens de sesión y redirige a la página de bienvenida o login.

### **REQ-3: Gestión de Catálogo de Servicios (Administrador)**
- **Descripción:** El administrador podrá crear, actualizar y eliminar servicios del salón.
- **Prioridad:** Media-Alta.
- **Entradas:** Nombre del servicio, descripción, precio, categoría e imagen ilustrativa.
- **Comportamiento esperado:** El sistema valida los campos, almacena la imagen en el directorio público del servidor, guarda o actualiza el registro en la base de datos y refresca el catálogo visible.

### **REQ-4: Visualización Pública del Catálogo de Servicios**
- **Descripción:** Permitir a cualquier visitante o cliente registrado visualizar el catálogo de servicios, precios y características sin barreras de entrada.
- **Prioridad:** Media.
- **Comportamiento esperado:** Carga ágil de fichas de servicios agrupadas o filtradas por categoría, mostrando nombre, imagen, tiempo estimado y precio.

### **REQ-5: Generación y Agendamiento de Citas (Reservas)**
- **Descripción:** El cliente podrá apartar un turno seleccionando el servicio, fecha y hora disponible.
- **Prioridad:** Alta.
- **Entradas:** ID del servicio, fecha de la cita (no anterior al día actual), hora deseada.
- **Comportamiento esperado:** El sistema valida que no exista otra cita asignada para ese mismo horario, crea el registro en la tabla `reserva` con estado inicial `pendiente` y crea el registro en `detalle_servicio`.

### **REQ-6: Consulta de Disponibilidad en Tiempo Real**
- **Descripción:** Evitar cruces de horarios informando al cliente qué horas se encuentran ocupadas para la fecha seleccionada.
- **Prioridad:** Alta.
- **Comportamiento esperado:** Al seleccionar una fecha en el formulario de reserva, una solicitud asíncrona consulta las citas existentes y bloquea visualmente los botones u opciones de horas no disponibles.

### **REQ-7: Registro y Confirmación de Pagos**
- **Descripción:** Registrar el pago de la reserva y generar la respectiva constancia contable.
- **Prioridad:** Alta.
- **Entradas:** ID de la reserva, método de pago (`Transferencia`, `Efectivo`, `Tarjeta`), monto cancelado.
- **Comportamiento esperado:** Se inserta el registro en la tabla `pago`, la reserva actualiza su estado a `confirmada` o `pagada`, y se habilita la visualización de la factura de cobro.

### **REQ-8: Notificaciones y Seguimiento de Reservas**
- **Descripción:** Visualización del estado de las citas en tiempo real tanto para el cliente como para el administrador.
- **Prioridad:** Media-Alta.
- **Comportamiento esperado:** El cliente puede revisar en `/mis-reservas` si su cita fue aceptada, cancelada o atendida. El administrador cuenta con un panel resumen de citas del día y alertas de nuevos pagos por verificar.

---

## 7. Reglas de Negocio (RN)

1. **RN-01 (Autenticación Obligatoria para Reservar):** Únicamente usuarios registrados e identificados pueden reservar turnos en el sistema. Los visitantes no autenticados solo pueden explorar el catálogo.
2. **RN-02 (Unicidad de Horario):** No se permite el registro de dos reservas simultáneas para la misma fecha y bloque horario en el salón.
3. **RN-03 (Exclusividad en Gestión de Contenidos):** Solo los usuarios con rol `Administrador` tienen privilegios para crear, modificar tarifas, eliminar servicios o subir imágenes al catálogo.
4. **RN-04 (Restricción de Perfil Empleado):** El personal estilista/empleado únicamente tiene permisos de consulta sobre las citas programadas asignadas a su nombre, no pudiendo alterar precios ni anular reservas.
5. **RN-05 (Estados de Cita):** Una reserva transita por los estados: `pendiente` → `confirmada` (con pago verificado) → `completada` (servicio prestado). O bien `cancelada`.
6. **RN-06 (Restricción de Clientes Inactivos):** Un cliente con estado `activo = 0` tiene bloqueado el inicio de sesión y no puede realizar nuevas reservas.

---

## 8. Requerimientos de Interfaces Externas

### 8.1. Interfaces de Usuario (UI)
- Interfaz gráfica moderna, elegante y limpia acorde a la identidad corporativa de salón de estética (tonos rosa pastel, fucsia, dorados, blanco y gris neutro).
- Diseño responsivo adaptativo (Mobile-First / Desktop).
- Modales intuitivos para confirmación de cancelaciones y alertas dinámicas de éxito o error.

### 8.2. Interfaces de Software y Base de Datos
- **Framework Back-End:** Laravel 11 (PHP 8.2+).
- **Motor de Base de Datos:** MySQL / MariaDB interactuando a través del ORM Eloquent.
- **Servidor Web:** Apache / Nginx bajo entorno Laragon local o hosting Linux (CPanel / VPS).

### 8.3. Interfaces de Comunicación
- Uso obligatorio de conexiones seguras mediante protocolo HTTPS / SSL.
- Protección contra vulnerabilidades web estándar de OWASP:
  - Tokens CSRF en todos los formularios `POST`/`PUT`.
  - Prevención de inyección SQL mediante sentencias preparadas de Eloquent / PDO.
  - Sanitización y escape de variables contra ataques XSS en plantillas Blade (`{{ $variable }}`).

---

## 9. Requerimientos No Funcionales (RNF)

- **RNF-01 (Usabilidad):** La interfaz debe ser intuitiva, permitiendo a un nuevo usuario registrarse y completar una reserva en menos de 3 minutos sin requerir inducción técnica.
- **RNF-02 (Rendimiento):** El tiempo de respuesta del servidor en solicitudes convencionales debe ser inferior a 1.5 segundos con una conexión a internet convencional.
- **RNF-03 (Disponibilidad):** La plataforma estará disponible el 99.5% del tiempo en régimen de operación 24/7.
- **RNF-04 (Seguridad):** Las contraseñas deben cifrarse obligatoriamente mediante algoritmos robustos (`bcrypt`). No se almacena ninguna clave en texto plano.
- **RNF-05 (Escalabilidad):** La estructura del código bajo el patrón Modelo-Vista-Controlador (MVC) y el motor de migraciones de Laravel debe permitir añadir con facilidad futuros módulos (e.g. recordatorios automáticos por WhatsApp, pasarela tipo Wompi/Stripe, inventario de productos).

---

## 10. Glosario de Términos

- **Cita / Reserva:** Separación formal de un espacio en la agenda del salón en una fecha y hora específica para la prestación de uno o más servicios.
- **Catálogo:** Muestrario digital con el portafolio de servicios ofrecidos, con sus especificaciones de tiempo, descripción e importe.
- **Bcrypt:** Función criptográfica de derivación de claves que incorpora sal (*salt*) para proteger las contraseñas contra ataques de fuerza bruta y tablas arcoíris.
- **Guard:** Componente del sistema de autenticación de Laravel que define cómo se autentican los usuarios para cada solicitud (ej. `web` para clientes, `admin` para administración).
- **Middleware:** Mecanismo de filtrado de solicitudes HTTP que inspecciona y valida el estado de la sesión y roles antes de otorgar acceso a las rutas protegidas.
- **SENA:** Servicio Nacional de Aprendizaje (entidad educativa técnica y tecnológica en Colombia).
