
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
          <li class="nav-item">
            <a href="<?= URL ?>?req=profile" class="nav-link <?= $objHome->menu_active_class('profile'); ?>">
              <i class="nav-icon fa-solid fa-user"></i>
              <p><?= LANG['nav_myuser'] ?></p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= URL ?>?req=support" class="nav-link <?= $objHome->menu_active_class('support'); ?>">
              <i class="nav-icon fa-solid fa-circle-question"></i>
              <p>
                <?= LANG['nav_support'] ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= URL ?>?req=info" class="nav-link">
              <i class="nav-icon fa-solid fa-circle-info"></i>
              <p><?= LANG['header2'] ?></p>
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
