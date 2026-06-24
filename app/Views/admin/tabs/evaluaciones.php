<!-- ═══════ TAB: EVALUACIONES ═══════ -->
<section id="tab-evaluaciones" class="tab" style="display:none">
  <div class="page-head"><div><h1>Expediente de Evaluaciones</h1><p>Historial de rúbricas clínicas sincronizadas</p></div></div>

  <div class="card">
    <div class="card-head">
      <span class="card-title"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><path d="M9 14l2 2 4-4"/></svg> Historial Clínico</span>
      <div class="search-wrap">
        <input type="text" id="searchEv" oninput="filterTbl('evTable','searchEv',7)" placeholder="Buscar...">
        <svg class="si" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      </div>
    </div>
    <div class="tbl-wrap">
      <table class="tbl" id="evTable">
        <thead><tr><th>Fecha</th><th>UUID</th><th>Matrícula</th><th>Alumno</th><th>Evaluador</th><th>Puntaje</th><th>Acción</th></tr></thead>
        <tbody>
          <?php if(empty($evaluaciones)):?><tr class="empty-row"><td colspan="7">Sin evaluaciones aún.</td></tr>
          <?php else: foreach($evaluaciones as $ev): ?>
            <tr>
              <td data-label="Fecha"><?= date('d/m/Y',strtotime($ev['fecha_evaluacion'])) ?></td>
              <td data-label="UUID"><code style="font-size:11px;color:var(--slate);background:var(--snow);padding:2px 6px;border-radius:4px;border:1px solid var(--ice)"><?= htmlspecialchars(substr($ev['uuid'],0,13)) ?>…</code></td>
              <td data-label="Matrícula"><strong><?= htmlspecialchars($ev['alumno_matricula']??'N/A') ?></strong></td>
              <td data-label="Alumno"><?= htmlspecialchars($ev['alumno_nombre']??'—') ?></td>
              <td data-label="Evaluador"><?= htmlspecialchars($ev['evaluador_nombre']??'—') ?></td>
              <td data-label="Puntaje"><span class="badge badge-score"><?= number_format($ev['calificacion_total']/10,1) ?>/10</span></td>
              <td data-label=""><button class="btn btn-sm btn-outline-blue" onclick='openModal(<?= json_encode($ev) ?>)'><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> Ver</button></td>
            </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
