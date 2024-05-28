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
</head>
<body class="hold-transition login-page">
@include('components/loading')
<div class="login-box">
  <div class="login-logo">
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
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" id="registerPassword">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-eye"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Konfirmasi Password" name="confirmedPassword" id="registerConfirmedPassword">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-eye"></span>
            </div>
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

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
@include('components/javascript')
<script>
  $(window).on("load", function() {
      $("#btnRegister").on('click', async function(e) {
          e.preventDefault()
          let email = $("#registerEmail").val()
          let fullname = $("#registerFullname").val()
          let position = $("#registerJabatan").val()
          let password = $("#registerPassword").val()
          let confirmedPasswrd = $("#registerConfirmedPassword").val()
          if(email == "" || fullname == "" || position == "" || password == "" || confirmedPasswrd == "") return
          $("#LoadingSpinner").addClass("show")
          let formData = new FormData()
          formData.append("email", email)
          formData.append("fullname", fullname)
          formData.append("position", position)
          formData.append("password", password)
          formData.append("password_confirmation", confirmedPasswrd)
          let response = await makeRequestToServer("/api/auth/register", "POST", false, formData)
          $("#LoadingSpinner").removeClass("show")
          if(response != null) {
            if(response.status == 200) {
              let result = await response.json()
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
          }
      })
  })
</script>
</body>
</html>
