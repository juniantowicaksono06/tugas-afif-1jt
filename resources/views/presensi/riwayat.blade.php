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
              <h2>Riwayat Presensi</h2>
              <p>Menampilkan <?= ($currentPage - 1) * $limit + 1  ?> - <?= ($currentPage - 1) * $limit + count($data) ?> dari total <?= $totalData ?> data</p>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Action</th>
                    <th>Presensi Masuk</th>
                    <th>Presensi Pulang</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $presensi)
                    <tr>
                      <td>
                        <button class="btn btn-success detail-page" data-id="<?= $presensi['attendanceID'] ?>">
                          <i class="fa fa-eye"></i>
                        </button>
                      </td>
                      <td>
                        <?= !empty($presensi['clockedIn']) ? $presensi['clockedIn'] : "" ?>
                      </td>
                      <td>
                        <?= !empty($presensi['clockedOut']) ? $presensi['clockedOut'] : "" ?>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div>
              <div class="justify-content-end d-flex mb-3 px-3">
                <div class="mr-2">
                  @if($currentPage > 1)
                    <button class="btn btn-primary">
                      <i class="fa fa-chevron-left"></i>
                    </button>
                  @endif
                </div>
                <div>
                  <?php 
                    $backPage = 0;
                    $frontPage = 0;
                  ?>
                  @for($x = 1; $x <= $currentPage; $x++)
                  @if($backPage == 3)
                    @break
                  @endif
                  <?php $backPage++; ?>
                  <button class="btn <?= $currentPage == $x ? "btn-primary" : "btn-default" ?> <?= $x != $currentPage ? "jump-page" : "" ?>" <?= $x != $currentPage ? "data-page='".$x."'" : "" ?>><?= $x ?></button>
                  @endfor
                  @for($x = ($currentPage + 1); $x <= $totalPage; $x++) 
                    @if($frontPage == 3)
                      @break
                    @endif
                    <?php $frontPage++; ?>
                    <button class="btn <?= $currentPage == $x ? 'btn-primary' : 'btn-default' ?> <?= $x != $currentPage ? "jump-page" : "" ?>" <?= $x != $currentPage ? "data-page='".$x."'" : "" ?>><?= $x ?></button>
                  @endfor
                </div>
                <div class="ml-2">
                  @if($currentPage < $totalPage)
                      <button class="btn btn-primary">
                        <i class="fa fa-chevron-right"></i>
                      </button>
                    @endif
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
  $(".jump-page").on("click", function() {
    let url = new URL(window.location.href)
    let urlSearchParams = new URLSearchParams(url.search)
    let pageNumber = $(this).data('page')
    urlSearchParams.set('page_offset', pageNumber)
    let href = `${window.location.origin}${window.location.pathname}?${urlSearchParams.toString()}`
    window.location.href = href
  })

  $(".detail-page").on('click', function() {
    let url = `${window.location.origin}/presensi/detail/${$(this).data('id')}`
    window.location.href = url
  })
</script>
</body>
</html>
