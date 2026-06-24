/**
 * MINI-CEX Institutional Admin Panel JS
 */

/* ─── Loader ─── */
function showLoader(txt = 'Procesando...') {
    const l = document.getElementById('globalLoader');
    if (l) {
        l.querySelector('.loader-text').textContent = txt;
        l.classList.add('show');
    }
}
function hideLoader() {
    const l = document.getElementById('globalLoader');
    if (l) l.classList.remove('show');
}

/* ─── Date ─── */
const ld = document.getElementById('liveDate');
if (ld) ld.textContent = new Date().toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

/* ─── Toggle password ─── */
function togglePw() {
    const i = document.getElementById('pw');
    if (i) i.type = i.type === 'password' ? 'text' : 'password';
}

/* ─── Navigation ─── */
function go(t) {
    document.querySelectorAll('.tab').forEach(e => e.style.display = 'none');
    const el = document.getElementById('tab-' + t);
    if (el) el.style.display = 'block';
    document.querySelectorAll('.nav-btn:not(.nav-logout),.m-nav-btn').forEach(e => e.classList.remove('active'));
    ['sn-', 'mn-'].forEach(p => { const b = document.getElementById(p + t); if (b) b.classList.add('active') });
    closeSidebar();
}

function openSidebar() {
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('overlay').classList.add('show');
}

function closeSidebar() {
    document.getElementById('sidebar')?.classList.remove('open');
    document.getElementById('overlay')?.classList.remove('show');
}

/* ─── Table filter ─── */
function filterTbl(tid, sid, cols) {
    const q = document.getElementById(sid).value.toLowerCase();
    const rows = document.querySelectorAll('#' + tid + ' tbody tr');
    let any = false;
    rows.forEach(r => {
        if (r.classList.contains('empty-row')) { r.style.display = 'none'; return }
        const t = r.textContent.toLowerCase(); r.style.display = t.includes(q) ? '' : 'none'; if (t.includes(q)) any = true
    });
    let er = document.querySelector('#' + tid + ' tbody .empty-row');
    if (!any) {
        if (!er) {
            er = document.createElement('tr'); er.className = 'empty-row';
            er.innerHTML = '<td colspan="' + cols + '" style="text-align:center;padding:30px;color:var(--slate)">Sin resultados.</td>';
            document.querySelector('#' + tid + ' tbody').appendChild(er)
        }
        er.style.display = ''
    }
    else if (er) er.style.display = 'none';
}

/* ─── Modal ─── */
function openModal(d) {
    window.currentEvaluationId = d.id_evaluacion;
    document.getElementById('mdAlumno').textContent = (d.alumno_nombre || '—') + ' — MAT. ' + (d.alumno_matricula || 'N/A');
    document.getElementById('mdEval').textContent = d.evaluador_nombre || '—';
    document.getElementById('mdEntorno').textContent = (d.entorno_clinico || '') + ' | ' + (d.tipo_paciente || '');
    document.getElementById('mdComplejidad').textContent = 'Riesgo ' + (d.complejidad || '—') + ' — ' + (d.asunto_principal || '');
    document.getElementById('mdTiempos').textContent = 'Obs: ' + (d.tiempo_observacion || 0) + ' min | Feedback: ' + (d.tiempo_feedback || 0) + ' min';
    document.getElementById('mdScore').textContent = (parseFloat(d.calificacion_total) / 10).toFixed(1) + ' / 10';
    document.getElementById('modalBg').classList.add('show');
}

function closeModal() { document.getElementById('modalBg').classList.remove('show') }

function showDbResetModal() { document.getElementById('dbResetModal').classList.add('show') }
function closeDbResetModal() { document.getElementById('dbResetModal').classList.remove('show') }

async function confirmDbReset() {
    closeDbResetModal();
    showLoader('Reconstruyendo base de datos... Por favor espera.');
    try {
        const res = await fetch('admin/action', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'reset_db' })
        });
        const j = await res.json();
        toast(j.message, j.success);
        if (j.success) {
            setTimeout(() => window.location.reload(), 2000);
        }
    } catch (err) {
        toast('Error de conexión al reconstruir BD.', false);
    } finally {
        hideLoader();
    }
}

async function resendModalEmail() {
    const id = window.currentEvaluationId;
    if (!id) return;
    showLoader('Reenviando correo...');
    try {
        const res = await fetch('admin/action', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'resend_email', id_evaluacion: id })
        });
        const j = await res.json();
        toast(j.message, j.success);
    } catch (err) {
        toast('Error de conexión.', false);
    } finally {
        hideLoader();
    }
}


/* ─── Toast (SweetAlert2) — Dark Theme ─── */
const swalToast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    background: '#0a1128',
    color: '#e2e8f0',
    didOpen: (t) => {
        t.addEventListener('mouseenter', Swal.stopTimer)
        t.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

function toast(msg, ok) {
    swalToast.fire({
        icon: ok ? 'success' : 'error',
        title: msg
    });
}

/* ─── AJAX Helpers ─── */
async function refreshData() {
    try {
        const res = await fetch('admin');
        const html = await res.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        // Stats
        const stats = document.querySelector('.stats');
        const newStats = doc.querySelector('.stats');
        if (stats && newStats) stats.innerHTML = newStats.innerHTML;

        // Tables (tbody)
        ['#tab-dashboard .tbl', '#tab-docentes .tbl', '#alumnosTable', '#evTable'].forEach(sel => {
            const oldTbody = document.querySelector(sel + ' tbody');
            const newTbody = doc.querySelector(sel + ' tbody');
            if (oldTbody && newTbody) oldTbody.innerHTML = newTbody.innerHTML;
        });

        // Selects (docentes)
        const newDocentesSelect = doc.querySelector('select[name="id_docente"]');
        if (newDocentesSelect) {
            document.querySelectorAll('select[name="id_docente"], #exDocente').forEach(sel => {
                const currentVal = sel.value;
                sel.innerHTML = newDocentesSelect.innerHTML;
                sel.value = currentVal; // Maintain selection if possible
            });
        }
    } catch (err) { console.error('Refresh Error:', err) }
}

async function ajaxLogin(e) {
    e.preventDefault();
    const f = e.target;
    const fd = new FormData(f);
    const obj = Object.fromEntries(fd.entries());
    showLoader('Verificando credenciales...');
    try {
        const res = await fetch('admin/login', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(obj) });
        const j = await res.json();
        if (j.success) {
            toast(j.message, true);
            setTimeout(() => window.location.reload(), 1000);
        } else {
            toast(j.message, false);
            hideLoader();
        }
    } catch (err) {
        toast('Error de conexión.', false);
        hideLoader();
    }
}

async function ajaxSubmit(e) {
    e.preventDefault();
    const f = e.target;
    const fd = new FormData(f);
    const obj = Object.fromEntries(fd.entries());
    showLoader('Guardando datos...');
    try {
        const res = await fetch('admin/action', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(obj) });
        const j = await res.json();
        toast(j.message, j.success);
        if (j.success) { f.reset(); await refreshData(); }
    } catch (err) { toast('Error de conexión.', false); }
    finally { hideLoader(); }
}

async function ajaxDelete(f, msg) {
    const result = await Swal.fire({
        title: '¿Confirmar eliminación?',
        text: msg,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#f43f5e',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        background: '#0a1128',
        color: '#e2e8f0'
    });

    if (!result.isConfirmed) return;

    const fd = new FormData(f);
    const obj = Object.fromEntries(fd.entries());
    showLoader('Eliminando registro...');
    try {
        const res = await fetch('admin/action', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(obj) });
        const j = await res.json();
        toast(j.message, j.success);
        if (j.success) await refreshData();
    } catch (err) { toast('Error de conexión.', false); }
    finally { hideLoader(); }
}


/* ─── Excel: Drag & Drop + Preview ─── */
let exData = [];
const dz = document.getElementById('dropZone');
const ef = document.getElementById('exFile');

if (dz) {
    ['dragenter', 'dragover'].forEach(e => dz.addEventListener(e, ev => { ev.preventDefault(); dz.classList.add('dragover') }));
    ['dragleave', 'drop'].forEach(e => dz.addEventListener(e, ev => { ev.preventDefault(); dz.classList.remove('dragover') }));
    dz.addEventListener('drop', ev => { const f = ev.dataTransfer.files[0]; if (f) parseExcel(f) });
}
if (ef) ef.addEventListener('change', e => { const f = e.target.files[0]; if (f) parseExcel(f) });

function parseExcel(file) {
    const r = new FileReader();
    r.onload = function (ev) {
        try {
            const wb = XLSX.read(new Uint8Array(ev.target.result), { type: 'array' });
            const ws = wb.Sheets[wb.SheetNames[0]];
            const json = XLSX.utils.sheet_to_json(ws, { header: 1 });
            exData = [];
            const tb = document.querySelector('#prevTbl tbody'); tb.innerHTML = '';
            for (let i = 0; i < json.length; i++) {
                const row = json[i];
                if (i === 0 && row.length >= 2 && (String(row[0]).toLowerCase().includes('matr') || String(row[1]).toLowerCase().includes('nom'))) continue;
                if (row.length >= 3 && row[0] && row[1] && row[2]) {
                    const m = String(row[0]).trim(), n = String(row[1]).trim(), s = String(row[2]).trim();
                    const c = row[3] ? String(row[3]).trim() : '';
                    exData.push({ matricula: m, nombre: n, semestre: s, correo: c });
                    const tr = document.createElement('tr');
                    tr.innerHTML = '<td>' + m + '</td><td>' + n + '</td><td>' + s + '</td><td>' + c + '</td>';
                    tb.appendChild(tr);
                }
            }
            if (exData.length) {
                document.getElementById('prevCount').textContent = exData.length + ' registros';
                document.getElementById('previewBox').style.display = 'block';
            } else { toast('No se encontraron registros válidos (3 columnas).', false); cancelExcel() }
        } catch (e) { toast('Error leyendo archivo. Verifica formato.', false); cancelExcel() }
    };
    r.readAsArrayBuffer(file);
}

function cancelExcel() { if (ef) ef.value = ''; exData = []; document.getElementById('previewBox').style.display = 'none' }

async function submitExcel() {
    const did = document.getElementById('exDocente').value;
    if (!did) { toast('Selecciona un docente primero.', false); return }
    if (!exData.length) { toast('No hay datos para subir.', false); return }
    showLoader('Subiendo alumnos...');
    try {
        const res = await fetch('admin/action', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ action: 'add_alumnos_ajax', id_docente: did, data: exData }) });
        const j = await res.json();
        toast(j.message, j.success);
        if (j.success) {
            cancelExcel();
            await refreshData();
        }
    } catch (e) { toast('Error de conexión.', false); }
    finally { hideLoader(); }
}
