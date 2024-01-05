@extends("layout")

@section('container')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Jurusan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Jurusan</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row px-2">
        <div class="card w-100">
          <div class="card-header border-transparent">
            <h3 class="card-title">Jurusan</h3>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0">
                <thead>
                  <tr>
                    <th>ID Jurusan</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Fakultas</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($jurusan as $jur)
                  <tr>
                    <td><a href="pages/examples/invoice.html">JR{{ $jur->id }}</a></td>
                    <td>{{ $jur->name }}</td>
                    @if ($jur->status)
                    <td><span class="badge badge-success">Aktif</span></td>
                    @else
                    <td><span class="badge badge-danger">Non Aktif</span></td>
                    @endif
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20">{{ $jur->fakultas->name }}</div>
                    </td>
                    <td>
                      <a href="/jurusan/toggle?id={{$jur->id}}&status={{$jur->status}}" style="font-size: 14px;" class="btn btn-success">Toggle</a>
                      <button style="font-size: 14px;" data-bs-toggle="modal" data-bs-target="#editModal{{ $jur->id }}" class="btn btn-warning"><i class="fa fa-pen"></i></button>

                      <div class="modal fade" id="editModal{{ $jur->id }}" tabindex="-1" aria-labelledby="editModal{{ $jur->id }}" aria-hidden="true">
                        <form action="/api/v1/jurusan/edit" method="POST">
                          @csrf
                          <input type="hidden" value="{{ $jur->id }}" name="id" />

                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h3 class="modal-title fs-5" id="exampleModalLabel">Edit JR{{ $jur->id }}</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="input-group mb-3">
                                  <input name="name" value="{{ $jur->name }}" type="text" required class="form-control" placeholder="Nama Jurusan" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                </div>
                                <select name="fakultas_id" value="2" class="form-control" aria-label="Default select example" required>
                                  <option selected disabled>Pilih Fakultas</option>
                                  @foreach ($fakultas as $fak)
                                    <option value="{{ $fak->id }}" {{ $jur->fakultas_id == $fak->id ? "selected" : "" }}>{{ $fak->name }}</option>
                                  @endforeach
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
                      <a href="/jurusan/delete?id={{$jur->id}}" style="font-size: 14px;" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer clearfix">
            <button class="btn btn-primary" style="font-size: 14px;" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Jurusan</button>

            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModal" aria-hidden="true">
              <form action="/api/v1/jurusan/tambah" method="POST">
                @csrf
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title fs-5" id="exampleModalLabel">Tambah Jurusan</h3>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="input-group mb-3">
                        <input name="name" type="text" required class="form-control" placeholder="Nama Jurusan" aria-label="Recipient's username" aria-describedby="basic-addon2">
                      </div>
                      <select name="fakultas_id" value="2" class="form-control" aria-label="Default select example" required>
                        <option selected disabled>Pilih Fakultas</option>
                        @foreach ($fakultas as $fak)
                          <option value="{{ $fak->id }}">{{ $fak->name }}</option>
                        @endforeach
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
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
  