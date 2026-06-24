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

