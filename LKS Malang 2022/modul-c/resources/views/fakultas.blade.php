@extends("layout")

@section("container")
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Fakultas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Fakultas</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row px-2">
          <!-- TABLE: Fakultas -->
          <div class="card w-100">
            <div class="card-header border-transparent">
              <h3 class="card-title">Fakultas</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                    <tr>
                      <th>ID Fakultas</th>
                      <th>Nama</th>
                      <th>Status</th>
                      <th>Jumlah Jurusan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($fakultas as $fakul)
                    <tr>
                      <td><a href="pages/examples/invoice.html">FK{{ $fakul->id }}</a></td>
                      <td>{{ $fakul->name }}</td>
                      @if ($fakul->status)
                      <td><span class="badge badge-success">Aktif</span></td>
                      @else
                      <td><span class="badge badge-danger">Non Aktif</span></td>
                      @endif
                      <td>
                        <div class="sparkbar" data-color="#00a65a" data-height="20">{{ $fakul->jurusan->count() }} Jurusan</div>
                      </td>
                      <td>
                        <a href="/fakultas/toggle?id={{$fakul->id}}&status={{$fakul->status}}" style="font-size: 14px;" class="btn btn-success">Toggle</a>
                        <button style="font-size: 14px;" data-bs-toggle="modal" data-bs-target="#editModal{{ $fakul->id }}" class="btn btn-warning"><i class="fa fa-pen"></i></button>

                        <div class="modal fade" id="editModal{{ $fakul->id }}" tabindex="-1" aria-labelledby="editModal{{ $fakul->id }}" aria-hidden="true">
                          <form action="/api/v1/fakultas/edit" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $fakul->id }}" name="id" />

                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title fs-5" id="exampleModalLabel">Edit FK{{ $fakul->id }}</h3>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="input-group mb-3">
                                    <input name="name" value="{{ $fakul->name }}" type="text" required class="form-control" placeholder="Nama Jurusan" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                        <a href="/fakultas/delete?id={{$fakul->id}}" style="font-size: 14px;" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <button class="btn btn-primary" style="font-size: 14px;" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Fakultas</button>

              <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModal" aria-hidden="true">
                <form action="/api/v1/fakultas/tambah" method="POST">
                  @csrf
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">Tambah Fakultas</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="input-group mb-3">
                          <input name="name" type="text" required class="form-control" placeholder="Nama Fakultas" aria-describedby="basic-addon2">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
  </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection