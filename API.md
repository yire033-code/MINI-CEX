# API MINI-CEX

> API REST para la sincronización bidireccional entre la App Android y el servidor web.  
> Documentación técnica de endpoints, formatos de datos y flujo de sincronización offline.

**Base URL:** `http://localhost/minicex` (o la URL de tu despliegue)

---

## Índice

1. [Arquitectura](#1-arquitectura)
2. [Endpoints](#2-endpoints)
   - 2.1 [Autenticación](#21-autenticación)
   - 2.2 [Alumnos](#22-alumnos)
   - 2.3 [Evaluaciones](#23-evaluaciones)
   - 2.4 [Cola Offline](#24-cola-de-sincronización-offline-bidireccional)
   - 2.5 [Reenvío de Correo](#25-reenvío-de-correo)
3. [Diagrama de Flujo](#3-diagrama-de-flujo)
4. [Mapeo de Campos](#4-mapeo-de-campos)
5. [Códigos HTTP](#5-códigos-de-estado-http)
6. [Notas Técnicas](#6-notas-técnicas)
7. [Seed Data](#7-seed-data)
8. [Reportes PDF](#8-reportes-pdf)

---

## 1. Arquitectura

La API está construida con **CodeIgniter 4** y utiliza **PDO nativo** para el acceso a datos.

**Flujo de comunicación:** bidireccional

- **App → Servidor:** La app envía evaluaciones, alumnos y operaciones de cola realizadas offline.
- **Servidor → App:** El servidor responde con datos actualizados (usuarios, alumnos, evaluaciones) para reconciliación local.

**Mecanismo principal de sincronización offline:** `POST /api/sync/process_queue`

### Base de Datos — Esquema

| Tabla | Descripción | Columnas clave |
|---|---|---|
| `usuarios` | Usuarios del sistema (docentes) | `id_usuario`, `nombre_completo`, `email`, `password_hash`, `rol` |
| `alumnos` | Alumnos asignados a un docente | `id_alumno`, `uuid`, `matricula`, `nombre_completo`, `semestre_grupo`, `correo`, `id_docente` |
| `evaluaciones` | Evaluaciones MINI-CEX | `id_evaluacion`, `uuid`, `id_evaluador`, `id_alumno`, `fecha_evaluacion`, `entorno_clinico`, `tipo_paciente`, `asunto_principal`, `complejidad`, `calificacion_total`, `firma_evaluador`, `firma_alumno`, `is_synced` |
| `detalles_rubrica` | Detalles de competencias por evaluación | `id_detalle`, `id_evaluacion`, `competencia`, `puntaje`, `notas`, `a_destacar`, `a_mejorar` |
| `sync_queue` | Historial de operaciones de sincronización | `id`, `user_id`, `action`, `table_name`, `entity_uuid`, `data_payload` |

### Convenciones de la API

- **CORS:** Permitido para todos los orígenes (`*`).
- **Content-Type:** `application/json`
- **Auth:** Comparación de contraseña en texto plano (sin hash).
- **Mapeo:** Kotlin camelCase ↔ MySQL snake_case (ej: `fechaEvaluacion` → `fecha_evaluacion`).
- **Tiempos:** Las fechas/horas se transmiten como timestamps en milisegundos.

---

## 2. Endpoints

### 2.1 Autenticación

#### `POST /api/auth/login`

Inicia sesión con credenciales de docente.

**Request Body:**

```json
{
    "email": "evaluador@upe.edu.mx",   // string (requerido)
    "password": "password123"           // string (requerido)
}
```

**Response `200`:**

```json
{
    "success": true,
    "user": {
        "id_usuario": 1,
        "nombre_completo": "Dr. Evaluador Ejemplo",
        "email": "evaluador@upe.edu.mx",
        "rol": "Docente"
    }
}
```

**Response `401`:**

```json
{
    "success": false,
    "message": "Credenciales incorrectas."
}
```

---

### 2.2 Alumnos

#### `GET /api/students?evaluador_id=1`

Obtiene los alumnos asignados a un evaluador. Parámetro opcional: `evaluador_id` (default: 1).

**Response:**

```json
[
    {
        "id_alumno": 1,
        "matricula": "202601",
        "nombre_completo": "Juan Pérez",
        "semestre_grupo": "6to A",
        "correo": "juan.perez@example.com"
    },
    ...
]
```

#### `POST /api/sync/students`

Sincroniza alumnos desde la app hacia el servidor. Inserta o actualiza según matrícula.

**Request Body:**

```json
[
    {
        "matricula": "202601",
        "nombre_completo": "Juan Pérez",
        "semestre_grupo": "6to A",
        "correo": "juan.perez@example.com",
        "id_docente": 1           // opcional (default: 1)
    },
    ...
]
```

**Response:**

```json
{
    "success": true,
    "synced": [
        { "matricula": "202601", "id_alumno": 1 }
    ]
}
```

---

### 2.3 Evaluaciones

#### `POST /api/sync/evaluations`

Envía evaluaciones desde la app al servidor. **Idempotente:** si el `uuid` ya existe, se omite. Al insertar una evaluación nueva, se genera un PDF y se envía por correo al alumno (si tiene email registrado). La operación es **atómica** (transacción).

**Request Body:**

```json
[
    {
        "evaluation": {
            "uuid": "a1b2c3d4-...",
            "idEvaluador": 1,
            "idAlumno": 1,
            "fechaEvaluacion": 1700000000000,     // timestamp ms
            "entornoClinico": "Consulta MF",       // Consulta MF | Piso | Otros
            "tipoPaciente": "Nuevo",               // Nuevo | Subsecuente
            "asuntoPrincipal": "Evaluación inicial",
            "complejidad": "Media",                // Baja | Media | Alta
            "tiempoObservacion": 15,
            "tiempoFeedback": 10,
            "calificacionTotal": 8.5,
            "firmaEvaluador": "data:image/png;base64,...",   // opcional
            "firmaAlumno": "data:image/png;base64,..."       // opcional
        },
        "details": [
            {
                "competencia": "Historia Clínica",
                "puntaje": 9,
                "notas": "Buen desempeño",
                "aDestacar": "Rapport excelente",
                "aMejorar": "Profundizar antecedentes"
            }
        ]
    }
]
```

**Response:**

```json
{
    "success": true,
    "message": "Sincronización completada con éxito.",
    "syncedUuids": ["a1b2c3d4-..."]
}
```

> **Nota:** Los campos en `camelCase` (Kotlin) se convierten a `snake_case` en MySQL. Ej: `fechaEvaluacion` → `fecha_evaluacion`.

#### `GET /api/sync/evaluations?evaluador_id=1`

Obtiene todas las evaluaciones de un evaluador, con sus detalles de rúbrica.

**Response:**

```json
[
    {
        "evaluation": {
            "idEvaluacion": 1,
            "uuid": "a1b2c3d4-...",
            "idEvaluador": 1,
            "idAlumno": 1,
            "fechaEvaluacion": 1700000000000,
            "entornoClinico": "Consulta MF",
            "tipoPaciente": "Nuevo",
            "asuntoPrincipal": "Evaluación inicial",
            "complejidad": "Media",
            "tiempoObservacion": 15,
            "tiempoFeedback": 10,
            "calificacionTotal": 8.5,
            "isSynced": true,
            "createdAt": 1700000000000
        },
        "details": [
            {
                "idDetalle": 1,
                "idEvaluacion": 1,
                "competencia": "Historia Clínica",
                "puntaje": 9,
                "notas": "Buen desempeño",
                "aDestacar": "Rapport excelente",
                "aMejorar": "Profundizar antecedentes"
            }
        ]
    }
]
```

---

### 2.4 Cola de Sincronización (Offline Bidireccional)

#### `POST /api/sync/process_queue?evaluador_id=1`

**Endpoint principal de sincronización offline.** Procesa una cola de operaciones enviadas por la app y devuelve `serverActions` para que la app reconcilie su estado local.

**Request Body:**

```json
[
    {
        "action": "insert",               // "insert" | "update" | "delete"
        "tableName": "alumnos",           // "alumnos" | "evaluaciones"
        "entityUuid": "uuid-del-alumno",
        "dataPayload": "{ ... }",          // string JSON
        "timestamp": 1700000000000
    }
]
```

**dataPayload — Alumnos (insert/update):**

```json
{
    "matricula": "202601",
    "nombreCompleto": "Juan Pérez",
    "semestreGrupo": "6to A",
    "correo": "juan@example.com",
    "idAlumno": 0                // ID local de la app (mapeo)
}
```

**Response:**

```json
{
    "success": true,
    "message": "Cola procesada correctamente",
    "processedIds": [],
    "serverActions": [
        {
            "action": "update",
            "tableName": "usuarios",
            "entityUuid": "",
            "dataPayload": "{ \"id_usuario\": 1, ... }",
            "timestamp": 1700000000000
        }
        // + alumnos + evaluaciones
    ]
}
```

> **Importante:** Si el usuario logueado fue eliminado del servidor, se devuelve `{ "action": "delete", "tableName": "usuarios" }` para que la app cierre sesión.
>
> **Flujo:** La app envía operaciones pendientes → el servidor las procesa en transacción → responde con `serverActions` (usuarios + alumnos + evaluaciones) para que la app actualice su BD local.

---

### 2.5 Reenvío de Correo

#### `POST /api/sync/resend-email`

Reenvía el correo de notificación con PDF adjunto para una evaluación específica (por UUID).

**Request Body:**

```json
{
    "uuid": "a1b2c3d4-..."    // UUID de la evaluación
}
```

**Response `200`:**

```json
{
    "success": true,
    "message": "Correo reenviado con éxito."
}
```

**Posibles Errores:**

| Código | Significado |
|---|---|
| `400` | UUID requerido / El alumno no tiene correo |
| `404` | Evaluación no encontrada |
| `500` | Error SMTP o al generar PDF |

---

## 3. Diagrama de Flujo

Ciclo completo de sincronización offline entre la App Android y el Servidor:

```
┌─────────────────────────────────────┐
│ 1. App Android - Modo offline       │
│    Crea/edita alumnos y evaluaciones │
│    sin conexión. Almacena en cola    │
│    local (SQLite).                   │
└──────────────────┬──────────────────┘
                   │
                   ▼
┌─────────────────────────────────────┐
│ 2. App Android - Al recuperar       │
│    conexión                         │
│    Envía cola de operaciones        │
│    pendientes vía                   │
│    POST /api/sync/process_queue     │
└──────────────────┬──────────────────┘
                   │
                   ▼
╔══════════════════════════════════════╗
║      SERVIDOR — PHP + MySQL         ║
╠══════════════════════════════════════╣
║                                      ║
║  ┌──────────────────────────────┐   ║
║  │ 3. Recibe y valida           │   ║
║  │ Procesa cola, verifica       │   ║
║  │ existencia del usuario en BD │   ║
║  └──────────────┬───────────────┘   ║
║                 │                    ║
║                 ▼                    ║
║  ┌──────────────────────────────┐   ║
║  │ 4. Transacción atómica       │   ║
║  │ • Alumnos: insert/update/    │   ║
║  │   delete                     │   ║
║  │ • Evaluaciones: insert/      │   ║
║  │   update + detalles_rubrica  │   ║
║  │ • Rollback si algo falla     │   ║
║  └──────────────┬───────────────┘   ║
║                 │                    ║
║                 ▼                    ║
║  ┌──────────────────────────────┐   ║
║  │ 5. Prepara serverActions     │   ║
║  │ Compila datos actualizados:  │   ║
║  │ • Usuarios (login offline)   │   ║
║  │ • Alumnos (IDs mapeados)     │   ║
║  │ • Evaluaciones (UUIDs conf.) │   ║
║  └──────────────┬───────────────┘   ║
║                 │                    ║
║                 ▼                    ║
║  ┌──────────────────────────────┐   ║
║  │ 6. PDF + Email               │   ║
║  │ Si hay evaluaciones nuevas:  │   ║
║  │ • Genera PDF con FPDF        │   ║
║  │ • Envía notificación por     │   ║
║  │   PHPMailer al alumno        │   ║
║  │ • Auto-heal SMTP si host     │   ║
║  │   no coincide                │   ║
║  └──────────────┬───────────────┘   ║
║                 │                    ║
║                 ▼                    ║
║  ┌──────────────────────────────┐   ║
║  │ 7. Responde con              │   ║
║  │    serverActions             │   ║
║  └──────────────┬───────────────┘   ║
╚═════════════════╤═══════════════════╝
                   │
                   ▼
┌─────────────────────────────────────┐
│ 8. App Android - Reconciliación     │
│    local                            │
│    Actualiza BD (SQLite) con        │
│    serverActions:                   │
│    • Usuarios → login offline       │
│    • Alumnos → mapea IDs locales    │
│    • Evaluaciones → confirma UUIDs  │
└──────────────────┬──────────────────┘
                   │
                   ▼
         ┌─────────────────┐
         │ ✓ Sincronización │
         │   completada     │
         └─────────────────┘
```

---

## 4. Mapeo de Campos

Convención de nomenclatura entre la App (Kotlin camelCase) y la Base de Datos (MySQL snake_case).

| App (Kotlin camelCase) | Servidor (MySQL snake_case) | Tipo |
|---|---|---|
| `idEvaluador` | `id_evaluador` | INT |
| `idAlumno` | `id_alumno` | INT |
| `fechaEvaluacion` | `fecha_evaluacion` | DATE (timestamp ms) |
| `entornoClinico` | `entorno_clinico` | ENUM |
| `tipoPaciente` | `tipo_paciente` | ENUM |
| `asuntoPrincipal` | `asunto_principal` | VARCHAR |
| `complejidad` | `complejidad` | ENUM |
| `tiempoObservacion` | `tiempo_observacion` | INT |
| `tiempoFeedback` | `tiempo_feedback` | INT |
| `calificacionTotal` | `calificacion_total` | DECIMAL |
| `firmaEvaluador` | `firma_evaluador` | LONGTEXT (base64) |
| `firmaAlumno` | `firma_alumno` | LONGTEXT (base64) |
| `isSynced` | `is_synced` | BOOLEAN |
| `createdAt` | `created_at` | TIMESTAMP (ms) |
| `nombreCompleto` | `nombre_completo` | VARCHAR |
| `semestreGrupo` | `semestre_grupo` | VARCHAR |
| `aDestacar` | `a_destacar` | TEXT |
| `aMejorar` | `a_mejorar` | TEXT |
| `idDocente` | `id_docente` | INT |

---

## 5. Códigos de Estado HTTP

| Código | Significado | Uso |
|---|---|---|
| `200` | OK | Respuesta exitosa estándar |
| `400` | Bad Request | Faltan campos requeridos, formato inválido |
| `401` | Unauthorized | Credenciales incorrectas |
| `404` | Not Found | Evaluación no encontrada |
| `500` | Internal Server Error | Error de BD, SMTP, o excepción |

---

## 6. Notas Técnicas

| Tema | Detalle |
|---|---|
| CORS | `Access-Control-Allow-Origin: *`. Preflight OPTIONS manejado automáticamente. |
| Autenticación | Comparación directa de contraseña en texto plano. No usa `password_hash`. |
| Idempotencia | Las evaluaciones se identifican por `uuid`. Si existe, se omite el insert. |
| Transacciones | `sync/evaluations` y `process_queue` usan transacciones atómicas. Rollback completo si falla. |
| Manejo de errores | Try/catch con `\Throwable`. Los errores incluyen mensaje y ocasionalmente trace. |
| Fechas | La app envía timestamps en milisegundos. El servidor divide por 1000 y usa `date('Y-m-d')`. |
| Email/SMTP | PHPMailer. Auto-heal de host si SMTP_HOST es `smtp.example.com` pero el username es `@gmail.com`. Logs en `email_log.log`. |
| PDF | FPDF personalizado en `api/pdf_generator.php`. Se adjunta al email como string. |
| Migración automática | Cada request ejecuta `ALTER TABLE alumnos ADD COLUMN correo VARCHAR(255)` (falla silenciosamente si ya existe). |

---

## 7. Seed Data

Registros iniciales creados por `setup.php` al reiniciar la base de datos.

| Tabla | Registros |
|---|---|
| `usuarios` | `evaluador@upe.edu.mx` / `password123` (Rol: Docente) |
| `alumnos` | Juan Pérez (202601), María García (202602), Carlos López (202603) |

---

## 8. Reportes PDF

Generación automatizada de reportes clínicos en PDF con formato institucional. El proceso se ejecuta cada vez que se sincroniza una evaluación nueva o se solicita un reenvío de correo.

**Evento detonante:**
- Una evaluación se sincroniza desde la app (`POST /api/sync/evaluations`)
- Se solicita reenvío de correo (`POST /api/sync/resend-email`)
- Se genera desde el panel admin (`AdminController`)

**Flujo de generación:**

1. **Consulta de datos** — El servidor obtiene de MySQL:
   - Evaluación completa con uuid, fechas, entorno clínico, complejidad
   - Datos del alumno: nombre, matrícula, semestre/grupo, correo
   - Datos del evaluador: nombre completo
   - Detalles de rúbrica: competencias, puntajes, notas, feedback

2. **Construcción del PDF** — `api/pdf_generator.php :: generateEvaluationPdf()`:
   - Banner superior: barra azul institucional (#1B5E96) + línea dorada (#B8860B)
   - Logotipo: Escala dinámica de alta resolución → 400px para FPDF
   - Encabezado: nombre de la institución, título "MINI-CEX"
   - Datos generales: alumno, evaluador, fecha, entorno clínico, tipo de paciente, complejidad
   - Tabla de rúbrica: competencias con puntajes (1-9) y notas cualitativas
   - Feedback: "A destacar" y "A mejorar" con viñetas
   - Firmas: espacio para firma del evaluador y del alumno (base64 → PNG)

3. **Salida del PDF** — La función retorna el contenido binario del PDF como **string** (`$pdf->Output('', 'S')`), listo para ser adjuntado al correo.

4. **Notificación por correo** — Se envía el PDF al alumno mediante **PHPMailer**:
   - Destinatario: correo del alumno (columna `correo` en `alumnos`)
   - Asunto: "Resultado de Evaluación MINI-CEX"
   - Adjunto: PDF generado como string vía `addStringAttachment()`
   - Auto-heal SMTP: si `SMTP_HOST` es `smtp.example.com` pero el username es `@gmail.com`, se conmuta automáticamente a `smtp.gmail.com`

5. **Logging** — Cada envío se registra en `email_log.log` con:
   - Fecha y hora del envío
   - UUID de la evaluación
   - Correo del destinatario
   - Estado: ✓ Enviado o ✗ Error

> **Nota:** El PDF se genera con **FPDF** (librería personalizada en `api/fpdf/`), no con TCPDF. El motor incluye escalado dinámico de imágenes para evitar agotar la memoria en logotipos de alta resolución.
