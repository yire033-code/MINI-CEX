<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Guía de uso del panel administrativo MINI-CEX — Gestión de docentes, alumnos, evaluaciones y configuración.">
<title>Guía de Uso · Panel Admin · MINI-CEX</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<style>
/* ═══════════════════════════════════════════════
   DESIGN TOKENS
   ═══════════════════════════════════════════════ */
:root {
    --bg-primary: #050a18;
    --bg-secondary: #0a1128;
    --bg-card: rgba(15, 25, 55, 0.6);
    --bg-glass: rgba(255, 255, 255, 0.03);
    --bg-glass-border: rgba(255, 255, 255, 0.06);
    --bg-code: #0d1117;

    --text-primary: #e2e8f0;
    --text-secondary: #94a3b8;
    --text-muted: #64748b;

    --blue: #3b82f6;
    --blue-vivid: #60a5fa;
    --blue-deep: #1d4ed8;
    --blue-glow: rgba(59, 130, 246, 0.12);

    --gold: #d4a012;
    --gold-vivid: #fbbf24;

    --green: #22c55e;
    --green-glow: rgba(34, 197, 94, 0.12);

    --purple: #a855f7;
    --rose: #f43f5e;
    --teal: #14b8a6;
    --amber: #f59e0b;

    --radius: 16px;
    --radius-md: 12px;
    --radius-sm: 8px;

    --font: 'Inter', system-ui, -apple-system, sans-serif;
    --font-heading: 'Outfit', var(--font);
    --font-mono: 'JetBrains Mono', 'Fira Code', monospace;

    --ease: cubic-bezier(0.4, 0, 0.2, 1);
    --speed: 0.3s;

    --sidebar-w: 250px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

html {
    scroll-behavior: smooth;
    scroll-padding-top: 100px;
}

body {
    font-family: var(--font);
    background: var(--bg-primary);
    color: var(--text-primary);
    line-height: 1.7;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

a { text-decoration: none; color: inherit; }

::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: var(--bg-primary); }
::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, var(--blue), var(--purple));
    border-radius: 3px;
}

/* ═══════════════════════════════════════════════
   LAYOUT
   ═══════════════════════════════════════════════ */
.app-layout {
    display: flex;
    min-height: 100vh;
}

/* ═══════════════════════════════════════════════
   SIDEBAR
   ═══════════════════════════════════════════════ */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: var(--sidebar-w);
    height: 100vh;
    overflow-y: auto;
    z-index: 100;
    background: var(--bg-secondary);
    border-right: 1px solid rgba(255, 255, 255, 0.04);
    padding: 0;
    display: flex;
    flex-direction: column;
}

.sidebar-header {
    padding: 22px 20px 18px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    flex-shrink: 0;
}

.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 10px;
}

.sidebar-logo {
    width: 30px;
    height: 30px;
    filter: brightness(0) invert(1);
    flex-shrink: 0;
}

.sidebar-brand-text {
    display: flex;
    flex-direction: column;
}

.sidebar-brand-name {
    font-family: var(--font-heading);
    font-weight: 800;
    font-size: 15px;
    color: #fff;
    letter-spacing: -0.3px;
    line-height: 1.1;
}

.sidebar-brand-sub {
    font-size: 9px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--gold-vivid);
    font-weight: 700;
}

.sidebar-nav {
    padding: 12px 0;
    flex: 1;
    overflow-y: auto;
}

.sidebar-section {
    margin-bottom: 2px;
}

.sidebar-section-title {
    padding: 8px 20px 5px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: var(--text-muted);
    opacity: 0.5;
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 7px 20px;
    font-size: 13px;
    font-weight: 500;
    color: var(--text-secondary);
    transition: all var(--speed) var(--ease);
    border-left: 2px solid transparent;
}

.sidebar-link:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.03);
}

.sidebar-link.active {
    color: var(--blue-vivid);
    background: var(--blue-glow);
    border-left-color: var(--blue);
}

.sidebar-link .link-dot {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: currentColor;
    opacity: 0.4;
    flex-shrink: 0;
}

.sidebar-link.active .link-dot {
    opacity: 1;
    box-shadow: 0 0 8px rgba(59, 130, 246, 0.5);
}

.sidebar-footer {
    padding: 14px 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.04);
    flex-shrink: 0;
}

.sidebar-footer a {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: var(--text-muted);
    transition: color var(--speed) var(--ease);
}

.sidebar-footer a:hover { color: var(--blue-vivid); }

/* ═══════════════════════════════════════════════
   MAIN CONTENT
   ═══════════════════════════════════════════════ */
.main-content {
    margin-left: var(--sidebar-w);
    flex: 1;
    min-width: 0;
    padding: 0;
}

.top-bar {
    position: sticky;
    top: 0;
    z-index: 50;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 40px;
    background: rgba(5, 10, 24, 0.85);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
}

.top-bar-title {
    font-family: var(--font-heading);
    font-size: 14px;
    font-weight: 700;
    color: #fff;
    letter-spacing: -0.3px;
}

.top-bar-title span {
    color: var(--text-muted);
    font-weight: 400;
}

.top-bar-version {
    padding: 4px 12px;
    background: var(--blue-glow);
    color: var(--blue-vivid);
    font-size: 11px;
    font-weight: 600;
    border-radius: 999px;
    letter-spacing: 0.3px;
}

.sidebar-toggle {
    display: none;
    background: none;
    border: none;
    color: #fff;
    cursor: pointer;
    padding: 6px;
}

/* ═══════════════════════════════════════════════
   CONTENT WRAPPER
   ═══════════════════════════════════════════════ */
.content-wrapper {
    max-width: 860px;
    margin: 0 auto;
    padding: 36px 40px 80px;
}

/* ═══════════════════════════════════════════════
   HERO
   ═══════════════════════════════════════════════ */
.hero-section {
    margin-bottom: 44px;
    padding-bottom: 28px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
}

.hero-section h1 {
    font-family: var(--font-heading);
    font-size: 34px;
    font-weight: 900;
    color: #fff;
    letter-spacing: -1.5px;
    line-height: 1.15;
    margin-bottom: 10px;
}

.hero-section .hero-gradient {
    background: linear-gradient(135deg, var(--blue-vivid), var(--purple), var(--gold-vivid));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-section p {
    font-size: 16px;
    color: var(--text-secondary);
    max-width: 640px;
    line-height: 1.7;
}

.hero-stats {
    display: flex;
    gap: 10px;
    margin-top: 16px;
    flex-wrap: wrap;
}

.hero-stat {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    background: var(--bg-glass);
    border: 1px solid var(--bg-glass-border);
    border-radius: 6px;
    font-size: 12px;
    color: var(--text-secondary);
}

.hero-stat strong {
    color: var(--blue-vivid);
    font-weight: 600;
}

/* ═══════════════════════════════════════════════
   SECTIONS
   ═══════════════════════════════════════════════ */
.section-block {
    margin-bottom: 44px;
    scroll-margin-top: 80px;
}

.section-block h2 {
    font-family: var(--font-heading);
    font-size: 24px;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.8px;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.section-block h2 .section-num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border-radius: 8px;
    background: var(--blue-glow);
    color: var(--blue-vivid);
    font-size: 13px;
    font-weight: 700;
    flex-shrink: 0;
}

.section-block h3 {
    font-family: var(--font-heading);
    font-size: 18px;
    font-weight: 700;
    color: #e2e8f0;
    margin-bottom: 12px;
    margin-top: 28px;
    letter-spacing: -0.2px;
}

.section-block p {
    font-size: 15px;
    color: var(--text-secondary);
    line-height: 1.7;
    margin-bottom: 14px;
}

.section-block ul, .section-block ol {
    padding-left: 20px;
    margin-bottom: 14px;
}

.section-block li {
    font-size: 14px;
    color: var(--text-secondary);
    margin-bottom: 5px;
    line-height: 1.6;
}

.section-block li strong { color: var(--text-primary); }

/* ═══════════════════════════════════════════════
   STEP CARDS
   ═══════════════════════════════════════════════ */
.step-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 18px;
}

.step-item {
    background: var(--bg-card);
    border: 1px solid var(--bg-glass-border);
    border-radius: var(--radius-md);
    padding: 16px 20px;
    border-left: 3px solid var(--blue);
    transition: border-color var(--speed) var(--ease);
}

.step-item:hover {
    border-color: rgba(255, 255, 255, 0.1);
}

.step-item.warn  { border-left-color: var(--amber); }
.step-item.success { border-left-color: var(--green); }
.step-item.danger { border-left-color: var(--rose); }

.step-item .step-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: var(--text-muted);
    margin-bottom: 4px;
}

.step-item .step-body {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.65;
}

.step-item .step-body strong { color: var(--text-primary); }

/* ═══════════════════════════════════════════════
   INFO BOXES
   ═══════════════════════════════════════════════ */
.info-box {
    display: flex;
    gap: 12px;
    padding: 14px 18px;
    border-radius: var(--radius-sm);
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 16px;
}

.info-box-icon {
    flex-shrink: 0;
    width: 18px;
    height: 18px;
    margin-top: 2px;
}

.info-box.info {
    background: rgba(59, 130, 246, 0.08);
    border: 1px solid rgba(59, 130, 246, 0.15);
    color: var(--blue-vivid);
}

.info-box.warn {
    background: rgba(245, 158, 11, 0.08);
    border: 1px solid rgba(245, 158, 11, 0.15);
    color: var(--gold-vivid);
}

.info-box strong { color: #fff; }

.info-box code {
    background: rgba(255, 255, 255, 0.08);
    padding: 1px 6px;
    border-radius: 4px;
    font-family: var(--font-mono);
    font-size: 12px;
}

/* ═══════════════════════════════════════════════
   CODE
   ═══════════════════════════════════════════════ */
.section-block code {
    background: rgba(59, 130, 246, 0.1);
    padding: 1px 6px;
    border-radius: 4px;
    font-family: var(--font-mono);
    font-size: 13px;
    color: var(--blue-vivid);
}

.step-item .step-body code {
    background: rgba(255, 255, 255, 0.06);
    color: var(--blue-vivid);
}

/* ═══════════════════════════════════════════════
   TABLES
   ═══════════════════════════════════════════════ */
.table-wrap {
    overflow-x: auto;
    margin-bottom: 18px;
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: var(--radius-sm);
}

.table-wrap table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.table-wrap th {
    background: rgba(255, 255, 255, 0.03);
    font-weight: 600;
    color: var(--text-primary);
    text-align: left;
    padding: 10px 14px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table-wrap td {
    padding: 10px 14px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    color: var(--text-secondary);
    vertical-align: top;
}

.table-wrap tr:last-child td { border-bottom: none; }
.table-wrap tr:hover td { background: rgba(255, 255, 255, 0.015); }

/* ── Tags dentro de tablas ── */
.tag {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.tag-blue { background: rgba(59, 130, 246, 0.15); color: var(--blue-vivid); }
.tag-green { background: rgba(34, 197, 94, 0.15); color: var(--green); }
.tag-red { background: rgba(244, 63, 94, 0.15); color: var(--rose); }
.tag-yellow { background: rgba(251, 191, 36, 0.15); color: var(--gold-vivid); }
.tag-purple { background: rgba(168, 85, 247, 0.15); color: var(--purple); }

/* ═══════════════════════════════════════════════
   FLOW SEQUENCE (numbered steps)
   ═══════════════════════════════════════════════ */
.flow-seq {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin: 12px 0 16px;
    padding: 0;
    list-style: none;
}

.flow-seq li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 14px;
    color: var(--text-secondary);
    padding: 8px 14px;
    background: rgba(255, 255, 255, 0.02);
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.04);
}

.flow-seq .fs-num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: var(--blue-glow);
    color: var(--blue-vivid);
    font-size: 11px;
    font-weight: 700;
    flex-shrink: 0;
    margin-top: 1px;
}

.flow-seq li strong { color: var(--text-primary); }

/* ═══════════════════════════════════════════════
   FOOTER
   ═══════════════════════════════════════════════ */
.guide-footer {
    margin-top: 56px;
    padding-top: 22px;
    border-top: 1px solid rgba(255, 255, 255, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.guide-footer p {
    font-size: 12px;
    color: var(--text-muted);
    margin-bottom: 0;
}

.guide-footer a {
    font-size: 12px;
    color: var(--blue-vivid);
    transition: color var(--speed) var(--ease);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.guide-footer a:hover { color: #fff; }

/* ═══════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════ */
.sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    z-index: 99;
}

.sidebar-overlay.show { display: block; }

@media (max-width: 1024px) {
    .sidebar { transform: translateX(-100%); transition: transform 0.3s var(--ease); }
    .sidebar.open { transform: translateX(0); }
    .sidebar-toggle { display: flex; }
    .main-content { margin-left: 0; }
    .content-wrapper { padding: 24px 24px 60px; }
    .top-bar { padding: 12px 24px; }
}

@media (max-width: 640px) {
    .hero-section h1 { font-size: 26px; }
    .section-block h2 { font-size: 20px; }
    .section-block h3 { font-size: 16px; }
    .content-wrapper { padding: 16px 16px 60px; }
    .top-bar { padding: 10px 16px; }
    .step-item { padding: 14px 16px; }
    .guide-footer { flex-direction: column; text-align: center; }
}
</style>
</head>
<body>

<!-- ═══ SIDEBAR OVERLAY ═══ -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ═══ SIDEBAR ═══ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="<?= base_url() ?>" class="sidebar-brand">
            <img src="<?= base_url('logo_small.png') ?>" alt="MINI-CEX" class="sidebar-logo">
            <div class="sidebar-brand-text">
                <span class="sidebar-brand-name">MINI-CEX</span>
                <span class="sidebar-brand-sub">Admin Guide</span>
            </div>
        </a>
    </div>
    <nav class="sidebar-nav">
        <div class="sidebar-section">
            <div class="sidebar-section-title">Empezando</div>
            <a href="#intro" class="sidebar-link active"><span class="link-dot"></span> Introducción</a>
        </div>
        <div class="sidebar-section">
            <div class="sidebar-section-title">Gestión</div>
            <a href="#docentes" class="sidebar-link"><span class="link-dot"></span> Docentes</a>
            <a href="#alumnos" class="sidebar-link"><span class="link-dot"></span> Alumnos</a>
            <a href="#evaluaciones" class="sidebar-link"><span class="link-dot"></span> Evaluaciones</a>
        </div>
        <div class="sidebar-section">
            <div class="sidebar-section-title">Sistema</div>
            <a href="#reset" class="sidebar-link"><span class="link-dot"></span> Reconstruir BD</a>
            <a href="#tips" class="sidebar-link"><span class="link-dot"></span> Consejos</a>
        </div>
    </nav>
    <div class="sidebar-footer">
        <a href="<?= base_url('admin') ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Ir al Panel
        </a>
    </div>
</aside>

<!-- ═══ MAIN ═══ -->
<main class="main-content">

    <div class="top-bar">
        <div style="display:flex;align-items:center;gap:12px;">
            <button class="sidebar-toggle" id="sidebarToggle" aria-label="Menú">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <span class="top-bar-title">Guía <span>de Uso</span></span>
        </div>
        <span class="top-bar-version">v2.0</span>
    </div>

    <div class="content-wrapper">

        <!-- ════════════════ HERO ════════════════ -->
        <div class="hero-section" id="intro">
            <h1>Panel Admin <span class="hero-gradient">MINI-CEX</span></h1>
            <p>Guía completa para la administración del sistema: gestión de docentes, alumnos, evaluaciones y configuración general de la plataforma.</p>
            <div class="hero-stats">
                <span class="hero-stat"><strong>7</strong> secciones</span>
                <span class="hero-stat"><strong>4</strong> módulos de gestión</span>
                <span class="hero-stat"><strong>Dashboard</strong> en tiempo real</span>
            </div>
        </div>

        <!-- ════════════════ 1. ACCESO ════════════════ -->
        <div class="section-block" id="acceso">
            <h2><span class="section-num">1</span> Acceso al Panel</h2>
            <p>El panel administrativo está disponible en <code><?= base_url('admin') ?></code>. Permite gestionar docentes, alumnos, evaluaciones y la configuración del sistema.</p>

            <div class="step-list">
                <div class="step-item success">
                    <div class="step-label">Credenciales por defecto</div>
                    <div class="step-body">
                        <strong>Usuario:</strong> <code>admin</code> &nbsp;·&nbsp;
                        <strong>Contraseña:</strong> <code>Retsab21ACA*</code>
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-label">Inicio de sesión</div>
                    <div class="step-body">Ingresa las credenciales en la pantalla de login y haz clic en <strong>"Iniciar Sesión"</strong>. El panel utiliza sesiones seguras del lado del servidor.</div>
                </div>
            </div>

            <div class="info-box info">
                <svg class="info-box-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <span><strong>Recuperación:</strong> Si olvidaste la contraseña, puedes reconstruir la base de datos (sección 6) para restablecer las credenciales por defecto. Esto <strong>eliminará todos los datos</strong> del sistema.</span>
            </div>
        </div>

        <!-- ════════════════ 2. DASHBOARD ════════════════ -->
        <div class="section-block" id="dashboard">
            <h2><span class="section-num">2</span> Dashboard</h2>
            <p>Al iniciar sesión, el panel principal muestra un resumen ejecutivo del sistema con indicadores clave.</p>

            <h3>Tarjetas de estadísticas</h3>
            <ul>
                <li><strong>Docentes</strong> — Total de evaluadores registrados.</li>
                <li><strong>Alumnos</strong> — Total de estudiantes en el sistema.</li>
                <li><strong>Evaluaciones</strong> — Número de evaluaciones realizadas.</li>
                <li><strong>Promedio</strong> — Calificación promedio general (sobre 10).</li>
            </ul>

            <h3>Últimas evaluaciones</h3>
            <p>Tabla con las 5 evaluaciones más recientes: matrícula, alumno, evaluador, fecha y puntaje. Haz clic en <strong>"Ver"</strong> para abrir el detalle completo.</p>

            <div class="info-box info">
                <svg class="info-box-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <span><strong>Navegación:</strong> Usa las pestañas superiores (Panel · Docentes · Alumnos · Evaluaciones) para cambiar entre módulos. En móviles, la navegación está en la barra inferior.</span>
            </div>
        </div>

        <!-- ════════════════ 3. DOCENTES ════════════════ -->
        <div class="section-block" id="docentes">
            <h2><span class="section-num">3</span> Docentes</h2>
            <p>En la pestaña <strong>"Docentes"</strong> administras los evaluadores del sistema. Cada docente puede iniciar sesión en la app Android.</p>

            <h3>Agregar un docente</h3>
            <div class="step-list">
                <div class="step-item">
                    <div class="step-label">Formulario</div>
                    <div class="step-body">
                        Completa los campos: <strong>Nombre Completo</strong>, <strong>Correo</strong>, <strong>Contraseña</strong> y selecciona un <strong>Rol</strong> (Docente o Administrador).
                    </div>
                </div>
                <div class="step-item success">
                    <div class="step-label">Resultado</div>
                    <div class="step-body">El docente queda registrado en la tabla y visible para la app. Puede iniciar sesión con su correo y contraseña.</div>
                </div>
            </div>

            <h3>Eliminar un docente</h3>
            <div class="step-list">
                <div class="step-item warn">
                    <div class="step-label">Advertencia</div>
                    <div class="step-body">Eliminar un docente borra <strong>en cascada</strong> todas sus evaluaciones, detalles de rúbrica y alumnos asignados. Esta acción <strong>no se puede deshacer</strong>.</div>
                </div>
                <div class="step-item danger">
                    <div class="step-label">Cómo hacerlo</div>
                    <div class="step-body">Haz clic en el botón rojo 🗑️ en la fila del docente. Confirma la acción en el cuadro de diálogo de SweetAlert2.</div>
                </div>
            </div>
        </div>

        <!-- ════════════════ 4. ALUMNOS ════════════════ -->
        <div class="section-block" id="alumnos">
            <h2><span class="section-num">4</span> Alumnos</h2>
            <p>En la pestaña <strong>"Alumnos"</strong> gestionas los estudiantes. Hay tres formas de registrar alumnos en el sistema.</p>

            <h3>4.1 Agregar individual</h3>
            <div class="step-list">
                <div class="step-item">
                    <div class="step-label">Formulario</div>
                    <div class="step-body">
                        Completa: <strong>Matrícula</strong>, <strong>Nombre Completo</strong>, <strong>Semestre/Grupo</strong>, <strong>Correo</strong> (opcional) y selecciona el <strong>Docente</strong> asignado.
                    </div>
                </div>
            </div>

            <h3>4.2 Importar desde Excel</h3>
            <div class="step-list">
                <div class="step-item">
                    <div class="step-label">Paso 1</div>
                    <div class="step-body">Selecciona el <strong>docente</strong> al que se asignarán los alumnos.</div>
                </div>
                <div class="step-item">
                    <div class="step-label">Paso 2</div>
                    <div class="step-body">Arrastra un archivo <code>.xlsx</code> o <code>.xls</code> al área de carga o haz clic para seleccionarlo. El archivo se parsea <strong>del lado del cliente</strong> con SheetJS.</div>
                </div>
                <div class="step-item">
                    <div class="step-label">Paso 3</div>
                    <div class="step-body">Revisa la <strong>vista previa</strong> con los datos detectados (Matrícula, Nombre, Semestre, Correo).</div>
                </div>
                <div class="step-item success">
                    <div class="step-label">Paso 4</div>
                    <div class="step-body">Haz clic en <strong>"Confirmar y Subir"</strong>. Los registros se insertan en una transacción; los duplicados se omiten automáticamente.</div>
                </div>
            </div>

            <div class="info-box info">
                <svg class="info-box-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <span><strong>Formato esperado:</strong> Columnas en orden: <code>Matrícula</code>, <code>Nombre</code>, <code>Semestre/Grupo</code>, <code>Correo</code> (opcional). La primera fila debe contener los encabezados.</span>
            </div>

            <h3>4.3 Eliminar un alumno</h3>
            <div class="step-list">
                <div class="step-item warn">
                    <div class="step-label">Advertencia</div>
                    <div class="step-body">Eliminar un alumno también borra <strong>todas sus evaluaciones</strong> y detalles de rúbrica asociados.</div>
                </div>
                <div class="step-item danger">
                    <div class="step-label">Acción</div>
                    <div class="step-body">Botón rojo 🗑️ en la fila del alumno. Confirmación vía SweetAlert2.</div>
                </div>
            </div>

            <h3>4.4 Búsqueda</h3>
            <p>El campo de búsqueda filtra la tabla en tiempo real por matrícula, nombre, semestre o correo.</p>
        </div>

        <!-- ════════════════ 5. EVALUACIONES ════════════════ -->
        <div class="section-block" id="evaluaciones">
            <h2><span class="section-num">5</span> Evaluaciones</h2>
            <p>La pestaña <strong>"Evaluaciones"</strong> muestra el registro completo de evaluaciones del sistema.</p>

            <h3>Visualización</h3>
            <ul>
                <li>Tabla con <strong>Fecha</strong>, <strong>UUID</strong> (truncado), <strong>Matrícula</strong>, <strong>Alumno</strong>, <strong>Evaluador</strong> y <strong>Puntaje</strong>.</li>
                <li>Campo de <strong>búsqueda</strong> para filtrar en tiempo real.</li>
            </ul>

            <h3>Detalle de evaluación</h3>
            <p>Haz clic en <strong>"Ver"</strong> para abrir un modal con la información completa:</p>
            <ul>
                <li>Datos del alumno y evaluador.</li>
                <li>Entorno clínico, tipo de paciente y complejidad.</li>
                <li>Tiempos de observación y feedback.</li>
                <li>Calificación final.</li>
                <li>Botón para <strong>reenviar el reporte PDF</strong> por correo.</li>
            </ul>

            <h3>Reenvío de correo</h3>
            <div class="step-list">
                <div class="step-item">
                    <div class="step-label">Requisito</div>
                    <div class="step-body">El alumno debe tener un <strong>correo electrónico</strong> registrado (columna <code>correo</code> en la tabla de alumnos).</div>
                </div>
                <div class="step-item">
                    <div class="step-label">Proceso</div>
                    <div class="step-body">Al hacer clic en <strong>"Reenviar Reporte por Correo"</strong>, el sistema genera un nuevo PDF con FPDF y lo envía mediante PHPMailer. El resultado se muestra en una notificación.</div>
                </div>
            </div>

            <div class="info-box info">
                <svg class="info-box-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <span><strong>SMTP:</strong> El envío de correos depende de la configuración en <code>config.php</code>. El sistema incluye auto-detección: si el servidor SMTP no coincide con el dominio del correo, conmuta automáticamente a <code>smtp.gmail.com</code>.</span>
            </div>
        </div>

        <!-- ════════════════ 6. DB RESET ════════════════ -->
        <div class="section-block" id="reset">
            <h2><span class="section-num">6</span> Reconstruir Base de Datos</h2>
            <p>El botón <strong>"Reconstruir BD"</strong> (junto al título del dashboard) restablece el sistema a su estado inicial de fábrica.</p>

            <div class="step-list">
                <div class="step-item danger">
                    <div class="step-label">⚠️ Riesgo de pérdida de datos</div>
                    <div class="step-body">Esta acción <strong>elimina permanentemente</strong> todos los registros: docentes, alumnos, evaluaciones, detalles de rúbrica y logs. No hay forma de recuperarlos.</div>
                </div>
                <div class="step-item warn">
                    <div class="step-label">Proceso</div>
                    <div class="step-body">
                        1. Haz clic en <strong>"Reconstruir BD"</strong>.<br>
                        2. Confirma en el modal de advertencia.<br>
                        3. El sistema ejecuta <code>setup.php</code>: borra la BD, recrea tablas y siembra datos iniciales.<br>
                        4. Deberás <strong>iniciar sesión nuevamente</strong> con las credenciales por defecto.
                    </div>
                </div>
                <div class="step-item success">
                    <div class="step-label">Datos restaurados</div>
                    <div class="step-body">1 docente: <code>evaluador@upe.edu.mx</code> / <code>password123</code> · 3 alumnos de ejemplo.</div>
                </div>
            </div>

            <div class="info-box warn">
                <svg class="info-box-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <span><strong>Recomendación:</strong> Antes de reconstruir, asegúrate de que la app Android haya sincronizado todas las evaluaciones pendientes. Los datos no sincronizados se perderán.</span>
            </div>
        </div>

        <!-- ════════════════ 7. TIPS ════════════════ -->
        <div class="section-block" id="tips">
            <h2><span class="section-num">7</span> Consejos y Notas</h2>

            <div class="table-wrap">
            <table>
                <tr><th>Área</th><th>Recomendación</th></tr>
                <tr>
                    <td><span class="tag tag-blue">Docentes</span></td>
                    <td>Usa correos reales para que los docentes puedan iniciar sesión en la app Android.</td>
                </tr>
                <tr>
                    <td><span class="tag tag-green">Alumnos</span></td>
                    <td>Registra el correo del alumno para que reciba automáticamente los reportes PDF de sus evaluaciones.</td>
                </tr>
                <tr>
                    <td><span class="tag tag-yellow">Excel</span></td>
                    <td>La importación por Excel es ideal para cargas masivas al inicio del semestre. Verifica el formato antes de confirmar.</td>
                </tr>
                <tr>
                    <td><span class="tag tag-purple">SMTP</span></td>
                    <td>Si usas Gmail, genera una <strong>"Contraseña de Aplicación"</strong> en lugar de usar tu contraseña principal.</td>
                </tr>
                <tr>
                    <td><span class="tag tag-red">Sincronización</span></td>
                    <td>La app Android funciona offline-first. Los datos se sincronizan automáticamente al recuperar conexión.</td>
                </tr>
            </table>
            </div>

            <div class="info-box info">
                <svg class="info-box-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <span><strong>¿Problemas?</strong> Revisa <code>email_log.log</code> en la raíz del proyecto para diagnosticar fallos en el envío de correos, o consulta el log de errores de PHP.</span>
            </div>
        </div>

        <!-- ═══ FOOTER ═══ -->
        <div class="guide-footer">
            <p>MINI-CEX v2.0 — Guía de uso del panel administrativo</p>
            <a href="<?= base_url('admin') ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Ir al Panel
            </a>
        </div>

    </div>
</main>

<!-- ═══════════════════════════════════════════════
     JAVASCRIPT
     ═══════════════════════════════════════════════ -->
<script>
(function() {
    'use strict';

    // ─── Sidebar ──────────────────────────────
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggle = document.getElementById('sidebarToggle');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    if (toggle) toggle.addEventListener('click', openSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);

    // ─── Active link on scroll ────────────────
    const links = document.querySelectorAll('.sidebar-link');
    const sections = [];

    links.forEach(link => {
        const href = link.getAttribute('href');
        if (href && href.startsWith('#')) {
            const target = document.getElementById(href.slice(1));
            if (target) sections.push({ el: target, link: link });
        }
    });

    function updateActive() {
        const scrollY = window.scrollY + 110;
        let current = null;

        sections.forEach(({ el, link }) => {
            const top = el.offsetTop;
            const bottom = top + el.offsetHeight;
            if (scrollY >= top && scrollY < bottom) current = link;
        });

        if (!current && sections.length > 0) {
            const last = sections[sections.length - 1];
            const bottom = last.el.offsetTop + last.el.offsetHeight;
            if (window.scrollY + window.innerHeight >= document.documentElement.scrollHeight - 50) {
                current = last.link;
            }
        }

        links.forEach(l => l.classList.remove('active'));
        if (current) current.classList.add('active');
    }

    window.addEventListener('scroll', updateActive, { passive: true });
    window.addEventListener('resize', updateActive, { passive: true });
    updateActive();

    // ─── Close sidebar on link click (mobile) ──
    links.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 1024) closeSidebar();
        });
    });
})();
</script>
</body>
</html>
