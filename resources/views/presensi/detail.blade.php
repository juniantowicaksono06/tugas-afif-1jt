
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
<!DOCTYPE html>
<html lang="en">
@include('components/header')
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  @include('components/navbarcontent')

  @include('components/sidebarcontent')  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="PresensiContent">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card mt-3">
            <div class="card-body">
              <h2>Detail Presensi</h2>
              <div>
                <table class="table table-bordered">
                  <tr>
                    <th>Nama</th>
                    <td><?= $userProfile['fullname'] ?></td>
                  </tr>
                  <tr>
                    <th>Jabatan</th>
                    <td><?= $userProfile['position'] ?></td>
                  </tr>
                  <tr>
                    <th>Clocked In</th>
                    <td><?= $data['clockedIn'] ?></td>
                  </tr>
                  <tr>
                    <th>Clocked Out</th>
                    <td><?= $data['clockedIn'] ?></td>
                  </tr>
                </table>
              </div>
              <div class="container-fluid" id="mapsContainer">
                <div class="row">
                  <div class="col-md-6 col-12">
                    <h3>Lokasi Masuk</h3>
                    <div id="mapMasuk" class="w-100" style="height: 400px;"></div>
                  </div>
                  <div class="col-md-6 col-12">
                    <h3>Lokasi Keluar</h3>
                    <div id="mapKeluar" class="w-100" style="height: 400px;"></div>
                  </div>
                </div>
              </div>
              <div class="container-fluid" id="photoContainer">
                  <div class="row">
                    <div class="col-md-6 col-12">
                      <h3>Foto Masuk</h3>
                      <img src="<?= $currentHost . '/'.$data['pictureIn'] ?>" alt="" class="w-100">
                    </div>
                    <div class="col-md-6 col-12">
                      <h3>Foto Pulang</h3>
                      <img src="<?= $currentHost . '/'.$data['pictureOut'] ?>" alt="" class="w-100">
                    </div>
                  </div>
              </div>
            </div>
          </div>
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
    $(window).on('load', function() {
      var mapMasuk = L.map('mapMasuk').setView([<?= $data['latitudeIn'] ?>, <?= $data['longitudeIn'] ?>], 13);
      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
      }).addTo(mapMasuk);
      var markerMasuk = L.marker([<?= $data['latitudeIn'] ?>, <?= $data['longitudeIn'] ?>]).addTo(mapMasuk);
      markerMasuk.bindPopup("Posisi Presensi Masuk").openPopup();
      
      var mapKeluar = L.map('mapKeluar').setView([<?= $data['latitudeOut'] ?>, <?= $data['longitudeOut'] ?>], 13);
      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
      }).addTo(mapKeluar);
      var markerKeluar = L.marker([<?= $data['latitudeOut'] ?>, <?= $data['longitudeOut'] ?>]).addTo(mapKeluar);
      markerKeluar.bindPopup("Posisi Presensi Pulang").openPopup();
    })
</script>
</body>
</html>
