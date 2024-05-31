<!DOCTYPE html>
<html lang="en">
@include('components/header')
<body class="hold-transition sidebar-mini layout-fixed">
@include('components/loading')
@include('components/imagecropper')
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  @include('components/navbarcontent')

  @include('components/sidebarcontent')  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="RiwayatPresensiContent">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card mt-3">
            <div class="card-body">
              <h2>Edit Profil</h2>
              <form action="#" method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" id="editEmail" value="<?= $userProfile['email'] ?>" disabled>
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Fullname" name="fullname" id="editFullname" value="<?= $userProfile['fullname'] ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Jabatan" name="position" id="editJabatan" value="<?= $userProfile['position'] ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-briefcase"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" id="editPassword">
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Konfirmasi Password" name="confirmedPassword" id="editConfirmedPassword">
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
                            <input type="file" class="form-control photo-upload" name="profilePicture" id="editPhoto">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" id="btnEdit" class="btn btn-primary btn-block">Edit Profil</button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  @include('components/footer')
</div>
<!-- ./wrapper -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(window).on("load", function() {
        $("#editPhoto").on('change', (event) => {
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
        $("#btnEdit").on('click', async function(e) {
            e.preventDefault();
            let imageBlob = getCroppedImageBlob()
            let email = $("#editEmail").val()
            let fullname = $("#editFullname").val()
            let position = $("#editJabatan").val()
            let password = $("#editPassword").val()
            let confirmedPasswrd = $("#editConfirmedPassword").val()

            let formData = new FormData()
            formData.append("email", email)
            formData.append("fullname", fullname)
            formData.append("position", position)
            formData.append("password", password)
            formData.append("password_confirmation", confirmedPasswrd)
            if(imageBlob != null) {
                formData.append("picture", imageBlob, 'image.webp')
            }
            $("#LoadingSpinner").addClass("show")
            let response = await makeRequestToServer("/api/edit-profile/<?= $userProfile['userID'] ?>", "POST", true, formData)
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
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
</body>
</html>
