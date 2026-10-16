<?php
function SideBarView(){
    return "
     <nav class='sidebar sidebar-offcanvas' id='sidebar'>
          <ul class='nav'>
            <li class='nav-item nav-category'>Menú</li>

            <li class='nav-item'>
              <a class='nav-link' href='?menu=panel'>
                <span class='icon-bg'>
                  <i class='fas fa-th-large menu-icon'></i>
                </span>
                <span class='menu-title'>Dashboard</span>
              </a>
            </li>
            
            <li class='nav-item'>
              <a class='nav-link' href='?menu=micamion'>
                <span class='icon-bg'>
                  <i class='fas fa-truck menu-icon'></i>
                </span>
                <span class='menu-title'>Mi camión</span>
              </a>
            </li>

            <li class='nav-item'>
              <a class='nav-link' href='?menu=miespacio'>
                <span class='icon-bg'>
                  <i class='fas fa-parking menu-icon'></i>
                </span>
                <span class='menu-title'>Mi espacio</span>
              </a>
            </li>

            <li class='nav-item'>
              <a class='nav-link' href='?menu=pagos'>
                <span class='icon-bg'>
                  <i class='fas fa-money-bill-wave menu-icon'></i>
                </span>
                <span class='menu-title'>Pagos</span>
              </a>
            </li>

            <li class='nav-item'>
              <a class='nav-link' href='?menu=historial'>
                <span class='icon-bg'>
                  <i class='fas fa-history menu-icon'></i>
                </span>
                <span class='menu-title'>Historial</span>
              </a>
            </li>

            <li class='nav-item'>
              <a class='nav-link' href='?menu=accesos'>
                <span class='icon-bg'>
                  <i class='fas fa-door-open menu-icon'></i>
                </span>
                <span class='menu-title'>Accesos</span>
              </a>
            </li>

            <li class='nav-item sidebar-user-actions'>
              <div class='sidebar-user-menu'>
                <a href='#' class='nav-link'><i class='fas fa-cog menu-icon'></i>
                  <span class='menu-title'>Configuraciones</span>
                </a>
              </div>
            </li>
            
            
          </ul>
        </nav>
    ";
}
?>