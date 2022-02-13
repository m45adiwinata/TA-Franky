@extends('layouts.main')
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Master Suplier</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Suplier</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Suplier Barang</h3>
                <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus"></i> Tambah</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. Telp 1</th>
                    <th>No. Telp 2</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($supliers as $key => $suplier)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$suplier->nama}}</td>
                      <td>{{$suplier->alamat}}</td>
                      <td>{{$suplier->telp1}}</td>
                      <td>{{$suplier->telp2}}</td>
                      <td><button class="btn btn-primary" onclick="edit({{$suplier->id}})">edit</button> / <button class="btn btn-danger" onclick="del({{$suplier->id}})">delete</button></td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. Telp 1</th>
                    <th>No. Telp 2</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
      <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Suplier</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- general form elements -->
              <div class="card card-primary">
                <!-- form start -->
                <form method="POST" action="{{route('suplier.add')}}">
                  @csrf
                  <div class="card-body dark-mode">
                    <div class="form-group">
                      <label for="nama">Nama Suplier</label>
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="Input nama">
                    </div>
                    <div class="form-group">
                      <label for="alamat">Alamat</label>
                      <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Input alamat">
                    </div>
                    <div class="form-group">
                      <label for="telp1">No. Telp 1</label>
                      <input type="text" class="form-control" id="telp1" name="telp1" placeholder="Input nomor telpon">
                    </div>
                    <div class="form-group">
                      <label for="telp2">No. Telp 2</label>
                      <input type="text" class="form-control" id="telp2" name="telp2" placeholder="Input nomor telpon">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                  <!-- /.card-body -->
                </form>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Suplier</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- general form elements -->
              <div class="card card-primary">
                <!-- form start -->
                <form id="form-edit" method="POST" action="">
                  @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nama2">Nama Suplier</label>
                      <input type="text" class="form-control" id="nama2" name="nama" placeholder="Input nama">
                    </div>
                    <div class="form-group">
                      <label for="alamat2">Alamat</label>
                      <input type="text" class="form-control" id="alamat2" name="alamat" placeholder="Input alamat">
                    </div>
                    <div class="form-group">
                      <label for="telp12">No. Telp 1</label>
                      <input type="text" class="form-control" id="telp12" name="telp1" placeholder="Input nomor telpon">
                    </div>
                    <div class="form-group">
                      <label for="telp22">No. Telp 2</label>
                      <input type="text" class="form-control" id="telp22" name="telp2" placeholder="Input nomor telpon">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                  <!-- /.card-body -->
                </form>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Hapus Suplier</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- general form elements -->
              <div class="card card-primary">
                <!-- form start -->
                <form id="form-delete" method="POST" action="">
                  @csrf
                  <div class="card-body">
                    <p>Konfirmasi hapus suplier.</p>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                  <!-- /.card-body -->
                </form>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('script')
<!-- DataTables  & Plugins -->
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('adminlte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<!-- Page specific script -->
<script>
  $(document).keydown(function(event) { 
    if (event.keyCode == 27) { 
      $('.modal.fade').modal('hide');
    }
  });
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
  function edit(id) {
    $.ajax({
      url: "/master-suplier/"+id,
      type: "get",
    }).done(function(data) {
      $('#modal-edit').modal('show');
      $('#form-edit').attr("action", "/master-suplier/"+id+"/update");
      $('#nama2').val(data.nama);
      $('#alamat2').val(data.alamat);
      $('#telp12').val(data.telp1);
      $('#telp22').val(data.telp1);
    });
  }
  function del(id) {
    $.ajax({
      url: "/master-suplier/"+id,
      type: "get",
    }).done(function(data) {
      $('#modal-delete').modal('show');
      $('#form-delete').attr("action", "/master-suplier/"+id+"/delete");
    });
  }
</script>
@endsection