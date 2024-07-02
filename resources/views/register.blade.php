<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/adminlte.min.css">
  <link rel="stylesheet" href="css/global.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
</head>
<body class="hold-transition login-page">
@include('components/loading')
@include('components/imagecropper')
<div class="register-box">
  <div class="register-logo">
    <a href="/register"><b>Sistem Presensi</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card mb-2 mt-2">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Halaman Registrasi User</p>

      <form action="#" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" id="registerEmail">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Fullname" name="fullname" id="registerFullname">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Jabatan" name="position" id="registerJabatan">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-briefcase"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" id="registerPassword">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Konfirmasi Password" name="confirmedPassword" id="registerConfirmedPassword">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-key"></span>
            </div>
          </div>
        </div>
        <div class="row mt-3 mb-3 px-2">
          <div class="input-group position-relative">
            <div class="photo-upload-overlay">
              <div class="d-flex justify-content-center align-items-center h-100">
                <div class="text-center">
                  <span class="text-center"><i class="fa fa-camera fa-4x"></i></span>
                  <p class="text-center mb-0">Silahkan upload atau drag gambar ke sini</p>
                </div>
              </div>
            </div>
            <input type="file" class="form-control photo-upload" name="profilePicture" id="registerPhoto">
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="button" id="btnRegister" class="btn btn-primary btn-block">Register</button>
            <div class="mt-3">
                <a href="/login">Sudah memiliki akun?</a>
            </div>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
@include('components/javascript')
<script>
  $(window).on("load", function() {
      $("#registerPhoto").on('change', (event) => {
        const currentFiles = event.target.files
          if(currentFiles && currentFiles.length > 0) {
              const reader = new FileReader()
              reader.onload = (e) => {
                // loadCrop(e.target.result)
                showModal(e.target.result)
              }
              reader.readAsDataURL(currentFiles[0])
          }
      })
      $("#btnRegister").on('click', async function(e) {
          e.preventDefault();
          // console.log(getCroppedImageBlob())
          let imageBlob = getCroppedImageBlob()
          let email = $("#registerEmail").val()
          let fullname = $("#registerFullname").val()
          let position = $("#registerJabatan").val()
          let password = $("#registerPassword").val()
          let confirmedPasswrd = $("#registerConfirmedPassword").val()
          if(email == "" || fullname == "" || position == "" || password == "" || confirmedPasswrd == "" || imageBlob == null) {
            Swal.fire({
              icon: 'warning',
              title: "Semua input wajib diisi"
            });
            return
          }
          $("#LoadingSpinner").addClass("show")
          let formData = new FormData()
          formData.append("email", email)
          formData.append("fullname", fullname)
          formData.append("position", position)
          formData.append("password", password)
          formData.append("password_confirmation", confirmedPasswrd)
          formData.append("picture", imageBlob, 'image.webp')
          let response = await makeRequestToServer("/api/auth/register", "POST", false, formData)
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
      })
  })
</script>
</body>
</html>
