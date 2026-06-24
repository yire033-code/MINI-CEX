<!-- ═══════ TAB: DASHBOARD ═══════ -->
<section id="tab-dashboard" class="tab">

  <div class="page-head">
    <div>
      <h1>Gestión Clínica y Académica</h1>
      <p>Plataforma institucional de evaluaciones MINI-CEX</p>
    </div>
    <div class="date-chip">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      <span id="liveDate"></span>
    </div>
    <button class="btn btn-sm btn-outline-red" style="margin-left: 10px;" onclick="showDbResetModal()">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
      Reconstruir BD
    </button>
  </div>

  <div class="stats">
    <div class="stat">
      <div class="stat-info"><span class="stat-label">Docentes</span><span class="stat-num"><?= $statDocentes ?></span></div>
      <div class="stat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
    </div>
    <div class="stat gold">
      <div class="stat-info"><span class="stat-label">Alumnos</span><span class="stat-num"><?= $statAlumnos ?></span></div>
      <div class="stat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 4 3 6 3s6-1 6-3v-5"/></svg></div>
    </div>
    <div class="stat">
      <div class="stat-info"><span class="stat-label">Evaluaciones</span><span class="stat-num"><?= $statEvaluaciones ?></span></div>
      <div class="stat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg></div>
    </div>
    <div class="stat gold">
      <div class="stat-info"><span class="stat-label">Promedio</span><span class="stat-num"><?= $statPromedio ?><small style="font-size:14px;color:var(--slate);font-weight:600">/10</small></span></div>
      <div class="stat-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg></div>
    </div>
  </div>

  <div class="card">
    <div class="card-head">
      <span class="card-title"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Últimas Evaluaciones</span>
    </div>
    <div class="tbl-wrap">
      <table class="tbl">
        <thead><tr><th>Matrícula</th><th>Alumno</th><th>Evaluador</th><th>Fecha</th><th>Puntaje</th><th>Acción</th></tr></thead>
        <tbody>
          <?php if (empty($evaluaciones)): ?>
            <tr class="empty-row"><td colspan="6">No hay evaluaciones registradas aún.</td></tr>
          <?php else: $c=0; foreach ($evaluaciones as $ev): if(++$c>5) break; ?>
            <tr>
              <td data-label="Matrícula"><strong><?= htmlspecialchars($ev['alumno_matricula']??'N/A') ?></strong></td>
              <td data-label="Alumno"><?= htmlspecialchars($ev['alumno_nombre']??'—') ?></td>
              <td data-label="Evaluador"><?= htmlspecialchars($ev['evaluador_nombre']??'—') ?></td>
              <td data-label="Fecha"><?= date('d/m/Y',strtotime($ev['fecha_evaluacion'])) ?></td>
              <td data-label="Puntaje"><span class="badge badge-score"><?= number_format($ev['calificacion_total']/10,1) ?>/10</span></td>
              <td data-label=""><button class="btn btn-sm btn-outline-blue" onclick='openModal(<?= json_encode($ev) ?>)'>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> Ver</button></td>
            </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
