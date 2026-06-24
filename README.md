# MINI-CEX

> Plataforma de evaluación clínica para estudiantes de medicina basada en el instrumento MINI-CEX (Mini Clinical Evaluation Exercise).

## 📋 Stack Tecnológico

| Componente | Tecnología |
|---|---|
| **Backend** | CodeIgniter 4.7 — PHP 8.2+ |
| **Base de datos** | MySQL (`bd_minicex`) |
| **Autenticación admin** | Sesiones PHP |
| **API (Android)** | REST endpoints con sincronización offline |
| **Correos** | PHPMailer (SMTP) |
| **Reportes PDF** | FPDF personalizado + TCPDF |
| **Frontend** | JavaScript vanilla, CSS |

## 🚀 Instalación para desarrollo local

### Requisitos

- PHP 8.2+
- MySQL 8.0+
- Composer
- XAMPP / WAMP / Laragon o similar

### Pasos

```bash
# 1. Clonar el repositorio
git clone https://github.com/TU_USUARIO/minicex.git
cd minicex

# 2. Instalar dependencias de Composer
composer install

# 3. Configurar credenciales (copiar y editar)
cp config.example.php config.php
cp smtp_config.example.php smtp_config.php

# 4. Editar config.php con tus credenciales de DB y SMTP
#    - DB_HOST, DB_USER, DB_PASS, DB_NAME
#    - SMTP_HOST, SMTP_USERNAME, SMTP_PASSWORD, etc.

# 5. Crear la base de datos con datos de prueba
php setup.php

# 6. ¡Listo! Acceder desde el navegador:
#    http://localhost/minicex
```

## 🔐 Accesos por defecto

### Panel de Administración (`/admin`)
| Usuario | Contraseña |
|---|---|
| `admin` | `Retsab21ACA*` |

### Evaluador de prueba (seedeado por `setup.php`)
| Correo | Contraseña |
|---|---|
| `evaluador@upe.edu.mx` | `password123` |

## 📁 Estructura del proyecto

```
minicex/
├── api/                  # API REST + FPDF personalizado
│   ├── fpdf/             # Librería FPDF
│   └── pdf_generator.php # Generador de reportes PDF
├── app/                  # CodeIgniter 4
│   ├── Config/           # Configuración del framework
│   ├── Controllers/      # Controladores
│   │   ├── AdminController.php   # Panel admin
│   │   ├── ApiController.php     # API REST
│   │   ├── HomeController.php    # Landing
│   │   └── ReportController.php  # Reportes
│   └── Views/            # Vistas
├── includes/             # Utilidades compartidas
│   ├── auth.php
│   ├── data_fetcher.php
│   ├── email_sender.php
│   └── post_handlers.php
├── parts/                # Partial views (PHP includes)
├── config.php            # 🔴 Credenciales (NO se sube a Git)
├── config.example.php    # Template de configuración
├── setup.php             # Script de creación de BD
└── AGENTS.md             # Guía de arquitectura del proyecto
```

## 🌐 API (Android App)

La API REST está documentada en [`API.md`](API.md) (visible en GitHub) y también en `/api-docs` (en el servidor). Soporta:

- `POST /api/auth/login` — Autenticación
- `GET /api/students` — Listar alumnos
- `POST /api/sync/students` — Sincronizar alumnos
- `GET/POST /api/sync/evaluations` — Sincronizar evaluaciones
- `POST /api/sync/process_queue` — Sincronización offline bidireccional

➡️ **[Ver documentación completa de la API →](API.md)**

## 📄 Licencia

MIT — CodeIgniter 4 starter app.
