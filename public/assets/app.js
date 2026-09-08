/* ── Navegación entre módulos ── */
function showPage(id, el) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  const pg = document.getElementById('page-' + id);
  if (pg) pg.classList.add('active');
  if (el) el.classList.add('active');
  const titles = {
    dashboard: 'Dashboard', campanas: 'Campañas', donadores: 'Donadores',
    donaciones: 'Donaciones', beneficiarios: 'Beneficiarios', entregas: 'Entregas',
    inventario: 'Inventario', voluntarios: 'Voluntarios', gamificacion: 'Gamificación',
    seguimiento: 'Seguimiento GPS', quejas: 'Quejas y Sugerencias',
    notificaciones: 'Notificaciones', historial: 'Historial de Accesos',
    reportes: 'Reportes', usuarios: 'Usuarios'
  };
  const titleEl = document.getElementById('page-title');
  if (titleEl) titleEl.textContent = titles[id] || id;
}

/* ── Modales ── */
function openModal(id) {
  const m = document.getElementById(id);
  if (m) m.classList.add('open');
}
function closeModal(id) {
  const m = document.getElementById(id);
  if (m) m.classList.remove('open');
}

/* Cierra modal al hacer clic fuera */
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.modal-overlay').forEach(o => {
    o.addEventListener('click', e => { if (e.target === o) o.classList.remove('open'); });
  });
});

/* ── Toast de confirmación ── */
const toastMsgs = {
  'donación':                 'Donación registrada. Inventario actualizado.',
  'beneficiario':             'Beneficiario registrado correctamente.',
  'entrega':                  'Entrega registrada correctamente.',
  'campaña':                  'Campaña creada correctamente.',
  'avance de campaña':        'Avance de campaña registrado.',
  'movimiento de inventario': 'Movimiento de inventario guardado.',
  'donador':                  'Donador registrado correctamente.',
  'voluntario':               'Voluntario registrado correctamente.',
  'asignación':               'Asignación guardada correctamente.',
  'nivel':                    'Nivel de gamificación guardado.',
  'insignia':                 'Insignia guardada correctamente.',
  'asignación de insignia':   'Insignia asignada al donador.',
  'reconocimiento':           'Reconocimiento emitido correctamente.',
  'usuario':                  'Usuario creado correctamente.',
  'queja':                    'Registro guardado correctamente.',
};

function showToast(type) {
  const t = document.getElementById('toast');
  const msg = document.getElementById('toast-msg');
  if (!t || !msg) return;
  msg.textContent = toastMsgs[type] || 'Guardado correctamente.';
  t.style.display = 'flex';
  setTimeout(() => { t.style.display = 'none'; }, 3000);
}

/* Guarda el modal y muestra toast */
function saveAndClose(modalId, type) {
  closeModal(modalId);
  showToast(type);
}

/* ── Tabs dentro de una card ── */
function activateTab(el, group) {
  document.querySelectorAll('[data-tab-group="' + group + '"]').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
}
