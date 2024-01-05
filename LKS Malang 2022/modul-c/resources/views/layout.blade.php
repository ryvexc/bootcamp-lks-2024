<!DOCTYPE html>
<html lang="en">

<head>
  <script>
    if('{{ !request()->cookie('name') }}') {
      window.location.href = "/";
    }
  </script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>

  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-dark">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/api/v1/auth/logout" role="button">
            <p>Logout</p>
          </a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Modul C</span>
      </a>

      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{ request()->cookie('name') }}</a>
          </div>
        </div>

        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="/dashboard" class="nav-link {{ Request::getRequestUri() == '/dashboard' ? 'active' : "" }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/perguruan_tinggi" class="nav-link {{ Request::getRequestUri() == '/perguruan_tinggi' ? 'active' : "" }}">
                <i class="nav-icon fas fa-school"></i>
                <p>
                  Perguruan Tinggi
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/fakultas" class="nav-link {{ Request::getRequestUri() == '/fakultas' ? 'active' : "" }}">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Fakultas
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/jurusan" class="nav-link {{ Request::getRequestUri() == '/jurusan' ? 'active' : "" }}">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Jurusan
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/mahasiswa_baru" class="nav-link {{ Request::getRequestUri() == '/mahasiswa_baru' ? 'active' : "" }}">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <p>
                  Mahasiswa Baru
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/member" class="nav-link {{ Request::getRequestUri() == '/member' ? 'active' : "" }}">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Member
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="nav-icon fas fa-trash"></i>
                <p>
                  Sampah
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/sampah/jurusan" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Fakultas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/sampah/jurusan" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Jurusan</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-header">LABELS</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p class="text">Important</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-circle text-warning"></i>
                <p>Warning</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-circle text-info"></i>
                <p>Informational</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    @yield("container")

    <footer class="main-footer">
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
      </div>
    </footer>
  </div>

  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="dist/js/adminlte.js"></script>
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <script src="plugins/chart.js/Chart.min.js"></script>

  <script>
    function imagePreview(input, index) {
      document.getElementById("img-preview-"+index).src = input.value;
    }
  </script>
</body>
</html>