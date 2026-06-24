<!-- ═══════ TAB: ALUMNOS ═══════ -->
<section id="tab-alumnos" class="tab" style="display:none">
  <div class="page-head"><div><h1>Control de Alumnos</h1><p>Registro y asignación de alumnos a docentes</p></div></div>

  <div class="grid-1">
    <div class="card">
      <div class="card-head">
        <span class="card-title"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 4 3 6 3s6-1 6-3v-5"/></svg> Alumnos Inscritos</span>
        <div class="search-wrap">
          <input type="text" id="searchAl" oninput="filterTbl('alumnosTable','searchAl',6)" placeholder="Buscar...">
          <svg class="si" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
      </div>
      <div class="tbl-wrap">
        <table class="tbl" id="alumnosTable">
          <thead><tr><th>Matrícula</th><th>Nombre</th><th>Semestre</th><th>Correo</th><th>Docente</th><th>Acción</th></tr></thead>
          <tbody>
            <?php if(empty($alumnos)):?><tr class="empty-row"><td colspan="6">Sin alumnos registrados.</td></tr>
            <?php else: foreach($alumnos as $a): ?>
              <tr>
                <td data-label="Matrícula"><strong><?= htmlspecialchars($a['matricula']) ?></strong></td>
                <td data-label="Nombre"><?= htmlspecialchars($a['nombre_completo']) ?></td>
                <td data-label="Semestre"><?= htmlspecialchars($a['semestre_grupo']) ?></td>
                <td data-label="Correo"><?= htmlspecialchars($a['correo'] ?? '') ?></td>
                <td data-label="Docente"><span style="color:var(--blue);font-weight:600"><?= htmlspecialchars($a['docente_nombre']??'Sin docente') ?></span></td>
                <td data-label="">
                  <form onsubmit="event.preventDefault(); ajaxDelete(this, '¿Eliminar alumno?')" style="display:inline">
                    <input type="hidden" name="action" value="delete_alumno">
                    <input type="hidden" name="id_alumno" value="<?= $a['id_alumno'] ?>">
                    <button type="submit" class="btn btn-sm btn-outline-red"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg> Eliminar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div>
      <!-- Individual -->
      <div class="card">
        <div class="card-head"><span class="card-title" style="font-size:16px"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg> Agregar Alumno</span></div>
        <form onsubmit="ajaxSubmit(event)">
          <input type="hidden" name="action" value="add_alumno">
          <div class="form-grid">
            <div class="fg"><label>Matrícula</label><div class="fw"><input class="fc" name="matricula" placeholder="Ej: 2026104" required></div></div>
            <div class="fg"><label>Nombre Completo</label><div class="fw"><input class="fc" name="nombre_completo" placeholder="Nombre del alumno" required></div></div>
            <div class="fg"><label>Semestre/Grupo</label><div class="fw"><input class="fc" name="semestre_grupo" placeholder="Ej: 6to A" required></div></div>
            <div class="fg"><label>Correo Electrónico</label><div class="fw"><input class="fc" type="email" name="correo" placeholder="ejemplo@correo.com"></div></div>
            <div class="fg"><label>Docente</label><div class="fw">
              <select class="fc" name="id_docente" required>
                <option value="" disabled selected>Seleccione...</option>
                <?php foreach($docentes as $d): ?><option value="<?=$d['id_usuario']?>"><?=htmlspecialchars($d['nombre_completo'])?></option><?php endforeach; ?>
              </select>
            </div></div>
          </div>
          <button type="submit" class="btn btn-gold">Registrar</button>
        </form>
      </div>

      <!-- Excel Import -->
      <div class="card">
        <div class="card-head"><span class="card-title" style="font-size:16px"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg> Importar Excel</span></div>
        <div class="fg"><label>Docente</label><div class="fw">
          <select class="fc" id="exDocente" required>
            <option value="" disabled selected>Seleccione...</option>
            <?php foreach($docentes as $d):?><option value="<?=$d['id_usuario']?>"><?=htmlspecialchars($d['nombre_completo'])?></option><?php endforeach;?>
          </select>
          <svg class="ico" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div></div>

        <div class="drop-zone" id="dropZone">
          <input type="file" id="exFile" accept=".xlsx,.xls">
          <svg class="dz-icon" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
          <p class="dz-text">Arrastra tu archivo Excel aquí</p>
          <p class="dz-hint">o haz clic para seleccionar • .xlsx / .xls</p>
        </div>
        <p style="font-size:11px;color:var(--slate);margin-top:8px"><strong>Columnas:</strong> Matrícula | Nombre | Semestre | Correo</p>

        <div class="preview-box" id="previewBox">
          <div class="preview-head">
            <h4><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> Vista Previa</h4>
            <span class="preview-count" id="prevCount">0</span>
          </div>
          <div class="preview-scroll"><table id="prevTbl"><thead><tr><th>Matrícula</th><th>Nombre</th><th>Semestre</th><th>Correo</th></tr></thead><tbody></tbody></table></div>
          <div class="preview-actions">
            <button class="btn btn-blue" id="btnUpload" onclick="submitExcel()"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg> Confirmar y Subir</button>
            <button class="btn btn-sm btn-outline-red" onclick="cancelExcel()" style="flex:0">Descartar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
