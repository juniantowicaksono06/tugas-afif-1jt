<?php 
  $condition = 1;
  $activity = "";
  if(!empty($attendance)) {
    $condition = $attendance['condition'];
    $activity = $attendance['activity'];
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
  <div class="content-wrapper" id="Dashboard">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card mt-3">
            <div class="card-body">
              <h2>Presensi</h2>
              <div class="row">
                <div class="col-md-6 col-sm-12">
                  <div id="map" class="w-100" style="height: 400px;"></div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="w-100">
                    <video id="cameraFeed" class="w-100"></video>
                  </div>
                  <div class="w-100">
                    <canvas id="canvasPhoto" class="w-100" style="display: none;"></canvas>
                  </div>
                  <div class="mt-3">
                    <button class="btn btn-primary btn-block" id="btnTakePicture">Ambil Gambar</button>
                    <button class="btn btn-success btn-block" id="btnStartCamera" style="display: none;">Mulai Kamera</button>
                  </div>
                </div>
              </div>
              <div>
                <form action="#" method="post">
                  <div class="my-3">
                    <label for="labelAktivitas">Kegiatan / Aktivitas Yang Dilakukan</label>
                    <textarea name="aktivitas" id="aktivitas" class="form-control" rows="5" style="resize: none;" placeholder="Masukkan kegitatanmu"><?= $activity ?></textarea>
                  </div>
                  <div class="my-3">
                    <label for="labelKesehatan">Kondisi Kesehatan</label>
                    <div class="row">
                      <div class="col-lg-4 p-2">
                        <div class="bg-success p-2 kondisiKesehatan">
                          <div class="d-flex justify-content-center">
                            <img src="/images/happy.png" alt="sehat" class="w-50" />
                          </div>
                          <div class="text-center">
                            <h3 class="text-center">Sehat</h3>
                          </div>
                          <input type="radio" name="kondisi" value="1" class="form-control radio-kondisi" <?= $condition == 1 ? "checked" : '' ?> />
                        </div>
                      </div>
                      <div class="col-lg-4 p-2">
                        <div class="bg-warning p-2 kondisiKesehatan">
                          <div class="d-flex justify-content-center">
                            <img src="/images/face-mask.png" alt="kurang sehat" class="w-50" />
                          </div>
                          <div class="text-center">
                            <h3 class="text-center">Kurang Sehat</h3>
                          </div>
                          <input type="radio" name="kondisi" value="2" class="form-control radio-kondisi" <?= $condition == 2 ? "checked" : '' ?> />
                        </div>
                      </div>
                      <div class="col-lg-4 p-2">
                        <div class="bg-danger p-2 kondisiKesehatan">
                          <div class="d-flex justify-content-center">
                            <img src="/images/fever.png" alt="sakit" class="w-50" />
                          </div>
                          <div class="text-center">
                            <h3 class="text-center">Sakit</h3>
                          </div>
                          <input type="radio" name="kondisi" value="3" class="form-control radio-kondisi" <?= $condition == 3 ? "checked" : '' ?> />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      @if(!empty($attendance))
                        @if(!empty($attendance['clockedIn']) && empty($attendance['clockedOut']))
                          <button type="button" class="btn btn-primary btn-block" id="btnSubmit">Clock Out Pulang</button>
                        @endif
                      @else
                        <button type="button" class="btn btn-primary btn-block" id="btnSubmit">Clock In Masuk</button>
                      @endif
                    </div>
                  </div>
                </form>
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
  var lat = 0;
  var long = 0;
  var cameraFeed = document.getElementById('cameraFeed')
  var canvasPhoto = document.getElementById('canvasPhoto')
  var capturedImage = null;
  var cameraStream = null;
  $(window).on('load', function() {
    var map = L.map('map')
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    map.locate({setView: true, maxZoom: 20});
    function onLocationFound(e) {
        var radius = e.accuracy;
        lat = e.latlng.lat;
        long = e.latlng.lng;
        L.marker(e.latlng).addTo(map)
            .bindPopup("Anda berada dalam jarak " + radius + " meter dari titik ini").openPopup();
  
        L.circle(e.latlng, radius).addTo(map);
    }
    map.on('locationfound', onLocationFound);
    $(".kondisiKesehatan").on("click", function(e) {
      // console.log($(this).children('input'))
      $('.radio-kondisi').each(function(index, element) {
        $(element).prop("checked", false)
      });
      $(this).children('input').prop("checked", true)
    })

    var cameraStream;

    async function startCamera() {
      try {
        $("#btnStartCamera").css('display', 'none')
        $("#btnTakePicture").css('display', 'block')
        canvasPhoto.style.display = 'none'
        cameraFeed.style.display = 'block'
        cameraStream = await navigator.mediaDevices.getUserMedia({video: true})
        cameraFeed.srcObject = cameraStream
        cameraFeed.addEventListener("loadedmetadata", () => {
          cameraFeed.play()
        })
        // cameraFeed.srcObject = cameraStream
      } catch (error) {
        alert("Cannot start camera. Make sure you enabled camera permission")
      }
    }

    function stopCamera() {
      if(cameraStream != null) {
          const tracks = cameraStream.getTracks()
          tracks.forEach((track) => {
              track.stop()
          })
          cameraFeed.srcObject = null
          cameraStream = null

      }
    }

    function takePicture() {
          const desiredWidth = 1280; // Adjust to your desired width
          const desiredHeight = 720; // Adjust to your desired height
          canvasPhoto.width = desiredWidth
          canvasPhoto.height = desiredHeight
          canvasPhoto.getContext('2d').drawImage(cameraFeed, 0, 0, desiredWidth, desiredHeight)
          capturedImage = canvasPhoto.toDataURL('image/jpeg')
          canvasPhoto.style.display = 'block'
          cameraFeed.style.display = 'none'
          
          $("#btnStartCamera").css('display', 'block')
          $("#btnTakePicture").css('display', 'none')
          // this.$refs.canvasPhoto.width = desiredWidth
          // this.$refs.canvasPhoto.height = desiredHeight
          // this.$refs.canvasPhoto.getContext('2d').drawImage(this.$refs.cameraFeed, 0, 0, desiredWidth, desiredHeight)
          // this.CAPTURED_IMAGE = this.$refs.canvasPhoto.toDataURL('image/jpeg')
          stopCamera()
      }

    startCamera()

    $("#btnStartCamera").on('click', function() {
      startCamera()
    })

    $("#btnTakePicture").on('click', function() {
      takePicture()
    })

    $("#btnSubmit").on('click', async function(e) {
      e.preventDefault();
      // console.log($('#canvasPhoto').css('display'))
      if($("#canvasPhoto").css('display') == 'block') {
        canvasPhoto.toBlob(async(blob) => {
          const imgBlob = blob
          if(lat == 0 && long == 0) {
            Swal.fire({
                icon: 'warning',
                title: "Silahkan aktifkan ijin lokasi pada browser anda",
            })
          }
          let activity = $("#aktivitas").val()
          let kondisiKesehatan = $("input[name=kondisi]").val()
          if(activity != "" && kondisiKesehatan != "") {
            let formData = new FormData()
            formData.append("longitude", long)
            formData.append("latitude", lat)
            formData.append("condition", kondisiKesehatan)
            formData.append("activity", activity)
            formData.append("picture", imgBlob)
            $("#LoadingSpinner").addClass("show")
            let response = await makeRequestToServer("/api/presensi", "POST", true, formData)
            $("#LoadingSpinner").removeClass("show")
            if(response != null) {
              if(response.status == 200) {
                let result = await response.json()
                if(result['status'] == 200) {
                  Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: result['message'],
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    didClose: function() {
                      window.location.href = '/presensi/check-in'
                    }
                  })
                }
                else {
                  Swal.fire({
                    toast: true,
                    icon: 'warning',
                    title: result['message'],
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    didClose: function() {
                    }
                  })
                }
              }
            }
            else {
              Swal.fire({
                  toast: true,
                  icon: 'warning',
                  title: "Terjadi Kesalahan",
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000,
                  didClose: function() {
                  }
                })
            }

          }
          else {
            Swal.fire({
                icon: 'warning',
                title: "Kegiatan / Aktivitas dan Kondisi kesehatan wajib diisi",
            })
          }
        })
      }
      else {
        Swal.fire({
            icon: 'warning',
            title: "Silahkan ambil foto terlebih dahulu",
        })
      }
    })
  })
</script>
</body>
</html>
