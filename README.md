# 💅 Style-Nails (Aleja-Nails) — Sistema de Gestión y Reservas para Salón de Belleza

<p align="center">
  <img src="public/img/ico.png" alt="Style-Nails Logo" width="120" style="border-radius: 50%;">
</p>

<p align="center">
  <strong>Plataforma web integral para la digitalización de citas, catálogo de servicios, pagos y facturación.</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Laragon-WAMP-007ACC?style=for-the-badge&logo=windows&logoColor=white" alt="Laragon">
  <img src="https://img.shields.io/badge/SENA-ADSO-39A900?style=for-the-badge" alt="SENA">
</p>

---

## 📌 Acerca del Proyecto

**Style-Nails** es un sistema web concebido para optimizar la operativa comercial del salón de belleza y estética **Aleja-Nails**. La solución resuelve problemáticas críticas como el cruce de agendas, la falta de disponibilidad de información de servicios y tarifas las 24 horas y la gestión manual de comprobantes de pago.

Desarrollado como proyecto formativo para el **Tecnólogo en Análisis y Desarrollo de Software (ADSO)** del SENA (Centro de Formación Agroindustrial – Regional Huila, Ficha 3230026).

---

## 🚀 Funcionalidades Principales

### 👤 Para el Cliente:
- **Autenticación Segura:** Registro de usuarios con validaciones estrictas y guard de sesión independiente.
- **Catálogo de Servicios:** Exploración por categorías (Manicura, Pedicura, Cuidado Capilar, Maquillaje y Peinados) con precios y descripciones.
- **Agendamiento Inteligente:** Detección y bloqueo en tiempo real de horarios ocupados para evitar citas duplicadas.
- **Historial de Reservas:** Seguimiento del estado de citas (`pendiente`, `confirmada`, `completada`, `cancelada`).
- **Pasarela de Pago y Facturación:** Métodos de transferencia (Nequi, Daviplata) y presencial en efectivo, con emisión de factura imprimible/descargable en PDF.

### 🛡️ Para el Administrador:
- **Dashboard Estadístico:** Indicadores en tiempo real de citas del día, ingresos, clientes registrados y servicios populares.
- **Control Total de Agenda:** Confirmación, reprogramación de fecha/hora o cancelación de reservas.
- **Gestión de Servicios (CRUD):** Creación, edición y eliminación de servicios con carga dinámica de fotografías.
- **Gestión de Clientes:** Habilitación o suspensión de cuentas (`activo = 1 / 0`).
- **Auditoría de Pagos:** Monitoreo de transferencias y visualización de facturas emitidas.

---

## 📚 Documentación del Proyecto

Toda la documentación técnica y formativa se encuentra organizada en la carpeta [`Documentacion/`](file:///c:/laragon/www/Mi-proyecto-formativo2/Documentacion/README.md):

1. 📄 [Documento de Requerimientos de Software (SRS / ERS)](file:///c:/laragon/www/Mi-proyecto-formativo2/Documentacion/01_DOCUMENTO_REQUERIMIENTOS_SRS.md) — Requerimientos funcionales (REQ-1 a REQ-8), no funcionales, reglas de negocio y alcance formal IEEE 830.
2. 📐 [Documento de Diseño del Sistema (SDD - Evidencia 02)](file:///c:/laragon/www/Mi-proyecto-formativo2/Documentacion/02_DOCUMENTO_DISENO_SISTEMA_SDD.md) — Diagramas Mermaid interactivos: Secuencia, Paquetes, Despliegue, Componentes, Clases UML, Casos de Uso, Actividades y Diagrama Entidad-Relación (DER).
3. 🛠️ [Manual Técnico y de Arquitectura](file:///c:/laragon/www/Mi-proyecto-formativo2/Documentacion/03_MANUAL_TECNICO_Y_ARQUITECTURA_LARAVEL.md) — Explicación de la arquitectura MVC en Laravel 11, multi-guard de autenticación, mapa de rutas, controladores, modelos y diccionario de datos.
4. 📖 [Manual de Usuario](file:///c:/laragon/www/Mi-proyecto-formativo2/Documentacion/04_MANUAL_DE_USUARIO.md) — Guía interactiva ilustrada paso a paso para Clientes y Administrador.

---

## 💻 Requisitos e Instalación Local (Laragon)

### Prerrequisitos:
- PHP 8.2 o superior
- MySQL 8.0 o MariaDB
- Composer 2.x
- Laragon (recomendado en Windows)

### Pasos de Instalación:

1. **Clonar o ubicar el proyecto:**
   Ubicar la carpeta en el directorio `www` de Laragon:
   ```bash
   cd c:\laragon\www\Mi-proyecto-formativo2
   ```

2. **Instalar dependencias de PHP:**
   ```bash
   composer install
   ```

3. **Configurar el entorno `.env`:**
   Crear la base de datos `aleja-nails` en MySQL (vía HeidiSQL, phpMyAdmin o Laragon Database) y configurar:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=aleja-nails
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generar la clave de la aplicación y ejecutar migraciones:**
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

5. **Iniciar el servidor:**
   ```bash
   php artisan serve
   ```
   Abrir en el navegador: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 👥 Créditos y Datos del Proyecto

- **Líder de Proyecto / Desarrolladora:** Nicolle Xiomara Suache Vanegas
- **Cliente:** Lugdy Alejandra Vanegas Olaya (Aleja-Nails)
- **Instructora Evaluadora:** Celia Andrea Saab Cano
- **Programa:** Tecnólogo en Análisis y Desarrollo de Software (ADSO) — SENA Ficha 3230026
