<!-- ═══════ MODAL ═══════ -->
<div class="modal-bg" id="modalBg" onclick="if(event.target===this)closeModal()">
  <div class="modal">
    <button class="modal-x" onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
    <h2><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg> Reporte Clínico</h2>
    <div class="detail-grid">
      <div class="dg-item"><label>Alumno</label><p id="mdAlumno"></p></div>
      <div class="dg-item"><label>Terapeuta</label><p id="mdEval"></p></div>
      <div class="dg-item"><label>Entorno / Paciente</label><p id="mdEntorno"></p></div>
      <div class="dg-item"><label>Complejidad</label><p id="mdComplejidad"></p></div>
      <div class="dg-item"><label>Tiempos</label><p id="mdTiempos"></p></div>
      <div class="dg-item"><label>Evaluación Final</label><p class="score" id="mdScore"></p></div>
    </div>
    <button class="btn btn-blue" id="mdResendBtn" style="margin-top: 20px;" onclick="resendModalEmail()">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
      Reenviar Reporte por Correo
    </button>
  </div>
</div>

<!-- ═══════ DB RESET MODAL ═══════ -->
<div class="modal-bg" id="dbResetModal" onclick="if(event.target===this)closeDbResetModal()">
  <div class="modal">
    <button class="modal-x" onclick="closeDbResetModal()"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
    <h2 style="color: #dc2626;"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg> ¡Peligro! Reconstruir BD</h2>
    <div style="margin-top: 15px; background: #fee2e2; border-left: 4px solid #dc2626; padding: 15px; border-radius: 6px; color: #991b1b; font-size: 14px; line-height: 1.5;">
      <strong>Advertencia:</strong> Esta acción <b>vaciará por completo</b> la base de datos y la reconstruirá desde cero (incluyendo migraciones recientes).<br><br>
      • Se perderán TODOS los alumnos.<br>
      • Se perderán TODAS las evaluaciones.<br>
      • Las credenciales de acceso se restablecerán a las predeterminadas.<br><br>
      ¿Estás absolutamente seguro de que deseas continuar?
    </div>
    <div style="display: flex; gap: 10px; margin-top: 25px; justify-content: flex-end;">
      <button class="btn btn-outline-gray" onclick="closeDbResetModal()">Cancelar</button>
      <button class="btn" style="background-color: #dc2626; color: white;" id="confirmDbResetBtn" onclick="confirmDbReset()">Sí, reconstruir TODO</button>
    </div>
  </div>
</div>
