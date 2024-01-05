@extends("layout")

@section("container")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Member</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Member</li>
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
            <h3 class="card-title mr-3">Member</h3>
            <form class="d-inline-flex" method="GET" action="/member">
              <select class="form-control" required name="search">
                <option selected disabled>Filter</option>
                <option value="email">Email</option>
                <option value="name">Nama</option>
              </select>
              <input name="q" type="text" required class="form-control mx-2" placeholder="Kata kunci" aria-describedby="basic-addon2">
              <button class='btn btn-success' type="submit">Cari</button>
            </form>
          </div>
          <div class="card-header border-transparent">
            <h3 class="card-title">Member</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0">
                <thead>
                  <tr>
                    <th>ID Member</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($members as $member)
                  <tr>
                    <td><a href="pages/examples/invoice.html">MB{{ $member->id }}</a></td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->password }}</td>
                    @if ($member->status)
                    <td><span class="badge badge-success">Aktif</span></td>
                    @else
                    <td><span class="badge badge-danger">Non Aktif</span></td>
                    @endif
                    <td>
                      <a href="/member/toggle?id={{$member->id}}&status={{$member->status}}" style="font-size: 14px;" class="btn btn-success">Toggle</a>
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
@endsection