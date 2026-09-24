# Evidencia 02: Documento de Diseño del Sistema (SDD)
## Software Design Document — **Style-Nails / Aleja-Nails**

---

### Portada Institucional

| Información Académica y del Proyecto |
|---|
| **Programa de Formación:** Tecnólogo en Análisis y Desarrollo de Software (ADSO) |
| **Ficha:** 3230026 |
| **Centro de Formación:** Centro de Formación Agroindustrial – Regional Huila |
| **Institución:** Servicio Nacional de Aprendizaje (SENA) |
| **Presentado Por:** Nicolle Suache Vanegas |
| **Presentado a:** Celia Andrea Saab Cano (Instructora) |
| **Fecha:** Marzo de 2026 |

---

## Tabla de Contenido

1. [Diagramas de Secuencia](#1-diagramas-de-secuencia)
   - 1.1 [Inicio de Sesión](#11-inicio-de-sesión)
   - 1.2 [Registro de Cliente](#12-registro-de-cliente)
   - 1.3 [Gestión de Servicios](#13-gestión-de-servicios)
   - 1.4 [Agendamiento de Citas (Reservas)](#14-agendamiento-de-citas-reservas)
2. [Diagrama de Paquetes](#2-diagrama-de-paquetes)
3. [Diagrama de Despliegue](#3-diagrama-de-despliegue)
4. [Diagrama de Componentes](#4-diagrama-de-componentes)
5. [Diagrama de Clases (UML)](#5-diagrama-de-clases)
6. [Diagrama de Casos de Uso](#6-diagrama-de-casos-de-uso)
7. [Diagramas de Actividades](#7-diagramas-de-actividades)
   - 7.1 [Actividad: Inicio de Sesión](#71-actividad-inicio-de-sesión)
   - 7.2 [Actividad: Registro](#72-actividad-registro)
   - 7.3 [Actividad: Gestión de Servicios](#73-actividad-gestión-de-servicios)
   - 7.4 [Actividad: Agendar Cita](#74-actividad-agendar-cita)
8. [Diagrama Entidad-Relación (DER)](#8-diagrama-entidad-relación-der)

---

## 1. Diagramas de Secuencia

### 1.1 Inicio de Sesión
Representa el flujo de autenticación del usuario (cliente o administrador) desde la interfaz visual hasta la base de datos con verificación de hash criptográfico.

```mermaid
sequenceDiagram
    autonumber
    actor Usuario
    participant Frontend as Frontend / Blade View
    participant Controller as AuthController (Laravel)
    participant BD as Base de Datos MySQL

    Usuario->>Frontend: Ingresar credenciales (correo/usuario y clave)
    Frontend->>Controller: POST /login (credenciales + token CSRF)
    Controller->>BD: SELECT * FROM administrador / cliente WHERE correo=?
    BD-->>Controller: Datos usuario + hash contraseña
    Controller->>Controller: Verificar contraseña (password_verify / bcrypt)
    
    alt Credenciales Válidas
        Controller-->>Frontend: 200 OK + Sesión iniciada (Guard web/admin)
        Frontend-->>Usuario: Redirigir según rol (/dashboard o /admin/dashboard)
    else Credenciales Inválidas o Cuenta Inactiva
        Controller-->>Frontend: 401 Credenciales incorrectas / Cuenta inactiva
        Frontend-->>Usuario: Mostrar alerta de error
    end
```

---

### 1.2 Registro de Cliente
Representa el proceso mediante el cual un visitante crea una nueva cuenta en la plataforma.

```mermaid
sequenceDiagram
    autonumber
    actor Cliente
    participant Frontend as Frontend / Blade Form
    participant Controller as AuthController (Laravel)
    participant BD as Base de Datos MySQL

    Cliente->>Frontend: Completar formulario (nombre, correo, teléfono, password)
    Frontend->>Controller: POST /registro
    Controller->>BD: SELECT id_cliente FROM cliente WHERE correo=?
    
    alt Correo ya registrado
        BD-->>Controller: Registro existente
        Controller-->>Frontend: 400 Bad Request ("Ese correo ya está registrado")
        Frontend-->>Cliente: Mostrar notificación de advertencia
    else Correo disponible
        BD-->>Controller: null (No existe)
        Controller->>Controller: Encriptar contraseña (Hash::make / bcrypt)
        Controller->>BD: INSERT INTO cliente (nombre, correo, telefono, password, activo)
        BD-->>Controller: OK, id_cliente generado
        Controller-->>Frontend: 201 Redirección con mensaje flash exitoso
        Frontend-->>Cliente: Cuenta creada con éxito / Ingreso al login
    end
```

---

### 1.3 Gestión de Servicios
Muestra las operaciones que realiza el Administrador sobre el catálogo de servicios (creación, edición, borrado).

```mermaid
sequenceDiagram
    autonumber
    actor Admin
    participant Frontend as Panel Admin / Servicios
    participant Controller as AdminController
    participant BD as Base de Datos MySQL

    Admin->>Frontend: Acceder al módulo de catálogo
    Frontend->>Controller: GET /admin/servicios
    Controller->>BD: SELECT * FROM servicio
    BD-->>Controller: Lista de servicios
    Controller-->>Frontend: Renderizar tabla de servicios
    Frontend-->>Admin: Catálogo visible

    alt Crear Nuevo Servicio
        Admin->>Frontend: Formulario nuevo servicio (nombre, precio, img)
        Frontend->>Controller: POST /admin/servicios/guardar
        Controller->>BD: INSERT INTO servicio (...)
        BD-->>Controller: Confirmación INSERT
        Controller-->>Frontend: Servicio creado exitosamente
    else Editar Servicio
        Admin->>Frontend: Modificar datos de servicio
        Frontend->>Controller: POST /admin/servicios/actualizar
        Controller->>BD: UPDATE servicio SET ... WHERE id_servicio=?
        BD-->>Controller: Confirmación UPDATE
        Controller-->>Frontend: Servicio actualizado
    else Eliminar Servicio
        Admin->>Frontend: Clic en eliminar servicio
        Frontend->>Controller: POST /admin/servicios/eliminar
        Controller->>BD: DELETE FROM servicio WHERE id_servicio=?
        BD-->>Controller: Confirmación DELETE
        Controller-->>Frontend: Servicio eliminado del catálogo
    end
```

---

### 1.4 Agendamiento de Citas (Reservas)
Muestra el flujo de selección de servicio, consulta asíncrona de disponibilidad, persistencia de reserva y confirmación.

```mermaid
sequenceDiagram
    autonumber
    actor Cliente
    participant Frontend as Frontend / Agendar Cita
    participant Controller as UsuarioController
    participant BD as Base de Datos MySQL
    participant Notif as Módulo de Notificaciones

    Cliente->>Frontend: Seleccionar servicio y fecha
    Frontend->>Controller: GET /reservas/horas-ocupadas?fecha=YYYY-MM-DD
    Controller->>BD: SELECT hora FROM reserva WHERE fecha=? AND estado != 'cancelada'
    BD-->>Controller: Lista de horas ocupadas
    
    alt Hay horarios libres
        Controller-->>Frontend: JSON [horas ocupadas]
        Frontend-->>Cliente: Calendario habilitado con horas disponibles
        Cliente->>Frontend: Seleccionar hora y enviar reserva
        Frontend->>Controller: POST /reservas/agendar
        Controller->>BD: INSERT INTO reserva (fecha, hora, id_cliente, id_servicio, estado)
        BD-->>Controller: OK, id_reserva generado
        Controller->>BD: INSERT INTO detalle_servicio (...)
        Controller->>Notif: Generar confirmación de cita
        Notif-->>Cliente: Notificación / Comprobante listo
        Controller-->>Frontend: Redirigir a Pasarela de Pago / Mis Reservas
        Frontend-->>Cliente: Cita agendada exitosamente
    else Sin disponibilidad
        Controller-->>Frontend: Todos los cupos asignados
        Frontend-->>Cliente: Informar día completo / Elegir otra fecha
    end
```

---

## 2. Diagrama de Paquetes

Organización modular del sistema bajo la arquitectura en capas del framework Laravel (Modelo-Vista-Controlador):

```mermaid
graph TD
    subgraph Vistas ["«views» Vistas (Blade / HTML / CSS / JS)"]
        V_Auth["auth (login, registro)"]
        V_Dash["dashboard (cliente, admin)"]
        V_Book["reservas (agendar, mis-reservas)"]
        V_Cat["catalogo (servicios)"]
        V_Admin["admin (clientes, servicios, reservas, pagos)"]
        V_Pay["facturas (pago, comprobante)"]
    end

    subgraph Controladores ["«controllers» Lógica de Negocio"]
        C_Auth["AuthController"]
        C_User["UsuarioController"]
        C_Admin["AdminController"]
    end

    subgraph Middleware ["«middleware» Seguridad y Filtros"]
        M_Admin["auth.admin (Guard Admin)"]
        M_Client["auth.cliente (Guard Web)"]
        M_CSRF["VerifyCsrfToken"]
    end

    subgraph Modelos ["«models» Entidades Eloquent ORM"]
        M_Adm["Administrador"]
        M_Cli["Cliente"]
        M_Res["Reserva"]
        M_Ser["Servicio"]
        M_Det["DetalleServicio"]
        M_Pag["Pago"]
        M_Emp["Empleado"]
    end

    subgraph BaseDatos ["«database» Persistencia MySQL"]
        DB[(MySQL Database)]
    end

    Vistas -->|Peticiones HTTP/Formularios| Middleware
    Middleware --> Controladores
    Controladores -->|Manipula entidades| Modelos
    Modelos -->|Consultas SQL / PDO| BaseDatos
    Controladores -->|Retorna respuestas y vistas| Vistas
```

---

## 3. Diagrama de Despliegue

Topología física y lógica de la infraestructura de ejecución del sistema:

```mermaid
graph TD
    subgraph Cliente ["Dispositivo Cliente (PC / Smartphone / Tablet)"]
        Navegador["Navegador Web (Chrome, Edge, Safari)<br>HTML5 / CSS3 / Vanilla JS"]
    end

    subgraph ServidorApp ["Servidor Web y de Aplicación (Laragon / Apache)"]
        Apache["Servidor Web Apache / Nginx"]
        LaravelRuntime["Entorno PHP 8.2+ / Laravel 11 Engine"]
        subgraph LaravelApp ["Componentes del Sistema"]
            Router["Routing & Middleware"]
            AppControllers["Controladores (Auth, Usuario, Admin)"]
            Eloquent["Eloquent ORM Engine"]
        end
    end

    subgraph ServidorBD ["Servidor de Base de Datos"]
        MySQL[("Motor MySQL 8.0 / MariaDB<br>Base de datos: aleja-nails")]
    end

    subgraph ServiciosExternos ["Servicios Complementarios"]
        NotifService["Servicio de Notificación / WhatsApp / Email"]
    end

    Navegador -- "HTTPS / TLS 1.3 (Peticiones GET/POST)" --> Apache
    Apache --> LaravelRuntime
    LaravelRuntime --> Router
    Router --> AppControllers
    AppControllers --> Eloquent
    Eloquent -- "Conexión TCP / Socket (Puerto 3306)" --> MySQL
    AppControllers -. "Alertas y confirmaciones" .-> NotifService
```

---

## 4. Diagrama de Componentes

Muestra la organización e interdependencia de los módulos de software:

```mermaid
graph LR
    subgraph UI ["Capa de Presentación (Blade Templates)"]
        UI_Login["login.blade.php / registro.blade.php"]
        UI_Reservas["agendar.blade.php / mis-reservas.blade.php"]
        UI_Catalogo["catalogo.blade.php / servicios.blade.php"]
        UI_Admin["admin.blade.php / clientes.blade.php / pagos.blade.php"]
        UI_Factura["factura.blade.php / pago.blade.php"]
    end

    subgraph Interceptores ["Capa de Intercepción"]
        Mid_Auth["Middleware de Autenticación<br>(auth.cliente / auth.admin)"]
        Mid_CSRF["Middleware CSRF Protection"]
    end

    subgraph Logica ["Capa de Controladores (Lógica de Aplicación)"]
        Ctrl_Auth["AuthController"]
        Ctrl_User["UsuarioController"]
        Ctrl_Admin["AdminController"]
    end

    subgraph Datos ["Capa de Acceso a Datos (Modelos)"]
        Mod_Cliente["Model Cliente"]
        Mod_Admin["Model Administrador"]
        Mod_Reserva["Model Reserva"]
        Mod_Servicio["Model Servicio"]
        Mod_Pago["Model Pago"]
        Mod_Detalle["Model DetalleServicio"]
    end

    subgraph Storage ["Almacenamiento Físico"]
        BD_MySQL[("Base de Datos MySQL")]
        Disk_Media["Almacenamiento Local (public/img)"]
    end

    UI --> Mid_CSRF
    Mid_CSRF --> Mid_Auth
    Mid_Auth --> Ctrl_Auth
    Mid_Auth --> Ctrl_User
    Mid_Auth --> Ctrl_Admin

    Ctrl_Auth --> Mod_Cliente
    Ctrl_Auth --> Mod_Admin
    Ctrl_User --> Mod_Reserva
    Ctrl_User --> Mod_Servicio
    Ctrl_User --> Mod_Pago
    Ctrl_User --> Mod_Detalle
    Ctrl_Admin --> Mod_Servicio
    Ctrl_Admin --> Mod_Cliente
    Ctrl_Admin --> Mod_Reserva

    Ctrl_Admin --> Disk_Media

    Mod_Cliente --> BD_MySQL
    Mod_Admin --> BD_MySQL
    Mod_Reserva --> BD_MySQL
    Mod_Servicio --> BD_MySQL
    Mod_Pago --> BD_MySQL
    Mod_Detalle --> BD_MySQL
```

---

## 5. Diagrama de Clases (UML)

Modelo estático de datos con atributos, tipos y relaciones estructurales:

```mermaid
classDiagram
    class Cliente {
        +int id_cliente
        +string nombre
        +string correo
        +string telefono
        +string password
        +int activo
        +registrarse()
        +iniciarSesion()
        +agendarCita()
        +consultarMisReservas()
    }

    class Administrador {
        +int id_administrador
        +string nombre
        +string usuario
        +string correo
        +string contrasena
        +gestionarServicios()
        +administrarAgenda()
        +confirmarPago()
        +toggleClienteEstado()
    }

    class Servicio {
        +int id_servicio
        +string nombre_servicio
        +string descripcion
        +decimal precio
        +string categoria
        +string imagen
        +int id_administrador
        +crearServicio()
        +actualizarServicio()
        +eliminarServicio()
    }

    class Reserva {
        +int id_reserva
        +string fecha
        +string hora
        +string estado
        +int id_cliente
        +int id_servicio
        +int id_empleados
        +confirmarReserva()
        +cancelarReserva()
        +reprogramarReserva()
    }

    class DetalleServicio {
        +int id_detalle_servicio
        +int id_reserva
        +int id_servicio
        +string cantidad
        +decimal precio_unitario
        +decimal subtotal
    }

    class Pago {
        +int id_pago
        +string fecha_pago
        +string metodo_pago
        +decimal valor_pagado
        +int id_reserva
        +registrarPago()
        +generarComprobante()
    }

    class Empleado {
        +int id_empleados
        +string nombre
        +string telefono
        +int id_administrador
        +consultarAgenda()
    }

    Cliente "1" --> "0..*" Reserva : realiza
    Servicio "1" --> "0..*" Reserva : se reserva en
    Reserva "1" --> "0..1" Pago : genera
    Reserva "1" --> "1..*" DetalleServicio : contiene
    Servicio "1" --> "0..*" DetalleServicio : describe
    Empleado "0..1" --> "0..*" Reserva : atiende
    Administrador "1" --> "0..*" Servicio : administra
    Administrador "1" --> "0..*" Empleado : coordina
```

---

## 6. Diagrama de Casos de Uso

```mermaid
flowchart TD
    subgraph Actores
        ClienteAct["👤 Cliente"]
        AdminAct["👤 Administrador"]
        EmpleadoAct["👤 Empleado / Estilista"]
    end

    subgraph Sistema ["Sistema de Gestión Style-Nails"]
        CU_Reg["Registrarse en el sistema"]
        CU_Login["Iniciar sesión"]
        CU_Guardar["Guardar datos de usuario"]
        CU_ValCred["Validar credenciales"]
        CU_Cat["Consultar catálogo de servicios"]
        CU_Buscar["Buscar / Filtrar servicios"]
        CU_Res["Reservar cita"]
        CU_ValDisp["Verificar disponibilidad de horarios"]
        CU_Canc["Cancelar cita"]
        CU_MisCitas["Consultar mis reservas"]
        CU_Pago["Registrar pago / Descargar factura"]

        CU_Prog["Programar / Reprogramar citas"]
        CU_GestServ["Gestionar catálogo de servicios (CRUD)"]
        CU_GestEmp["Gestionar empleados"]
        CU_GestCli["Activar / Desactivar clientes"]
        CU_Rep["Generar reportes y arqueo de pagos"]
        CU_AgendaEmp["Consultar agenda de citas asignadas"]
    end

    ClienteAct --> CU_Reg
    ClienteAct --> CU_Login
    ClienteAct --> CU_Cat
    ClienteAct --> CU_Buscar
    ClienteAct --> CU_Res
    ClienteAct --> CU_Canc
    ClienteAct --> CU_MisCitas
    ClienteAct --> CU_Pago

    AdminAct --> CU_Login
    AdminAct --> CU_Prog
    AdminAct --> CU_GestServ
    AdminAct --> CU_GestEmp
    AdminAct --> CU_GestCli
    AdminAct --> CU_Rep
    AdminAct --> CU_Cat

    EmpleadoAct --> CU_Login
    EmpleadoAct --> CU_AgendaEmp

    CU_Reg -. "«include»" .-> CU_Guardar
    CU_Login -. "«include»" .-> CU_ValCred
    CU_Res -. "«include»" .-> CU_ValDisp
```

---

## 7. Diagramas de Actividades

### 7.1 Actividad: Inicio de Sesión

```mermaid
flowchart TD
    Start([Inicio]) --> Input[Ingresar correo/usuario y contraseña]
    Input --> Validar{¿Credenciales diligenciadas?}
    Validar -- No --> ShowErr[Mostrar alerta: Diligencie todos los campos]
    ShowErr --> Input
    Validar -- Sí --> DBCheck{¿Credenciales válidas en BD?}
    DBCheck -- No --> CredErr[Mostrar error: Usuario o contraseña incorrectos]
    CredErr --> Input
    DBCheck -- Sí --> EvalRol{Evaluar Rol}
    
    EvalRol -- Administrador --> PanelAdmin[Cargar Panel Administrador /admin/dashboard]
    EvalRol -- Cliente --> CheckActivo{¿Cliente Activo?}
    
    CheckActivo -- No --> BlockUser[Mostrar mensaje: Tu cuenta está desactivada]
    BlockUser --> Input
    CheckActivo -- Sí --> PanelCli[Cargar Dashboard Cliente /dashboard]
    
    EvalRol -- Empleado --> AgendaEmp[Cargar Agenda de Citas del Empleado]
    
    PanelAdmin --> Fin([Sesión Iniciada con Éxito])
    PanelCli --> Fin
    AgendaEmp --> Fin
```

---

### 7.2 Actividad: Registro

```mermaid
flowchart TD
    Start([Inicio]) --> Form[Acceder al formulario de registro]
    Form --> Diligenciar[Completar datos: Nombre, Correo, Teléfono, Contraseña]
    Diligenciar --> ValCampos{¿Datos válidos y contraseña >= 8 carácteres?}
    ValCampos -- No --> ErrVal[Mostrar mensaje de error específico]
    ErrVal --> Diligenciar
    ValCampos -- Sí --> CheckDup{¿Correo ya registrado en BD?}
    CheckDup -- Sí --> ErrDup[Notificar: Ese correo ya está en uso]
    ErrDup --> Diligenciar
    CheckDup -- No --> HashPw[Cifrar contraseña con Bcrypt]
    HashPw --> SaveUser[Insertar cliente en BD con activo = 1]
    SaveUser --> MsgExito[Mostrar mensaje: Registro exitoso]
    MsgExito --> RedirectLogin[Redirigir a pantalla de Login]
    RedirectLogin --> Fin([Fin])
```

---

### 7.3 Actividad: Gestión de Servicios

```mermaid
flowchart TD
    Start([Inicio]) --> Acceso[Admin accede a Gestión de Servicios]
    Acceso --> Decision{¿Qué acción desea realizar?}
    
    Decision -- Registrar Servicio --> FormNuevo[Ingresar nombre, descripción, precio, categoría y foto]
    FormNuevo --> SaveDB[Validar y guardar en BD + Subir imagen]
    
    Decision -- Editar Servicio --> FormEdit[Modificar valores existentes del servicio]
    FormEdit --> UpdateDB[Actualizar registro en base de datos]
    
    Decision -- Eliminar Servicio --> ConfirmDel{¿Confirmar eliminación?}
    ConfirmDel -- Sí --> DeleteDB[Eliminar registro de la tabla servicio]
    ConfirmDel -- No --> Acceso
    
    SaveDB --> Refresh[Actualizar catálogo visible para clientes]
    UpdateDB --> Refresh
    DeleteDB --> Refresh
    Refresh --> Fin([Operación Completada])
```

---

### 7.4 Actividad: Agendar Cita

```mermaid
flowchart TD
    Start([Inicio]) --> SelServicio[Cliente selecciona servicio del catálogo]
    SelServicio --> SelFecha[Seleccionar fecha en el calendario]
    SelFecha --> Consultar[Consultar horarios disponibles en tiempo real]
    Consultar --> DispCheck{¿Hay horarios libres para esa fecha?}
    
    DispCheck -- No --> SinCupo[Mostrar alerta: Sin turnos disponibles para este día]
    SinCupo --> SelFecha
    
    DispCheck -- Sí --> SelHora[Cliente selecciona hora libre disponible]
    SelHora --> Confirmar[Hacer clic en Confirmar Reserva]
    Confirmar --> DoubleCheck{¿Horario sigue libre?}
    
    DoubleCheck -- Conflicto simultáneo --> ErrorConflicto[Error: Horario acaba de ser reservado]
    ErrorConflicto --> Consultar
    
    DoubleCheck -- Libre --> Guardar[Insertar reserva en estado pendiente]
    Guardar --> GuardarDetalle[Crear detalle_servicio]
    GuardarDetalle --> OpcPago[Ofrecer opciones de pago: Transferencia / Efectivo]
    OpcPago --> Factura[Generar vista de factura / comprobante]
    Factura --> Fin([Cita Agendada Exitosamente])
```

---

## 8. Diagrama Entidad-Relación (DER)

Representación del esquema relacional implementado en la base de datos MySQL `aleja-nails`:

```mermaid
erDiagram
    ADMINISTRADOR ||--o{ SERVICIO : gestiona
    ADMINISTRADOR ||--o{ EMPLEADOS : supervisa
    CLIENTE ||--o{ RESERVA : solicita
    SERVICIO ||--o{ RESERVA : incluye
    RESERVA ||--o| PAGO : genera
    RESERVA ||--o{ DETALLE_SERVICIO : contiene
    SERVICIO ||--o{ DETALLE_SERVICIO : referencia
    EMPLEADOS ||--o{ RESERVA : asignado_a

    ADMINISTRADOR {
        int id_administrador PK
        varchar_30 nombre
        varchar_20 usuario
        varchar_50 correo
        varchar_255 contrasena
    }

    CLIENTE {
        int id_cliente PK
        varchar_30 nombre
        varchar_15 telefono
        varchar_25 correo
        varchar_255 password
        int activo
    }

    EMPLEADOS {
        int id_empleados PK
        varchar_30 nombre
        varchar_15 telefono
        int id_administrador FK
    }

    SERVICIO {
        int id_servicio PK
        varchar_30 nombre_servicio
        varchar_255 descripcion
        decimal precio
        varchar_50 categoria
        varchar_255 imagen
        int id_administrador FK
    }

    RESERVA {
        int id_reserva PK
        varchar_20 fecha
        varchar_10 hora
        varchar_25 estado
        int id_cliente FK
        int id_servicio FK
        int id_empleados FK
    }

    DETALLE_SERVICIO {
        int id_detalle_servicio PK
        int id_reserva FK
        int id_servicio FK
        varchar_20 cantidad
        decimal precio_unitario
        decimal subtotal
    }

    PAGO {
        int id_pago PK
        varchar_20 fecha_pago
        varchar_25 metodo_pago
        decimal valor_pagado
        int id_reserva FK
    }
```
