<!-- ══════════════════════════════════════════════════
     LOGIN VIEW
     ══════════════════════════════════════════════════ -->
<div class="login-page">
  <div class="login-left">
    <div class="l-content">
      <div class="l-logo">
        <img src="logo.png" alt="Logo">
      </div>
      <h1>Gestión Clínica <br><span>Inteligente</span></h1>
      <p>Plataforma avanzada para la evaluación MINI-CEX y el seguimiento académico institucional.</p>
      <div class="l-features">
        <div class="l-feat"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg> Acceso Seguro</div>
        <div class="l-feat"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Datos Validados</div>
        <div class="l-feat"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg> Multi-plataforma</div>
      </div>
    </div>
  </div>
  <div class="login-right">
    <div class="login-box">
      <div class="login-logo-mobile">
        <img src="logo.png" alt="Logo">
      </div>
      <div class="login-header">
        <h2>Bienvenido</h2>
        <p>Ingresa tus credenciales para continuar</p>
      </div>

      <form onsubmit="ajaxLogin(event)">
        <input type="hidden" name="action" value="login">
        <div class="field">
          <input type="text" name="username" placeholder="Usuario" required autocomplete="username">
          <svg class="fi" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <div class="field">
          <input type="password" name="password" id="pw" placeholder="Contraseña" required autocomplete="current-password">
          <svg class="fi" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          <button type="button" class="toggle-pw" onclick="togglePw()"><svg id="pwIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
        </div>
        <button type="submit" class="btn btn-gold" style="margin-top:10px">Iniciar Sesión <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg></button>
      </form>
      
      <div class="login-footer">
        <p>© 2026 Terapia Física y Rehabilitación. Todos los derechos reservados.</p>
      </div>
    </div>
  </div>
</div>
