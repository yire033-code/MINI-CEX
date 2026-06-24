<!-- ═══════ TAB: DOCENTES ═══════ -->
<section id="tab-docentes" class="tab" style="display:none">
  <div class="page-head"><div><h1>Personal Docente</h1><p>Terapeutas y profesores del sistema</p></div></div>

  <div class="grid-2">
    <div class="card">
      <div class="card-head">
        <span class="card-title"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg> Directorio</span>
        <div class="search-wrap">
          <svg class="si" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" id="searchDocentes" placeholder="Buscar docente..." onkeyup="filterTbl('docentesTbl', 'searchDocentes', 5)">
        </div>
      </div>
      <div class="tbl-wrap">
        <table class="tbl" id="docentesTbl">
          <thead><tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Rol</th><th>Acción</th></tr></thead>
          <tbody>
            <?php if(empty($docentes)):?><tr class="empty-row"><td colspan="5">Sin docentes registrados.</td></tr>
            <?php else: foreach($docentes as $d): ?>
              <tr>
                <td data-label="ID">#<?= $d['id_usuario'] ?></td>
                <td data-label="Nombre"><strong><?= htmlspecialchars($d['nombre_completo']) ?></strong></td>
                <td data-label="Correo"><?= htmlspecialchars($d['email']) ?></td>
                <td data-label="Rol"><span class="badge <?= strtolower($d['rol'])==='administrador'?'badge-gold':'badge-blue' ?>"><?= htmlspecialchars($d['rol']) ?></span></td>
                <td data-label="">
                  <form onsubmit="event.preventDefault(); ajaxDelete(this, '¿Eliminar este docente?')" style="display:inline">
                    <input type="hidden" name="action" value="delete_docente">
                    <input type="hidden" name="id_docente" value="<?= $d['id_usuario'] ?>">
                    <button type="submit" class="btn btn-sm btn-outline-red"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg> Eliminar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="card">
      <div class="card-head"><span class="card-title"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg> Nuevo Docente</span></div>
      <form onsubmit="ajaxSubmit(event)">
        <input type="hidden" name="action" value="add_docente">
        <div class="form-grid">
          <div class="fg"><label>Nombre Completo</label><div class="fw"><input class="fc" name="nombre_completo" placeholder="Ej: Lic. María González" required><svg class="ico" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div></div>
          <div class="fg"><label>Correo</label><div class="fw"><input class="fc" type="email" name="email" placeholder="correo@institucion.edu" required><svg class="ico" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div></div>
          <div class="fg"><label>Contraseña</label><div class="fw"><input class="fc" name="password" placeholder="Establecer contraseña" required><svg class="ico" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg></div></div>
          <div class="fg"><label>Rol</label><div class="fw"><select class="fc" name="rol"><option value="Docente">Docente (Terapeuta)</option><option value="Administrador">Administrador</option></select><svg class="ico" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div></div>
        </div>
        <button type="submit" class="btn btn-blue">Registrar <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg></button>
      </form>
    </div>
  </div>
</section>
