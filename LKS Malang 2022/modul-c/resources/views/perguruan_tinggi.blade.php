@extends("layout")

@section("container")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Perguruan Tinggi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Perguruan Tinggi</li>
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
            <h3 class="card-title">Perguruan Tinggi</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Website</th>
                    <th>Alamat</th>
                    <th>Akreditasi</th>
                    {{-- <th class="text-nowrap">Jumlah Mahasiswa</th>
                    <th class="text-nowrap">Jumlah Fakultas</th> --}}
                    <th>Fakultas</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Whatsapp</th>
                    <th class="text-nowrap">Biaya Pendaftaran</th>
                    <th style="min-width: 150px !important;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($perguruan as $pg)
                  <tr>
                    <td><a href="pages/examples/invoice.html">PG{{ $pg->id }}</a></td>
                    <td><img width="100" src="{{ $pg->gambar }}" /></td>
                    <td>{{ $pg->nama }}</td>
                    <td>{{ $pg->kategori }}</td>
                    <td><a href="{{ $pg->website }}">{{ $pg->website }}</a></td>
                    <td>{{ $pg->alamat }}</td>
                    <td>{{ $pg->akreditasi }}</td>
                    {{-- <td>{{ $pg->mahasiswa()->where('perguruan_id', $pg->id)->where('status', 2)->count() }} Mahasiswa</td> --}}
                    {{-- <td>{{ $pg->fakultas_junction->count() }} Fakultas</td> --}}
                    <td>
                      <ol>
                        @foreach ($pg->fakultas_junction as $junction)
                            <li class="text-nowrap">{{ $junction->fakultas->name }}</li>
                        @endforeach
                      </ol>
                    </td>
                    <td>{{ $pg->telepon }}</td>
                    <td>{{ $pg->email }}</td>
                    <td class="text-nowrap">{{ $pg->whatsapp }}</td>
                    <td>@currency($pg->biaya)</td>
                    <td>
                      <button style="font-size: 14px;" data-bs-toggle="modal" data-bs-target="#editModal{{ $pg->id }}" class="btn btn-warning"><i class="fa fa-pen"></i></button>

                      <div class="modal fade" id="editModal{{ $pg->id }}" tabindex="-1" aria-labelledby="editModal{{ $pg->id }}" aria-hidden="true">
                        <form action="/api/v1/perguruan/edit" method="POST">
                          @csrf
                          <input type="hidden" value="{{ $pg->id }}" name="id" />
                          <input id="fakultas-input-hidden-{{ $pg->id }}" type="hidden" name="fakultas" value="" />

                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h3 class="modal-title fs-5" id="exampleModalLabel">Edit PG{{ $pg->id }}</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="input-group mb-3">
                                  <input onkeyup="imagePreview(this, {{ $pg->id }})" name="link_gambar" value="{{ $pg->gambar }}" type="text" class="form-control" placeholder="Link Gambar" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                </div>
                                <div class="input-group mb-3 p-3 border border-secondary rounded">
                                  <img id="img-preview-{{ $pg->id }}" src="{{ $pg->gambar }}" class="w-100 rounded" alt="img preview">
                                </div>
                                <div class="input-group mb-3">
                                  <input name="name" value="{{ $pg->nama }}" type="text" required class="form-control" placeholder="Nama Perguruan" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                </div>
                                <select name="kategori" value="2" class="form-control mb-3" aria-label="Default select example" required>
                                  <option selected disabled>Pilih Kategori</option>
                                  <option value="Politeknik" {{ $pg->kategori == "Politeknik" ? "selected" : "" }}>Politeknik</option>
                                  <option value="Swasta" {{ $pg->kategori == "Swasta" ? "selected" : "" }}>Swasta</option>
                                  <option value="Negeri" {{ $pg->kategori == "Negeri" ? "selected" : "" }}>Negeri</option>
                                  <option value="Sekolah Tinggi" {{ $pg->kategori == "Sekolah Tinggi" ? "selected" : "" }}>Sekolah Tinggi</option>
                                  <option value="Institut" {{ $pg->kategori == "Institut" ? "selected" : "" }}>Institut</option>
                                </select>
                                <select name="akreditasi" value="2" class="form-control mb-3" aria-label="Default select example" required>
                                  <option selected disabled>Pilih Akreditasi</option>
                                  <option value="A" {{ $pg->akreditasi == "A" ? "selected" : "" }}>A</option>
                                  <option value="B" {{ $pg->akreditasi == "B" ? "selected" : "" }}>B</option>
                                  <option value="C" {{ $pg->akreditasi == "C" ? "selected" : "" }}>C</option>
                                </select>
                                <div class="input-group mb-3">
                                  <input name="website" value="{{ $pg->website }}" type="text" required class="form-control" placeholder="Link Website" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                </div>
                                <div class="input-group mb-3">
                                  <textarea rows="2" name="alamat" type="text" required class="form-control" placeholder="Alamat" aria-label="Recipient's username" aria-describedby="basic-addon2">{{ $pg->alamat }}</textarea>
                                </div>
                                <div class="input-group mb-3">
                                  <textarea rows="4" name="description" type="text" required class="form-control" placeholder="Deskripsi" aria-label="Recipient's username" aria-describedby="basic-addon2">{{ $pg->description }}</textarea>
                                </div>
                                <div class="input-group mb-3">
                                  <input name="telepon" value="{{ $pg->telepon }}" type="text" required class="form-control" placeholder="Nomor Telepon" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                </div>
                                <div class="input-group mb-3">
                                  <input name="email" value="{{ $pg->email }}" type="email" required class="form-control" placeholder="Email" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                </div>
                                <div class="input-group mb-3">
                                  <input name="whatsapp" value="{{ $pg->whatsapp }}" type="text" required class="form-control" placeholder="Nomor/Link Whatsapp" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                </div>
                                <div class="input-group mb-3">
                                  <input name="biaya" value="{{ $pg->biaya }}" type="number" required class="form-control" placeholder="Biaya Pendaftaran" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                </div>
                                <div class="input-group">
                                  <p>Fakultas Terpilih:</p>
                                  <ol id="fakultas-terpilih-{{ $pg->id }}">
                                    @foreach($pg->fakultas_junction as $junction)
                                      <li>
                                        <div class="mb-1">
                                          {{ $junction->fakultas->name }}
                                          <button type="button" role="button" onclick="hapusEditFakultas(&quot;1&quot;, 6)" class="btn btn-danger btn-sm ml-3">Hapus</button>
                                        </div>
                                      </li>
                                    @endforeach
                                  </ol>
                                </div>
                                <div class="d-flex">
                                  <select id="opsi-fakultas-{{ $pg->id }}" name="fakultas_id" value="2" class="form-control" aria-label="Default select example">
                                    <option selected disabled>Pilih Fakultas</option>
                                    @foreach ($fakultas as $fak)
                                      <option value="{{ $fak->id }}">{{ $fak->name }}</option>
                                    @endforeach
                                  </select>
                                  <button onclick="editFakultas({{ $pg->id }})" class="btn btn-primary" type="button" role="button">Tambah</button>
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

                      <a href="/perguruan_tinggi/delete?id={{$pg->id}}" style="font-size: 14px;" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
            <button class="btn btn-primary" style="font-size: 14px;" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Universitas</button>

            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModal" aria-hidden="true">
              <form action="/api/v1/perguruan/tambah" method="POST">
                @csrf
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title fs-5" id="exampleModalLabel">Tambah Universitas</h3>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <input id="fakultas-input-hidden" type="hidden" name="fakultas" value="" />
                      <div class="input-group mb-3">
                        <input onkeyup="imagePreview(this, 'tambah')" name="link_gambar" type="text" class="form-control" placeholder="Link Gambar" aria-label="Recipient's username" aria-describedby="basic-addon2">
                      </div>
                      <div class="input-group mb-3 p-3 border border-secondary rounded">
                        <img id="img-preview-tambah" class="w-100 rounded" alt="img preview">
                      </div>
                      <div class="input-group mb-3">
                        <input name="name" type="text" required class="form-control" placeholder="Nama Perguruan" aria-label="Recipient's username" aria-describedby="basic-addon2">
                      </div>
                      <select name="kategori" value="2" class="form-control mb-3" aria-label="Default select example" required>
                        <option selected disabled>Pilih Kategori</option>
                        <option value="Politeknik">Politeknik</option>
                        <option value="Swasta">Swasta</option>
                        <option value="Negeri">Negeri</option>
                        <option value="Sekolah Tinggi">Sekolah Tinggi</option>
                        <option value="Institut">Institut</option>
                      </select>
                      <select name="akreditasi" value="2" class="form-control mb-3" aria-label="Default select example" required>
                        <option selected disabled>Pilih Akreditasi</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                      </select>
                      <div class="input-group mb-3">
                        <input name="website" type="text" required class="form-control" placeholder="Link Website" aria-label="Recipient's username" aria-describedby="basic-addon2">
                      </div>
                      <div class="input-group mb-3">
                        <textarea rows="2" name="alamat" type="text" required class="form-control" placeholder="Alamat" aria-label="Recipient's username" aria-describedby="basic-addon2"></textarea>
                      </div>
                      <div class="input-group mb-3">
                        <textarea rows="4" name="description" type="text" required class="form-control" placeholder="Deskripsi" aria-label="Recipient's username" aria-describedby="basic-addon2"></textarea>
                      </div>
                      <div class="input-group mb-3">
                        <input name="telepon" type="text" required class="form-control" placeholder="Nomor Telepon" aria-label="Recipient's username" aria-describedby="basic-addon2">
                      </div>
                      <div class="input-group mb-3">
                        <input name="email" type="email" required class="form-control" placeholder="Email" aria-label="Recipient's username" aria-describedby="basic-addon2">
                      </div>
                      <div class="input-group mb-3">
                        <input name="whatsapp" type="text" required class="form-control" placeholder="Nomor/Link Whatsapp" aria-label="Recipient's username" aria-describedby="basic-addon2">
                      </div>
                      <div class="input-group mb-3">
                        <input name="biaya" type="number" required class="form-control" placeholder="Biaya Pendaftaran" aria-label="Recipient's username" aria-describedby="basic-addon2">
                      </div>
                      <div class="input-group">
                        <p>Fakultas Terpilih:</p>
                        <ol id="fakultas-terpilih">
                          
                        </ol>
                      </div>
                      <div class="d-flex">
                        <select id="opsi-fakultas" name="fakultas_id" value="2" class="form-control" aria-label="Default select example">
                          <option selected disabled>Pilih Fakultas</option>
                          @foreach ($fakultas as $fak)
                            <option value="{{ $fak->id }}">{{ $fak->name }}</option>
                          @endforeach
                        </select>
                        <button onclick="tambahFakultas()" class="btn btn-primary" type="button" role="button">Tambah</button>
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
  </section>
</div><!--/. container-fluid -->

<script>
  const opsiFakultas = document.getElementById("opsi-fakultas")
  const fakultasTerpilih = document.getElementById("fakultas-terpilih")
  let selectedFakultas = []
  let selectedFakultasEdit = []
  let fakultas = {!! json_encode($fakultas) !!}

  for(let i=0; i<{{ $pg->id }}; i++) selectedFakultasEdit.push([]);

  const updateOption = (newOptions) => {
    opsiFakultas.innerHTML = ""

    const firstOption = document.createElement("option");
    firstOption.value = ""
    firstOption.text = "Pilih Fakultas"
    firstOption.disabled = true
    firstOption.selected = true
    opsiFakultas.add(firstOption)

    newOptions.forEach(option => {
      var optionObject = document.createElement('option');
      optionObject.value = option.id;
      optionObject.text = option.name;
      opsiFakultas.add(optionObject);
    })

    fakultasTerpilih.innerHTML = ""
    selectedFakultas.forEach(fak => {
      const listFakultas = document.createElement("li");
      listFakultas.innerHTML = `<div class="mb-1">
        ${fakultas.filter(fk => fk.id == fak)[0].name}
        <button type="button" role="button" onclick='hapusFakultas("${fak}")' class='btn btn-danger btn-sm ml-3'>Hapus</button>
      </div>`;
      fakultasTerpilih.appendChild(listFakultas);
    })

    document.getElementById("fakultas-input-hidden").value = selectedFakultas.join(",");
  }

  const tambahFakultas = () => {
    const selectedId = opsiFakultas.options[opsiFakultas.selectedIndex].value

    selectedFakultas.push(selectedId)

    const newOptions = fakultas.filter(fak => {
      return !selectedFakultas.includes(fak.id.toString());
    });

    updateOption(newOptions);
  }

  const hapusFakultas = (id) => {
    selectedFakultas = selectedFakultas.filter(fak => fak != id)

    const newOptions = fakultas.filter(fak => {
      return !selectedFakultas.includes(fak.id.toString());
    });

    updateOption(newOptions);
  }

  const updateOptionEdit = (newOptions, id) => {
    const opsiFakultas = document.getElementById(`opsi-fakultas-${id}`)
    const fakultasTerpilih = document.getElementById(`fakultas-terpilih-${id}`)
    opsiFakultas.innerHTML = ""

    const firstOption = document.createElement("option");
    firstOption.value = ""
    firstOption.text = "Pilih Fakultas"
    firstOption.disabled = true
    firstOption.selected = true
    opsiFakultas.add(firstOption)

    newOptions.forEach(option => {
      var optionObject = document.createElement('option');
      optionObject.value = option.id;
      optionObject.text = option.name;
      opsiFakultas.add(optionObject);
    })

    fakultasTerpilih.innerHTML = ""
    selectedFakultasEdit[id - 1].forEach(fak => {
      const listFakultas = document.createElement("li");
      listFakultas.innerHTML = `<div class="mb-1">
        ${fakultas.filter(fk => fk.id == fak)[0].name}
        <button type="button" role="button" onclick='hapusEditFakultas("${fak}", ${id})' class='btn btn-danger btn-sm ml-3'>Hapus</button>
      </div>`;
      fakultasTerpilih.appendChild(listFakultas);
    })

    document.getElementById(`fakultas-input-hidden-${id}`).value = selectedFakultasEdit[id - 1].join(",");
  }

  const editFakultas = (id) => {
    const opsiFakultas = document.getElementById(`opsi-fakultas-${id}`)
    const selectedId = opsiFakultas.options[opsiFakultas.selectedIndex].value

    selectedFakultasEdit[id - 1].push(selectedId);

    const newOptions = fakultas.filter(fak => {
      return !selectedFakultasEdit[id - 1].includes(fak.id.toString());
    });

    updateOptionEdit(newOptions, id);
  }

  const hapusEditFakultas = (id, id_edit) => {
    selectedFakultasEdit[id_edit - 1] = selectedFakultasEdit[id_edit - 1].filter(fak => fak != id)

    console.log({new: selectedFakultasEdit[id_edit - 1]});

    const newOptions = fakultas.filter(fak => {
      return !selectedFakultasEdit[id_edit - 1].includes(fak.id.toString());
    });

    updateOptionEdit(newOptions, id_edit);
  }

  @foreach($perguruan as $pg)
    @foreach($pg->fakultas_junction as $junction)
      selectedFakultasEdit[{{ $junction->perguruan->id }} - 1].push('' + {{ $junction->fakultas->id }})
    @endforeach
    {
      let newOptions = fakultas.filter(fak => {
        return !selectedFakultasEdit[{{ $junction->perguruan->id }} - 1].includes(fak.id.toString());
      });

      updateOptionEdit(newOptions, {{ $junction->perguruan->id }});
    }
  @endforeach
</script>
@endsection