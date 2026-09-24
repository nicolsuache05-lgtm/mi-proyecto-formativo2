# Manual de Usuario del Sistema
## Salón de Belleza Profesional — **Style-Nails (Aleja-Nails)**

---

### Información General
- **Sistema:** Style-Nails
- **Destinatarios:** Clientes del salón y Personal Administrativo
- **Plataforma:** Aplicación Web (disponible en PC, tablets y smartphones)

---

## Índice del Manual
1. [Módulo de Clientes](#1-módulo-de-clientes)
   - 1.1 [Registro de Cuenta Nueva](#11-registro-de-cuenta-nueva)
   - 1.2 [Inicio de Sesión](#12-inicio-de-sesión)
   - 1.3 [Exploración del Catálogo](#13-exploración-del-catálogo)
   - 1.4 [Cómo Agendar una Cita (Paso a Paso)](#14-cómo-agendar-una-cita-paso-a-paso)
   - 1.5 [Gestión de Mis Reservas](#15-gestión-de-mis-reservas)
   - 1.6 [Pasarela de Pago y Factura](#16-pasarela-de-pago-y-factura)
2. [Módulo del Administrador](#2-módulo-del-administrador)
   - 2.1 [Acceso al Panel de Control](#21-acceso-al-panel-de-control)
   - 2.2 [Gestión de Citas y Agenda](#22-gestión-de-citas-y-agenda)
   - 2.3 [Gestión del Catálogo de Servicios (CRUD)](#23-gestión-del-catálogo-de-servicios-crud)
   - 2.4 [Gestión de Clientes (Activación / Suspensión)](#24-gestión-de-clientes-activación--suspensión)
   - 2.5 [Auditoría de Pagos y Facturación](#25-auditoría-de-pagos-y-facturación)
3. [Preguntas Frecuentes y Solución de Problemas](#3-preguntas-frecuentes-y-solución-de-problemas)

---

## 1. Módulo de Clientes

### 1.1 Registro de Cuenta Nueva
1. Ingrese a la plataforma y haga clic en **"Registrarse"** en la barra superior o en el enlace del formulario de login.
2. Complete los campos requeridos:
   - **Nombre:** Su nombre completo.
   - **Teléfono:** Número móvil o WhatsApp de contacto.
   - **Correo Electrónico:** Dirección de correo activa (será su usuario de acceso).
   - **Contraseña:** Mínimo 8 caracteres seguros.
   - **Confirmar Contraseña:** Vuelva a escribir la misma contraseña.
3. Presione el botón **"Crear Cuenta"**. Al finalizar, el sistema confirmará el registro y lo dirigirá al formulario de inicio de sesión.

### 1.2 Inicio de Sesión
1. En la pantalla de login, introduzca su correo registrado y contraseña.
2. Haga clic en **"Iniciar Sesión"**.
3. Si los datos son correctos, ingresará automáticamente a su **Dashboard de Cliente**.

### 1.3 Exploración del Catálogo
- Desde el menú superior o lateral, seleccione **"Catálogo"**.
- Podrá ver los servicios organizados por categorías: *Manicura, Pedicura, Cuidado Capilar, Maquillaje y Peinados*.
- Cada tarjeta muestra la fotografía, descripción del tratamiento, duración aproximada y precio en pesos colombianos ($ COP).
- Si desea reservar de inmediato, presione el botón **"Reservar Cita"** en la tarjeta del servicio.

### 1.4 Cómo Agendar una Cita (Paso a Paso)
1. Ingrese a **"Agendar Cita"**.
2. **Seleccione el Servicio:** Elija del menú desplegable el tratamiento que desea recibir.
3. **Seleccione la Fecha:** Haga clic en el calendario y elija el día deseado (no se permiten fechas pasadas).
4. **Horario Inteligente:** El sistema consultará automáticamente la disponibilidad y mostrará únicamente los bloques horarios libres (los horarios ocupados se bloquean visualmente para evitar cruces).
5. Seleccione la hora disponible de su preferencia.
6. Haga clic en **"Confirmar y Continuar al Pago"**.

### 1.5 Gestión de Mis Reservas
- Ingrese a la pestaña **"Mis Reservas"**.
- Aquí encontrará el historial de sus citas con los siguientes estados:
  - 🟡 **Pendiente:** Cita registrada pendiente de pago o confirmación.
  - 🟢 **Confirmada:** Cita pagada y programada en la agenda del salón.
  - 🔵 **Completada:** Servicio finalizado con éxito.
  - 🔴 **Cancelada:** Cita cancelada.
- Podrá cancelar una reserva pendiente haciendo clic en **"Cancelar Cita"**.

### 1.6 Pasarela de Pago y Factura
- Tras apartar su cita, se abrirá la pantalla de pago donde podrá seleccionar:
  - **Transferencia:** Transferencia por Nequi o Daviplata (se muestran los números de cuenta oficiales del salón).
  - **Pago en Efectivo / Presencial:** Paga al momento de llegar al establecimiento.
- Una vez registrado el pago, presione **"Ver Factura"** para visualizar el comprobante con detalle de subtotal, impuestos, servicio, fecha y botón de **"Imprimir Comprobante"**.

---

## 2. Módulo del Administrador

### 2.1 Acceso al Panel de Control
1. Diríjase a la URL de acceso e ingrese las credenciales de administrador.
2. El sistema lo redirigirá al panel administrativo: `/admin/dashboard`.
3. En el panel principal encontrará tarjetas de resumen con:
   - Citas programadas para el día de hoy.
   - Total de clientes registrados.
   - Ingresos acumulados del mes.
   - Servicios con mayor demanda.

### 2.2 Gestión de Citas y Agenda
1. Vaya a la sección **"Reservas"** (`/admin/reservas`).
2. Podrá filtrar las citas por fecha o estado.
3. Para cada cita, el administrador puede:
   - **Confirmar Cita:** Cambiar el estado de `pendiente` a `confirmada`.
   - **Reprogramar:** Modificar la fecha u hora si el cliente solicitó un cambio previo acuerdo.
   - **Finalizar Cita:** Marcarla como `completada` una vez prestado el servicio.
   - **Cancelar:** Liberar el turno en la agenda en caso de inasistencia.

### 2.3 Gestión del Catálogo de Servicios (CRUD)
1. Ingrese a **"Servicios"** (`/admin/servicios`).
2. **Para agregar un servicio nuevo:**
   - Clic en **"Nuevo Servicio"**.
   - Diligencie el nombre, descripción, precio, categoría y adjunte una fotografía representativa.
   - Clic en **"Guardar Servicio"**.
3. **Para editar:** Haga clic en el botón de edición sobre cualquier servicio de la tabla, ajuste los valores y presione guardar.
4. **Para eliminar:** Use el botón de papelera para retirar un servicio descontinuado del catálogo.

### 2.4 Gestión de Clientes (Activación / Suspensión)
1. Acceda a **"Clientes"** (`/admin/clientes`).
2. Visualice la lista completa con nombre, teléfono, correo y estado.
3. Para suspender o reactivar el acceso de un usuario, presione el botón de conmutación **"Activo / Inactivo"**. Un usuario inactivo no podrá iniciar sesión en la plataforma.

### 2.5 Auditoría de Pagos y Facturación
1. Acceda a **"Pagos"** (`/admin/pagos`).
2. Revise el historial de transacciones registradas, método de pago y monto.
3. El administrador puede consultar e imprimir la factura oficial de cualquier cliente con un solo clic.

---

## 3. Preguntas Frecuentes y Solución de Problemas

**¿Qué pasa si olvido mi contraseña?**  
Comuníquese con la administración del salón a través del número oficial de WhatsApp para solicitar la verificación de su identidad y restablecimiento de acceso.

**¿Puedo reservar dos citas a la misma hora?**  
No. El sistema bloquea de manera automática los bloques horarios ya asignados para garantizar atención personalizada y puntualidad.

**¿Puedo imprimir mi factura desde el teléfono celular?**  
Sí, la vista de factura cuenta con estilos optimizados para descarga en formato PDF o impresión inalámbrica desde cualquier dispositivo móvil.
