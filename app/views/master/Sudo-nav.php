
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="<?= URL ?>?req=home" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Inicio
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview <?= $objHome->menu_treeview_class('newuser', 'users'); ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Usuarios
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= URL ?>?req=newuser" class="nav-link <?= $objHome->menu_active_class('newuser'); ?>">
                  <i class="fas fa-chevron-right nav-icon"></i>
                  <p>Nuevo usuario</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= URL ?>?req=users" class="nav-link <?= $objHome->menu_active_class('users'); ?>">
                  <i class="fas fa-chevron-right nav-icon"></i>
                  <p>Lista de usuarios</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?= $objHome->menu_treeview_class('profile', 'support', 'info'); ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fab fa-buffer"></i>
              <p>
                Otros
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= URL ?>?req=profile" class="nav-link <?= $objHome->menu_active_class('profile'); ?>">
                  <i class="fas fa-chevron-right nav-icon"></i>
                  <p>Mi Usuario</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= URL ?>?req=supportrequest" class="nav-link <?= $objHome->menu_active_class('support'); ?>">
                  <i class="fas fa-chevron-right nav-icon"></i>
                  <p>Soporte</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= URL ?>?req=info" class="nav-link <?= $objHome->menu_active_class('info'); ?>">
                  <i class="fas fa-chevron-right nav-icon"></i>
                  <p>Info</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="<?= URL ?>?event=logout" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Cerrar sesión
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
