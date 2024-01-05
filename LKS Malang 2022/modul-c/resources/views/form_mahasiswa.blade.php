<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | General Form Elements</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition vh-100">
<div class="container d-flex justify-content-center align-items-center h-100">
  <div class="col-md-6">
    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">Form Mahasiswa</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form class="form-horizontal" method="POST" action="/form/save">
        @csrf
        <div class="card-body">
        <div class="form-group row">
          <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
          <div class="col-sm-9">
            <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Email">
          </div>
        </div>  
        <div class="form-group row">
          <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
          <div class="col-sm-9">
            <input name="password" type="password" class="form-control" id="inputPassword" placeholder="********">
          </div>
        </div>  
        
        <div class="form-group row">
            <label for="inputPerguruan" class="col-sm-3 col-form-label">Perguruan</label>
                <div class="col-sm-9">
                    <select class="custom-select" name="perguruan" id="inputPerguruan">
                    <option value ="" selected disabled>Perguruan</option>
                      @foreach ($perguruan as $p)
                        <option value ="{{ $p->id }}">{{ $p->nama }}</option>
                      @endforeach
                    </select>
                </div>
          </div>
          <div class="form-group row">
          <label for="inputFakultas" class="col-sm-3 col-form-label">Fakultas</label>
                <div class="col-sm-9">
                    <select class="custom-select" name="fakultas" id="inputFakultas">
                      <option value ="" selected disabled>Fakultas</option>
                    @foreach ($fakultas as $f)
                        <option value ="{{ $f->id }}">{{ $f->name }}</option>
                      @endforeach
                    </select>
                </div>
          </div>
          <div class="form-group row">
          <label for="inputJurusan" class="col-sm-3 col-form-label">Jurusan</label>
                <div class="col-sm-9">
                    <select class="custom-select" name="jurusan" id="inputJurusan">
                    <option value ="" selected disabled>Jurusan</option>
                    @foreach ($jurusan as $j)
                      <option value ="{{ $j->id }}">{{ $j->name }}</option>
                    @endforeach
                    </select>
                </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-info">Save</button>
        </div>
        <!-- /.card-footer -->
      </form>
    </div>
    <!-- /.card -->
  </div>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="dist/js/demo.js"></script> --}}
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
