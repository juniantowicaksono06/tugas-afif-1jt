<!-- Main Sidebar Container -->
<?php 
  $currentParentActiveID = "";
  foreach($menus as $menu) {
    if(request()->path() === $menu->link) {
      $currentParentActiveID = $menu->menuID;
      break;
    }
    if($menu->hasChild && $menu->isParent) {
      foreach($subMenus[$menu->menuID] as $subMenu) {
        if($subMenu['link'] === '/'.request()->path()) {
          $currentParentActiveID = $subMenu['parentID'];
        }
      }
    }
  }
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <!-- <img src="img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <p class="brand-text font-weight-light text-center mb-0 ml-0 px-0">Sistem Presensi</p>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php 
            $request = request();
            $scheme = $request->getScheme();
            $host = $request->getHost();
            $port = $request->getPort();
            $currentHost = "";
            if (($scheme == 'http' && $port == 80) || ($scheme == 'https' && $port == 443)) {
              $currentHost = "{$scheme}://{$host}";
            }
            else {
              $currentHost = "{$scheme}://{$host}:{$port}";
            }
          ?>
          <img src="<?= $currentHost . '/' . $userProfile['picture'] ?>" alt="profile-picture" class="img-circle elevation-2">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $userProfile['fullname'] ?></a>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @foreach($menus as $menu)
            <li class="nav-item <?= $currentParentActiveID == $menu->menuID && $menu->hasChild && $menu->isParent ? 'menu-open' : '' ?>">
              <a href="<?= $menu->link ?>" class="nav-link <?= $currentParentActiveID === $menu->menuID ? 'active' : '' ?>">
                <i class="nav-icon <?= $menu->icon ?>"></i>
                <p><?= $menu->name ?>
                  @if($menu->hasChild == 1 && $menu->isParent == 1)
                  <i class="right fas fa-angle-left"></i>
                  @endif
                </p>
              </a>
              @if($menu->hasChild == 1 && $menu->isParent == 1)
                <ul class="nav nav-treeview">
                  @foreach($subMenus[$menu->menuID] as $subMenu)
                    <li class="nav-item">
                      <a href="<?= $subMenu['link'] ?>" class="nav-link <?= strpos("/".request()->path(), $subMenu['link']) === 0 ? 'active' : '' ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p><?= $subMenu['name'] ?></p>
                      </a>
                    </li>
                  @endforeach
                </ul>
              @endif
            </li>
          @endforeach
        </ul>
      </nav>
    </div>
    <!-- /.sidebar -->
  </aside>