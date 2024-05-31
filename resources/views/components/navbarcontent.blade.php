
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item-dropdown">
        <a href="#" class="nav-link" data-toggle="dropdown" style="">
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
          <span class="mr-2 d-inline-block"><?= $userProfile['fullname'] ?></span>
          <img src="<?= $currentHost . '/' . $userProfile['picture'] ?>" alt="" width="40" class="rounded-circle" style="margin-top: -7px;">
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <div class="d-flex justify-content-center">
              <img src="<?= $currentHost . '/' . $userProfile['picture'] ?>" alt="" class="w-50 rounded-circle" />
            </div>
          </a>
          <div class="dropdown-divider mt-3"></div>
          <a href="/edit-profil" class="dropdown-item">
            <i class="fa fa-wrench mr-2"></i>
            <span>Edit Profil</span>
          </a>
          <a href="/logout" class="dropdown-item">
            <i class="fa fa-door-open mr-2"></i>
            <span>Logout</span>
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- LOADING -->
  @include('components/loading')
  <!-- END LOADING -->