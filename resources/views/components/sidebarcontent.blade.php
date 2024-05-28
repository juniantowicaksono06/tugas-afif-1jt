<!-- Main Sidebar Container -->

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <!-- <img src="img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <p class="brand-text font-weight-light text-center mb-0 ml-0 px-0">Pemungutan Suara</p>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image mr-2">
          <!-- <img src="img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
          <div class="d-flex justify-content-center align-items-center h-100">
              <span><i class="fa fa-user text-white"></i></span>
          </div>
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $current_user['username'] ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/ppwp" class="nav-link <?= strpos("/".request()->path(), '/ppwp') === 0 ? 'active' : '' ?>">
              <p>
                PPWP
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/dpd" class="nav-link <?= strpos("/".request()->path(), '/dpd') === 0 ? 'active' : '' ?>">
              <p>
                DPD 
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/parpol/dpr" class="nav-link <?= strpos("/".request()->path(), '/parpol/dpr') === 0 && "/".request()->path() != "/parpol/dprd-prov" ? 'active' : '' ?>">
              <p>
                DPR RI
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/parpol/dprd-prov" class="nav-link <?= strpos("/".request()->path(), '/parpol/dprd-prov') === 0 ? 'active' : '' ?>">
              <p>
                DPRD Provinsi
              </p>
            </a>
          </li>
          
          <li class="nav-item <?= strpos("/".request()->path(), '/parpol/dapil') === 0 ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= strpos("/".request()->path(), '/parpol/dapil') === 0 ? 'active' : '' ?>">
              <p>
                DPRD Kota
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/parpol/dapil-1" class="nav-link <?= strpos("/".request()->path(), '/parpol/dapil-1') === 0 ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DPRD KOTA KAB 1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/parpol/dapil-2" class="nav-link <?= strpos("/".request()->path(), '/parpol/dapil-2') === 0 ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DPRD KOTA KAB 2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/parpol/dapil-3" class="nav-link <?= strpos("/".request()->path(), '/parpol/dapil-3') === 0 ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DPRD KOTA KAB 3</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/parpol/dapil-4" class="nav-link <?= strpos("/".request()->path(), '/parpol/dapil-4') === 0 ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DPRD KOTA KAB 4</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/parpol/dapil-5" class="nav-link <?= strpos("/".request()->path(), '/parpol/dapil-5') === 0 ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DPRD KOTA KAB 5</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item <?= strpos("/".request()->path(), '/rekap-suara') === 0 ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= strpos("/".request()->path(), '/rekap-suara') === 0 ? 'active' : '' ?>">
              <p>
                Rekap Suara
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="/rekap-suara/ppwp" class="nav-link <?= strpos("/".request()->path(), '/rekap-suara/ppwp') === 0 ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PPWP</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/rekap-suara/dpd" class="nav-link <?= strpos("/".request()->path(), '/rekap-suara/dpd') === 0 ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DPD</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/rekap-suara/dpr" class="nav-link <?= strpos("/".request()->path(), '/rekap-suara/dpr') === 0  && "/".request()->path() != "/rekap-suara/dprd-prov" ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DPR RI</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/rekap-suara/dprd-prov" class="nav-link <?= strpos("/".request()->path(), '/rekap-suara/dprd-prov') === 0 ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DPRD Provinsi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/rekap-suara/dapil-1" class="nav-link <?= strpos("/".request()->path(), '/rekap-suara/dapil-1') === 0 ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DPRD KOTA KAB 1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/rekap-suara/dapil-2" class="nav-link <?= strpos("/".request()->path(), '/rekap-suara/dapil-2') === 0 ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DPRD KOTA KAB 2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/rekap-suara/dapil-3" class="nav-link <?= strpos("/".request()->path(), '/rekap-suara/dapil-3') === 0 ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DPRD KOTA KAB 3</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/rekap-suara/dapil-4" class="nav-link <?= strpos("/".request()->path(), '/rekap-suara/dapil-4') === 0 ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DPRD KOTA KAB 4</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/rekap-suara/dapil-5" class="nav-link <?= strpos("/".request()->path(), '/rekap-suara/dapil-5') === 0 ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DPRD KOTA KAB 5</p>
                </a>
              </li>
            </ul>
          </li>

          @if($current_user['user_type'] == 'superadmin')
          <li class="nav-item">
            <a href="/kecamatan" class="nav-link <?= strpos("/".request()->path(), '/kecamatan') === 0 ? 'active' : '' ?>">
              <p>
                Kecamatan
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/kelurahan" class="nav-link <?= strpos("/".request()->path(), '/kelurahan') === 0 ? 'active' : '' ?>">
              <p>
                Kelurahan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/users" class="nav-link <?= strpos("/".request()->path(), '/users') === 0 ? 'active' : '' ?>">
              <p>
                User Management
              </p>
            </a>
          </li>
          @endif

          <li class="nav-item">
            <a href="/edit-user/<?= $current_user['user_id'] ?>" class="nav-link <?= strpos("/".request()->path(), '/edit-user') === 0 ? 'active' : '' ?>">
              <p>
                Edit User
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="/logout" class="nav-link">
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>