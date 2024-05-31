<!DOCTYPE html>
<html lang="en">
@include('components/header')
<body class="hold-transition sidebar-mini layout-fixed h-100">
<div class="wrapper h-100">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  @include('components/navbarcontent')

  @include('components/sidebarcontent')  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper h-100" id="Home">
    <div class="d-flex justify-content-center pt-5">
      <div class="card">
        <div class="card-body">
          @if(empty($attendance))
            <h3 class="text-center">Anda belum melakukan presensi</h3>
            <a class="nav-link text-center" href="/presensi/check-in">Silahkan klik disini untuk melakukan presensi masuk</a>
          @else
            @if($attendance['clockedIn'] && empty($attendance['clockedOut']))
              <h3>Anda telah melakukan presensi masuk pada <?= $attendance['clockedIn'] ?></h3>
              <a class="nav-link text-center" href="/presensi/check-in">Silahkan klik disini untuk melakukan presensi pulang</a>
            @else
              <h3>Anda telah melakukan presensi pulang pada <?= $attendance['clockedIn'] ?></h3>
            @endif
          @endif
        </div>
      </div>
    </div>
  </div>
  
  @include('components/footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
</script>
</body>
</html>
