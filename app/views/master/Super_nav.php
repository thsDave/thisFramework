
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?= URL ?>?req=home" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                <?= LANG['nav_home'] ?>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview <?= $objHome->menu_treeview_class('new_user', 'users', 'user_profile'); ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                <?= LANG['nav_users'] ?>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= URL ?>?req=new_user" class="nav-link <?= $objHome->menu_active_class('new_user'); ?>">
                  <i class="fas fa-chevron-right nav-icon"></i>
                  <p><?= LANG['nav_newuser'] ?></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= URL ?>?req=users" class="nav-link <?= $objHome->menu_active_class('users'); ?> <?= $objHome->menu_active_class('user_profile'); ?>">
                  <i class="fas fa-chevron-right nav-icon"></i>
                  <p><?= LANG['nav_users'] ?></p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= URL ?>?req=reports" class="nav-link <?= $objHome->menu_active_class('reports'); ?>">
              <i class="nav-icon fa-solid fa-file-lines"></i>
              <p>
                <?= LANG['nav_reports'] ?>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview <?= $objHome->menu_treeview_class('tbl_cookies', 'tbl_countries', 'tbl_languages', 'tbl_levels', 'tbl_logscron', 'tbl_records', 'tbl_profilepics', 'tbl_status'); ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fa-solid fa-database"></i>
              <p>
                <?= LANG['nav_database'] ?>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= URL ?>?req=tbl_countries" class="nav-link <?= $objHome->menu_active_class('tbl_countries'); ?>">
                  <i class="fas fa-chevron-right nav-icon"></i>
                  <p>
                    <?= LANG['nav_countries'] ?>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= URL ?>?req=tbl_languages" class="nav-link <?= $objHome->menu_active_class('tbl_languages'); ?>">
                  <i class="fas fa-chevron-right nav-icon"></i>
                  <p>
                    <?= LANG['nav_languages'] ?>
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= URL ?>?req=profile" class="nav-link <?= $objHome->menu_active_class('profile'); ?>">
              <i class="nav-icon fa-solid fa-user"></i>
              <p>
                <?= LANG['nav_myuser'] ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= URL ?>?req=support_request" class="nav-link <?= $objHome->menu_active_class('support_request'); ?>">
              <i class="nav-icon fa-solid fa-headset"></i>
              <p>
                <?= LANG['nav_support'] ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= URL ?>?req=info" class="nav-link <?= $objHome->menu_active_class('info'); ?>">
              <i class="nav-icon fa-solid fa-info"></i>
              <p>
                <?= LANG['nav_info'] ?>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="<?= URL ?>?event=logout" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                <?= LANG['logout'] ?>
              </p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
