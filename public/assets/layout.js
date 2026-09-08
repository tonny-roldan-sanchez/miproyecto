/* Inyecta el sidebar y topbar en cualquier página del sistema */
function renderLayout(activeModule) {
  const nav = [
    { label: null, group: 'Principal' },
    { id: 'dashboard',      icon: '<rect x="1" y="1" width="6" height="6" rx="1"/><rect x="9" y="1" width="6" height="6" rx="1"/><rect x="1" y="9" width="6" height="6" rx="1"/><rect x="9" y="9" width="6" height="6" rx="1"/>', name: 'Dashboard',           href: '../index.html' },
    { label: null, group: 'Gestión' },
    { id: 'campanas',       icon: '<path d="M8 1L14 5V13H2V5Z"/><rect x="6" y="9" width="4" height="4"/>',                   name: 'Campañas',             href: 'campanas.html' },
    { id: 'donadores',      icon: '<path d="M8 2C9.1 2 10 2.9 10 4S9.1 6 8 6 6 5.1 6 4 6.9 2 8 2ZM14 13C14 10.2 11.3 9 8 9S2 10.2 2 13"/>',  name: 'Donadores',            href: 'donadores.html' },
    { id: 'donaciones',     icon: '<path d="M8 1V15M1 8H15" stroke-linecap="round"/>',                                       name: 'Donaciones',           href: 'donaciones.html' },
    { id: 'beneficiarios',  icon: '<circle cx="6" cy="5" r="3"/><path d="M1 14C1 11.2 3.2 10 6 10"/><circle cx="12" cy="8" r="2.5"/><path d="M9 14C9 12.1 10.3 11 12 11S15 12.1 15 14"/>',  name: 'Beneficiarios',        href: 'beneficiarios.html' },
    { id: 'entregas',       icon: '<path d="M1 4L8 1L15 4V12L8 15L1 12V4Z"/><path d="M8 1V15M1 4L8 7L15 4"/>',              name: 'Entregas',             href: 'entregas.html' },
    { label: null, group: 'Control' },
    { id: 'inventario',     icon: '<rect x="1" y="4" width="14" height="9" rx="1"/><path d="M5 4V3A2 2 0 0 1 9 3V4M6 9H10"/>', name: 'Inventario',           href: 'inventario.html' },
    { id: 'voluntarios',    icon: '<path d="M8 7L5 4M8 7L11 4M8 7V13"/><circle cx="8" cy="3" r="2"/><path d="M2 13H14"/>',  name: 'Voluntarios',          href: 'voluntarios.html' },
    { label: null, group: 'Extras' },
    { id: 'gamificacion',   icon: '<path d="M8 1L10 6H15L11 9.5L12.5 15L8 12L3.5 15L5 9.5L1 6H6Z"/>',                       name: 'Gamificación',         href: 'gamificacion.html' },
    { id: 'seguimiento',    icon: '<circle cx="8" cy="8" r="6"/><circle cx="8" cy="8" r="2"/><path d="M8 2V4M8 12V14M2 8H4M12 8H14"/>', name: 'Seguimiento GPS',      href: 'seguimiento.html' },
    { id: 'quejas',         icon: '<path d="M2 2H14V11H9L8 14L7 11H2Z"/>',                                                   name: 'Quejas / Sugerencias', href: 'quejas.html' },
    { id: 'notificaciones', icon: '<path d="M8 1C5 1 3 3.5 3 6V10L1 12H15L13 10V6C13 3.5 11 1 8 1Z"/><path d="M6 12C6 13.1 6.9 14 8 14S10 13.1 10 12"/>', name: 'Notificaciones',       href: 'notificaciones.html' },
    { id: 'historial',      icon: '<circle cx="8" cy="8" r="6"/><path d="M8 5V8L10 10"/>',                                   name: 'Historial accesos',    href: 'historial.html' },
    { id: 'reportes',       icon: '<path d="M2 4H14M2 8H10M2 12H7" stroke-linecap="round"/>',                                name: 'Reportes',             href: 'reportes.html' },
    { id: 'usuarios',       icon: '<circle cx="8" cy="5" r="3"/><path d="M2 15C2 12.2 4.7 11 8 11S14 12.2 14 15"/>',        name: 'Usuarios',             href: 'usuarios.html' },
  ];

  /* Construye items del sidebar */
  let navHtml = '';
  nav.forEach(item => {
    if (item.group) {
      navHtml += `<div class="nav-label">${item.group}</div>`;
    } else {
      const active = item.id === activeModule ? 'active' : '';
      navHtml += `
        <a class="nav-item ${active}" href="${item.href}">
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">${item.icon}</svg>
          ${item.name}
        </a>`;
    }
  });

  /* Inserta sidebar en el DOM */
  document.getElementById('sidebar-placeholder').innerHTML = `
    <nav class="sidebar">
      <div class="sidebar-logo"><span>Iskalli</span><small>Sistema Integral</small></div>
      <div class="nav-section">${navHtml}</div>
      <div class="sidebar-bottom">
        <div class="user-chip">
          <div class="user-avatar">ES</div>
          <div class="user-info"><span>Eva Sánchez</span><small>Administrador</small></div>
        </div>
        <a href="../modulos/login.html" class="btn btn-secondary btn-sm" style="width:100%;margin-top:.6rem;font-size:10.5px;text-decoration:none;justify-content:center;">Cerrar sesión</a>
      </div>
    </nav>`;
}
