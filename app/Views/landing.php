<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="MINI-CEX — Plataforma de evaluación clínica para Terapia Física y Rehabilitación. Gestiona evaluaciones, docentes y alumnos desde cualquier dispositivo.">
<title>MINI-CEX | Plataforma de Evaluación Clínica</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('landing.css') ?>">
</head>
<body>

<!-- ═══════════════════════════════════════════ -->
<!-- NAVBAR                                      -->
<!-- ═══════════════════════════════════════════ -->
<nav class="navbar" id="navbar">
  <div class="nav-container">
    <a href="#" class="nav-brand">
      <img src="<?= base_url('logo_small.png') ?>" alt="MINI-CEX Logo" class="nav-logo">
      <div class="nav-brand-text">
        <span class="nav-brand-name">MINI-CEX</span>
        <span class="nav-brand-sub">Terapia Física</span>
      </div>
    </a>
    <div class="nav-links" id="navLinks">
      <a href="#inicio" class="nav-link active">Inicio</a>
      <a href="#features" class="nav-link">Características</a>
      <a href="#plataforma" class="nav-link">Plataforma</a>
      <a href="#stats" class="nav-link">Estadísticas</a>
      <a href="#faq" class="nav-link">FAQ</a>
    </div>
    <div class="nav-actions">
      <button class="btn-nav-outline" id="btnAdmin" onclick="window.location.href='<?= base_url('admin') ?>'">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        Panel Admin
      </button>
      <button class="btn-nav-primary" id="btnDownload" onclick="window.open('https://pruebaskinder.online/minicex/MINI-CEX.apk', '_blank')">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Descargar App
      </button>
    </div>
    <button class="nav-hamburger" id="navHamburger" aria-label="Menú">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu" id="mobileMenu">
  <div class="mobile-menu-content">
    <a href="#inicio" class="mobile-link">Inicio</a>
    <a href="#features" class="mobile-link">Características</a>
    <a href="#plataforma" class="mobile-link">Plataforma</a>
    <a href="#stats" class="mobile-link">Estadísticas</a>
    <a href="#faq" class="mobile-link">FAQ</a>
    <div class="mobile-actions">
      <button class="btn-nav-outline mobile-btn" onclick="window.location.href='<?= base_url('admin') ?>'">Panel Admin</button>
      <button class="btn-nav-primary mobile-btn" onclick="window.open('https://pruebaskinder.online/minicex/MINI-CEX.apk', '_blank')">Descargar App</button>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════ -->
<!-- HERO SECTION                                -->
<!-- ═══════════════════════════════════════════ -->
<section class="hero" id="inicio">
  <div class="hero-bg">
    <div class="hero-gradient"></div>
    <div class="hero-grid"></div>
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="hero-orb hero-orb-3"></div>
    <!-- Floating Particles -->
    <div class="particles" id="particles"></div>
  </div>
  <div class="hero-container">
    <div class="hero-content">
      <div class="hero-badge" id="heroBadge">
        <span class="badge-dot"></span>
        <span>Plataforma v2.0 — Disponible Ahora</span>
      </div>
      <h1 class="hero-title" id="heroTitle">
        <span class="title-line">Evaluación Clínica</span>
        <span class="title-line title-accent">Inteligente</span>
        <span class="title-line title-small">para Terapia Física</span>
      </h1>
      <p class="hero-description" id="heroDesc">
        Transforma la evaluación MINI-CEX con una plataforma moderna que conecta 
        docentes, alumnos y administradores. Registra evaluaciones desde tu móvil 
        y gestiona todo desde el panel web.
      </p>
      <div class="hero-buttons" id="heroButtons">
        <button class="btn-hero-primary" id="heroBtnDownload" onclick="window.open('https://pruebaskinder.online/minicex/MINI-CEX.apk', '_blank')">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          Descargar App Android
          <span class="btn-shine"></span>
        </button>
        <button class="btn-hero-outline" id="heroBtnAdmin" onclick="window.location.href='<?= base_url('admin') ?>'">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>
          Ir al Panel de Admin
        </button>
      </div>
      <div class="hero-stats" id="heroStats">
        <div class="hero-stat">
          <span class="stat-number" data-count="150">0</span><span class="stat-plus">+</span>
          <span class="stat-label">Evaluaciones</span>
        </div>
        <div class="hero-stat-divider"></div>
        <div class="hero-stat">
          <span class="stat-number" data-count="25">0</span><span class="stat-plus">+</span>
          <span class="stat-label">Docentes Activos</span>
        </div>
        <div class="hero-stat-divider"></div>
        <div class="hero-stat">
          <span class="stat-number" data-count="99">0</span><span class="stat-plus">%</span>
          <span class="stat-label">Disponibilidad</span>
        </div>
      </div>
    </div>
    <div class="hero-visual" id="heroVisual">
      <div class="hero-phone-wrapper">
        <!-- Floating Badge Cards -->
        <div class="float-card float-card-1" id="floatCard1">
          <div class="fc-icon fc-icon-green">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <div class="fc-text">
            <span class="fc-title">Evaluación Completada</span>
            <span class="fc-sub">Juan Pérez — 9.2/10</span>
          </div>
        </div>
        <div class="float-card float-card-2" id="floatCard2">
          <div class="fc-icon fc-icon-blue">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          </div>
          <div class="fc-text">
            <span class="fc-title">Sincronizado</span>
            <span class="fc-sub">Datos actualizados</span>
          </div>
        </div>
        <div class="float-card float-card-3" id="floatCard3">
          <div class="fc-icon fc-icon-gold">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
          </div>
          <div class="fc-text">
            <span class="fc-title">PDF Generado</span>
            <span class="fc-sub">Reporte listo</span>
          </div>
        </div>
        <!-- Phone Mockup -->
        <div class="phone-mockup">
          <div class="phone-screen">
            <div class="screen-header">
              <div class="screen-status-bar">
                <span>9:41</span>
                <div class="status-icons">
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3a4.237 4.237 0 0 0-6 0zm-4-4l2 2a7.074 7.074 0 0 1 10 0l2-2C15.14 9.14 8.87 9.14 5 13z"/></svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><rect x="17" y="2" width="5" height="20" rx="1"/><rect x="11" y="7" width="5" height="15" rx="1"/><rect x="5" y="12" width="5" height="10" rx="1"/></svg>
                </div>
              </div>
              <div class="screen-app-bar">
                <img src="<?= base_url('logo_small.png') ?>" alt="Logo" class="screen-logo">
                <span class="screen-app-name">MINI-CEX</span>
              </div>
            </div>
            <div class="screen-body">
              <div class="screen-welcome">
                <div class="sw-avatar">DR</div>
                <div>
                  <div class="sw-greeting">Bienvenido, Dr. Ramírez</div>
                  <div class="sw-role">Docente Evaluador</div>
                </div>
              </div>
              <div class="screen-card sc-1">
                <div class="sc-label">Evaluaciones Hoy</div>
                <div class="sc-value">3</div>
                <div class="sc-bar"><div class="sc-bar-fill" style="width:65%"></div></div>
              </div>
              <div class="screen-card sc-2">
                <div class="sc-label">Alumnos Asignados</div>
                <div class="sc-value">12</div>
                <div class="sc-bar"><div class="sc-bar-fill" style="width:85%"></div></div>
              </div>
              <div class="screen-btn-eval">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Nueva Evaluación
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Scroll indicator -->
  <div class="scroll-indicator" id="scrollIndicator">
    <div class="scroll-mouse">
      <div class="scroll-wheel"></div>
    </div>
    <span>Desliza para explorar</span>
  </div>
</section>

<!-- ═══════════════════════════════════════════ -->
<!-- TRUSTED BY / LOGOS                          -->
<!-- ═══════════════════════════════════════════ -->
<section class="trusted" id="trusted">
  <div class="container">
    <p class="trusted-label">Utilizado por instituciones de salud y educación</p>
    <div class="trusted-logos">
      <div class="trusted-item">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 4 3 6 3s6-1 6-3v-5"/></svg>
        <span>Universidades</span>
      </div>
      <div class="trusted-item">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <span>Hospitales</span>
      </div>
      <div class="trusted-item">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        <span>Clínicas</span>
      </div>
      <div class="trusted-item">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        <span>Residencias Médicas</span>
      </div>
      <div class="trusted-item">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        <span>Instituciones de Salud</span>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════ -->
<!-- FEATURES SECTION                            -->
<!-- ═══════════════════════════════════════════ -->
<section class="features" id="features">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Características</span>
      <h2 class="section-title">Todo lo que necesitas para<br><span class="accent">evaluar con excelencia</span></h2>
      <p class="section-desc">Una suite completa de herramientas diseñadas específicamente para la evaluación clínica MINI-CEX en el área de Terapia Física y Rehabilitación.</p>
    </div>
    <div class="features-grid">
      <!-- Feature 1 -->
      <div class="feature-card" data-feature="1">
        <div class="feature-icon-wrap">
          <div class="feature-icon fi-blue">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
          </div>
        </div>
        <h3>App Móvil Nativa</h3>
        <p>Realiza evaluaciones desde tu dispositivo Android. Interfaz intuitiva con captura de firmas y modo offline.</p>
        <div class="feature-tag-row">
          <span class="ftag">Android</span>
          <span class="ftag">Offline</span>
          <span class="ftag">Firma Digital</span>
        </div>
      </div>
      <!-- Feature 2 -->
      <div class="feature-card" data-feature="2">
        <div class="feature-icon-wrap">
          <div class="feature-icon fi-gold">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
          </div>
        </div>
        <h3>Panel Administrativo</h3>
        <p>Gestiona docentes, alumnos y evaluaciones desde un panel web potente con estadísticas en tiempo real.</p>
        <div class="feature-tag-row">
          <span class="ftag">Dashboard</span>
          <span class="ftag">Reportes</span>
          <span class="ftag">CRUD</span>
        </div>
      </div>
      <!-- Feature 3 -->
      <div class="feature-card" data-feature="3">
        <div class="feature-icon-wrap">
          <div class="feature-icon fi-green">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          </div>
        </div>
        <h3>Sincronización Automática</h3>
        <p>Las evaluaciones realizadas en la app se sincronizan automáticamente con el servidor cuando hay conexión.</p>
        <div class="feature-tag-row">
          <span class="ftag">Auto-sync</span>
          <span class="ftag">API REST</span>
          <span class="ftag">Tiempo Real</span>
        </div>
      </div>
      <!-- Feature 4 -->
      <div class="feature-card" data-feature="4">
        <div class="feature-icon-wrap">
          <div class="feature-icon fi-purple">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
          </div>
        </div>
        <h3>Reportes PDF</h3>
        <p>Genera reportes profesionales en PDF de cada evaluación con rúbricas detalladas y firmas digitales.</p>
        <div class="feature-tag-row">
          <span class="ftag">PDF</span>
          <span class="ftag">Rúbricas</span>
          <span class="ftag">Exportar</span>
        </div>
      </div>
      <!-- Feature 5 -->
      <div class="feature-card" data-feature="5">
        <div class="feature-icon-wrap">
          <div class="feature-icon fi-rose">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
        </div>
        <h3>Seguridad Robusta</h3>
        <p>Autenticación segura, sesiones protegidas y encriptación de datos sensibles de pacientes y evaluaciones.</p>
        <div class="feature-tag-row">
          <span class="ftag">Auth</span>
          <span class="ftag">Encriptación</span>
          <span class="ftag">Sesiones</span>
        </div>
      </div>
      <!-- Feature 6 -->
      <div class="feature-card" data-feature="6">
        <div class="feature-icon-wrap">
          <div class="feature-icon fi-teal">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
          </div>
        </div>
        <h3>Notificaciones Email</h3>
        <p>Sistema SMTP integrado para notificaciones automáticas a docentes y alumnos sobre evaluaciones.</p>
        <div class="feature-tag-row">
          <span class="ftag">SMTP</span>
          <span class="ftag">Alertas</span>
          <span class="ftag">Automático</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════ -->
<!-- PLATFORM OVERVIEW                           -->
<!-- ═══════════════════════════════════════════ -->
<section class="platform" id="plataforma">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Plataforma</span>
      <h2 class="section-title">Dos herramientas,<br><span class="accent">un ecosistema</span></h2>
      <p class="section-desc">La app móvil y el panel web trabajan juntos de forma transparente para brindarte el mejor flujo de trabajo en evaluación clínica.</p>
    </div>

    <!-- Platform Card 1: App Móvil -->
    <div class="platform-row">
      <div class="platform-info">
        <div class="pi-badge">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
          App Android
        </div>
        <h3>Evalúa en cualquier momento y lugar</h3>
        <p>La app móvil para Android permite a los docentes realizar evaluaciones MINI-CEX directamente desde su dispositivo, con o sin conexión a internet.</p>
        <ul class="pi-list">
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Formulario de evaluación completo con rúbricas
          </li>
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Captura de firma digital del evaluador y alumno
          </li>
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Modo offline — sincroniza cuando haya red
          </li>
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Historial completo de evaluaciones realizadas
          </li>
        </ul>
        <button class="btn-platform" id="platformDownload" onclick="window.open('https://pruebaskinder.online/minicex/MINI-CEX.apk', '_blank')">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          Descargar para Android
        </button>
      </div>
      <div class="platform-visual pv-app">
        <div class="pv-glow"></div>
        <div class="pv-app-showcase">
          <div class="app-screen app-screen-1">
            <div class="as-header">
              <div class="as-notch"></div>
            </div>
            <div class="as-body">
              <div class="as-title-bar">
                <span class="as-title">Nueva Evaluación</span>
              </div>
              <div class="as-form-field">
                <span class="as-field-label">Alumno</span>
                <div class="as-field-input">María García — 7mo B</div>
              </div>
              <div class="as-form-field">
                <span class="as-field-label">Entorno Clínico</span>
                <div class="as-field-input">Consulta MF</div>
              </div>
              <div class="as-form-field">
                <span class="as-field-label">Competencias</span>
                <div class="as-rubric">
                  <div class="as-rubric-item"><span>Historia Clínica</span><span class="as-score">9</span></div>
                  <div class="as-rubric-item"><span>Examen Físico</span><span class="as-score">8</span></div>
                  <div class="as-rubric-item"><span>Juicio Clínico</span><span class="as-score">9</span></div>
                </div>
              </div>
              <div class="as-btn">Finalizar y Firmar</div>
            </div>
          </div>
          <div class="app-screen app-screen-2">
            <div class="as-header">
              <div class="as-notch"></div>
            </div>
            <div class="as-body">
              <div class="as-title-bar">
                <span class="as-title">Resultados</span>
              </div>
              <div class="as-result-card">
                <div class="as-result-score">8.7</div>
                <div class="as-result-label">Calificación Total</div>
                <div class="as-result-bar"><div class="as-result-fill" style="width:87%"></div></div>
              </div>
              <div class="as-result-items">
                <div class="as-ri"><span>Historia Clínica</span><div class="as-ri-dots"></div><span class="as-ri-val">9/10</span></div>
                <div class="as-ri"><span>Examen Físico</span><div class="as-ri-dots"></div><span class="as-ri-val">8/10</span></div>
                <div class="as-ri"><span>Juicio Clínico</span><div class="as-ri-dots"></div><span class="as-ri-val">9/10</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Platform Card 2: Panel Web -->
    <div class="platform-row platform-row-reverse">
      <div class="platform-info">
        <div class="pi-badge pi-badge-gold">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
          Panel Web
        </div>
        <h3>Control total desde tu navegador</h3>
        <p>El panel de administración web te da visibilidad completa sobre el estado de docentes, alumnos y evaluaciones con un diseño moderno y funcional.</p>
        <ul class="pi-list">
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Dashboard con métricas y gráficos en tiempo real
          </li>
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Gestión de Docentes, Alumnos y Evaluaciones
          </li>
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Exportación a Excel y generación de reportes PDF
          </li>
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Diseño responsivo con barra lateral y navegación móvil
          </li>
        </ul>
        <button class="btn-platform btn-platform-gold" id="platformAdmin" onclick="window.location.href='<?= base_url('admin') ?>'">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
          Abrir Panel de Administración
        </button>
      </div>
      <div class="platform-visual pv-web">
        <div class="pv-glow pv-glow-gold"></div>
        <div class="pv-browser">
          <div class="browser-bar">
            <div class="browser-dots">
              <span class="bd bd-r"></span>
              <span class="bd bd-y"></span>
              <span class="bd bd-g"></span>
            </div>
            <div class="browser-url">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              minicex.tudominio.com/admin
            </div>
          </div>
          <div class="browser-content">
            <div class="bc-sidebar">
              <div class="bc-brand">
                <div class="bc-logo-circle"></div>
                <span>MINI-CEX</span>
              </div>
              <div class="bc-nav-item bc-active">
                <div class="bc-nav-dot"></div> Panel
              </div>
              <div class="bc-nav-item">
                <div class="bc-nav-dot"></div> Docentes
              </div>
              <div class="bc-nav-item">
                <div class="bc-nav-dot"></div> Alumnos
              </div>
              <div class="bc-nav-item">
                <div class="bc-nav-dot"></div> Evaluaciones
              </div>
            </div>
            <div class="bc-main">
              <div class="bc-topbar">
                <span class="bc-page-title">Panel de Control</span>
                <div class="bc-avatar"></div>
              </div>
              <div class="bc-cards">
                <div class="bc-stat-card bsc-1">
                  <div class="bsc-label">Evaluaciones</div>
                  <div class="bsc-val">156</div>
                </div>
                <div class="bc-stat-card bsc-2">
                  <div class="bsc-label">Docentes</div>
                  <div class="bsc-val">12</div>
                </div>
                <div class="bc-stat-card bsc-3">
                  <div class="bsc-label">Alumnos</div>
                  <div class="bsc-val">48</div>
                </div>
              </div>
              <div class="bc-chart">
                <div class="bc-chart-title">Evaluaciones por Mes</div>
                <div class="bc-chart-bars">
                  <div class="bc-bar" style="height:40%"></div>
                  <div class="bc-bar" style="height:65%"></div>
                  <div class="bc-bar" style="height:45%"></div>
                  <div class="bc-bar" style="height:80%"></div>
                  <div class="bc-bar" style="height:60%"></div>
                  <div class="bc-bar" style="height:90%"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════ -->
<!-- STATISTICS SECTION                          -->
<!-- ═══════════════════════════════════════════ -->
<section class="stats-section" id="stats">
  <div class="stats-bg">
    <div class="stats-orb stats-orb-1"></div>
    <div class="stats-orb stats-orb-2"></div>
  </div>
  <div class="container">
    <div class="section-header section-header-light">
      <span class="section-tag section-tag-light">En Números</span>
      <h2 class="section-title section-title-light">Impacto real en la<br><span class="accent-light">educación médica</span></h2>
    </div>
    <div class="stats-grid">
      <div class="stat-card" data-stat>
        <div class="stat-card-number"><span class="counter" data-target="500">0</span>+</div>
        <div class="stat-card-label">Evaluaciones Registradas</div>
        <div class="stat-card-bar"><div class="stat-bar-fill sbf-1"></div></div>
      </div>
      <div class="stat-card" data-stat>
        <div class="stat-card-number"><span class="counter" data-target="50">0</span>+</div>
        <div class="stat-card-label">Docentes Evaluadores</div>
        <div class="stat-card-bar"><div class="stat-bar-fill sbf-2"></div></div>
      </div>
      <div class="stat-card" data-stat>
        <div class="stat-card-number"><span class="counter" data-target="200">0</span>+</div>
        <div class="stat-card-label">Alumnos Evaluados</div>
        <div class="stat-card-bar"><div class="stat-bar-fill sbf-3"></div></div>
      </div>
      <div class="stat-card" data-stat>
        <div class="stat-card-number"><span class="counter" data-target="99">0</span>%</div>
        <div class="stat-card-label">Tiempo de Actividad</div>
        <div class="stat-card-bar"><div class="stat-bar-fill sbf-4"></div></div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════ -->
<!-- HOW IT WORKS                                -->
<!-- ═══════════════════════════════════════════ -->
<section class="how-it-works" id="howItWorks">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Flujo de Trabajo</span>
      <h2 class="section-title">Tan simple como<br><span class="accent">1, 2, 3</span></h2>
    </div>
    <div class="steps-timeline">
      <div class="step-card" data-step="1">
        <div class="step-number">01</div>
        <div class="step-connector"></div>
        <div class="step-content">
          <div class="step-icon si-blue">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          </div>
          <h4>Descarga e Instala</h4>
          <p>Descarga la app MINI-CEX en tu dispositivo Android e inicia sesión con tus credenciales institucionales.</p>
        </div>
      </div>
      <div class="step-card" data-step="2">
        <div class="step-number">02</div>
        <div class="step-connector"></div>
        <div class="step-content">
          <div class="step-icon si-gold">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><path d="M9 14l2 2 4-4"/></svg>
          </div>
          <h4>Realiza la Evaluación</h4>
          <p>Completa el formulario MINI-CEX con rúbricas, puntajes y observaciones. Firma digitalmente al terminar.</p>
        </div>
      </div>
      <div class="step-card" data-step="3">
        <div class="step-number">03</div>
        <div class="step-content">
          <div class="step-icon si-green">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          </div>
          <h4>Revisa y Exporta</h4>
          <p>Los datos se sincronizan al panel web. Descarga reportes PDF, consulta estadísticas y gestiona registros.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════ -->
<!-- FAQ SECTION                                 -->
<!-- ═══════════════════════════════════════════ -->
<section class="faq" id="faq">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">FAQ</span>
      <h2 class="section-title">Preguntas<br><span class="accent">frecuentes</span></h2>
    </div>
    <div class="faq-grid">
      <div class="faq-item" data-faq>
        <button class="faq-question">
          <span>¿Qué es MINI-CEX?</span>
          <svg class="faq-chevron" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="faq-answer">
          <p>El Mini-Clinical Evaluation Exercise (Mini-CEX) es una herramienta de evaluación clínica utilizada en el ámbito médico y de rehabilitación para evaluar competencias clínicas de estudiantes en entornos reales de práctica.</p>
        </div>
      </div>
      <div class="faq-item" data-faq>
        <button class="faq-question">
          <span>¿Necesito conexión a internet para evaluar?</span>
          <svg class="faq-chevron" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="faq-answer">
          <p>No. La app funciona completamente offline. Las evaluaciones se almacenan localmente y se sincronizan automáticamente con el servidor cuando se detecta conexión a internet.</p>
        </div>
      </div>
      <div class="faq-item" data-faq>
        <button class="faq-question">
          <span>¿Qué dispositivos son compatibles?</span>
          <svg class="faq-chevron" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="faq-answer">
          <p>La app está disponible para dispositivos Android (versión 7.0 y superior). El panel web es accesible desde cualquier navegador moderno en computadora, tablet o móvil.</p>
        </div>
      </div>
      <div class="faq-item" data-faq>
        <button class="faq-question">
          <span>¿Cómo accedo al panel de administración?</span>
          <svg class="faq-chevron" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="faq-answer">
          <p>El panel de administración web está disponible en la URL de tu institución. Ingresa con las credenciales proporcionadas por tu administrador para gestionar docentes, alumnos y evaluaciones.</p>
        </div>
      </div>
      <div class="faq-item" data-faq>
        <button class="faq-question">
          <span>¿Los datos están seguros?</span>
          <svg class="faq-chevron" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="faq-answer">
          <p>Sí. Utilizamos conexiones seguras, autenticación protegida y la base de datos está respaldada. Todos los datos sensibles se manejan con estrictos protocolos de privacidad institucional.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════ -->
<!-- CTA SECTION                                 -->
<!-- ═══════════════════════════════════════════ -->
<section class="cta" id="cta">
  <div class="cta-bg">
    <div class="cta-orb cta-orb-1"></div>
    <div class="cta-orb cta-orb-2"></div>
    <div class="cta-grid-pattern"></div>
  </div>
  <div class="container">
    <div class="cta-content">
      <h2 class="cta-title">¿Listo para transformar<br>tus evaluaciones clínicas?</h2>
      <p class="cta-desc">Únete a las instituciones que ya optimizan su proceso de evaluación MINI-CEX con nuestra plataforma.</p>
      <div class="cta-buttons">
        <button class="btn-cta-primary" id="ctaDownload" onclick="window.open('https://pruebaskinder.online/minicex/MINI-CEX.apk', '_blank')">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          Descargar App
        </button>
        <button class="btn-cta-outline" id="ctaAdmin" onclick="window.location.href='<?= base_url('admin') ?>'">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
          Panel de Administración
        </button>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════ -->
<!-- FOOTER                                      -->
<!-- ═══════════════════════════════════════════ -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <div class="footer-logo-row">
          <img src="<?= base_url('logo_small.png') ?>" alt="Logo" class="footer-logo">
          <div>
            <div class="footer-brand-name">MINI-CEX</div>
            <div class="footer-brand-sub">Terapia Física y Rehabilitación</div>
          </div>
        </div>
        <p class="footer-desc">Plataforma integral de evaluación clínica para instituciones de salud y educación médica.</p>
      </div>
      <div class="footer-links-group">
        <h4>Plataforma</h4>
        <a href="https://pruebaskinder.online/minicex/MINI-CEX.apk" target="_blank">App Android</a>
        <a href="<?= base_url('admin') ?>">Panel Web</a>
        <a href="<?= base_url('api/docs') ?>">API Documentación</a>
        <a href="<?= base_url('api/docs#reportes-pdf') ?>">Reportes PDF</a>
      </div>
      <div class="footer-links-group">
        <h4>Recursos</h4>
        <a href="<?= base_url('admin/guide') ?>">Guía de Uso</a>
        <a href="#">FAQ</a>
        <a href="#">Soporte</a>
        <a href="#">Contacto</a>
      </div>
      <div class="footer-links-group">
        <h4>Legal</h4>
        <a href="#">Privacidad</a>
        <a href="#">Términos</a>
        <a href="#">Licencia</a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2026 MINI-CEX — Terapia Física y Rehabilitación. Todos los derechos reservados.</p>
      <div class="footer-socials">
        <a href="https://github.com/yire033-code/MINI-CEX" target="_blank" rel="noopener" aria-label="GitHub">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
        </a>
      </div>
    </div>
  </div>
</footer>

<!-- Sticky Mobile CTA -->
<div class="mobile-sticky-cta">
  <a href="https://pruebaskinder.online/minicex/MINI-CEX.apk" target="_blank" rel="noopener" class="btn-sticky-download">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
    Descargar App Android
  </a>
</div>

<!-- GSAP CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="<?= base_url('landing.js') ?>"></script>
</body>
</html>
