@extends("layout")

@section("container")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Mahasiswa Baru</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Mahasiswa Baru</li>
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
        <!-- TABLE: LATEST ORDERS -->
        <div class="card w-100">
          <div class="card-header border-transparent">
            <h3 class="card-title mr-3">Mahasiswa Baru</h3>
            <form class="d-inline-flex" method="GET" action="/mahasiswa_baru">
              <select class="form-control" required name="search">
                <option selected disabled>Filter</option>
                <option value="email" {{ $defaults["search"] == "email" ? "selected" : "" }}>Email</option>
                <option value="nama" {{ $defaults["search"] == "nama" ? "selected" : "" }}>Nama</option>
                <option value="jurusan" {{ $defaults["search"] == "jurusan" ? "selected" : "" }}>Jurusan</option>
              </select>
              <input name="q" value="{{ $defaults["q"] }}" type="text" required class="form-control mx-2" placeholder="Kata kunci" aria-describedby="basic-addon2">
              <button class='btn btn-success' type="submit">Cari</button>
            </form>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0">
                <thead>
                  <tr>
                    <th>ID Mahasiswa</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Perguruan</th>
                    <th>Fakultas</th>
                    <th>Jurusan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($mahasiswa_baru as $mahasiswa)
                  <tr>
                    <td><a href="pages/examples/invoice.html">MHS{{ $mahasiswa->id }}</a></td>
                    <td>{{ $mahasiswa->nama }}</td>
                    <td>{{ $mahasiswa->user_data->email }}</td>
                    <td>{{ $mahasiswa->perguruan->nama }}</td>
                    <td>{{ $mahasiswa->fakultas->name }}</td>
                    <td>{{ $mahasiswa->jurusan->name }}</td>
                    @if ($mahasiswa->status == 2)
                    <td><span class="badge badge-success">Diterima / Aktif</span></td>
                    @elseif ($mahasiswa->status == 1)
                    <td><span class="badge badge-warning">Pending</span></td>
                    @elseif ($mahasiswa->status == 0)
                    <td><span class="badge badge-danger">Ditolak / Non Aktif</span></td>
                    @endif
                    <td>
                      <button style="font-size: 14px;" data-bs-toggle="modal" data-bs-target="#editModal{{ $mahasiswa->id }}" class="btn btn-warning"><i class="fa fa-pen"></i></button>

                      <div class="modal fade" id="editModal{{ $mahasiswa->id }}" tabindex="-1" aria-labelledby="editModal{{ $mahasiswa->id }}" aria-hidden="true">
                        <form action="/api/v1/mahasiswa_baru/edit" method="POST">
                          @csrf
                          <input type="hidden" value="{{ $mahasiswa->id }}" name="id" />

                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h3 class="modal-title fs-5" id="exampleModalLabel">Edit MHS{{ $mahasiswa->id }}</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <select name="status" value="2" class="form-control" aria-label="Default select example" required>
                                  <option selected disabled>Status</option>
                                  <option value="0" {{ $mahasiswa->status == 0 ? "selected" : "" }}>
                                    Ditolak / Non Aktif</span>
                                  </option>
                                  <option value="1" {{ $mahasiswa->status == 1 ? "selected" : "" }}>
                                    Pending</span>
                                  </option>
                                  <option value="2" {{ $mahasiswa->status == 2 ? "selected" : "" }}>
                                    Diterima / Aktif</span>
                                  </option>
                                </select>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
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
            {{-- <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a> --}}
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
</div>
<!-- /.content-wrapper -->
@endsection
