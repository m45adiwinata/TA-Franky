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
            <h1>Master Gudang</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Gudang</li>
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
                <h3 class="card-title">Daftar Gudang</h3>
                <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus"></i> Tambah</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nama Gudang</th>
                    <th>Kode Gudang</th>
                    <th>Keterangan 1</th>
                    <th>Keterangan 2</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($gudangs as $gudang)
                    <tr>
                      <td>{{$gudang->nama}}</td>
                      <td>{{$gudang->kode}}</td>
                      <td>{{$gudang->ket1}}</td>
                      <td>{{$gudang->ket2}}</td>
                      <td><button class="btn btn-primary" onclick="edit({{$gudang->id}})">edit</button> / <button class="btn btn-danger" onclick="del({{$gudang->id}})">delete</button></td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Nama Gudang</th>
                    <th>Kode Gudang</th>
                    <th>Keterangan 1</th>
                    <th>Keterangan 2</th>
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
              <h4 class="modal-title">Tambah Gudang</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- general form elements -->
              <div class="card card-primary">
                <!-- form start -->
                <form method="POST" action="{{route('gudang.add')}}">
                  @csrf
                  <div class="card-body dark-mode">
                    <div class="form-group">
                      <label for="nama">Nama Gudang</label>
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="Input nama">
                    </div>
                    <div class="form-group">
                      <label for="kode">Kode Gudang</label>
                      <input type="text" class="form-control" id="kode" name="kode" placeholder="Input kode">
                    </div>
                    <div class="form-group">
                      <label for="ket1">Keterangan 1</label>
                      <input type="text" class="form-control" id="ket1" name="ket1" placeholder="Input keterangan 1">
                    </div>
                    <div class="form-group">
                      <label for="ket2">Keterangan 2</label>
                      <input type="text" class="form-control" id="ket2" name="ket2" placeholder="Input keterangan 2">
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
              <h4 class="modal-title">Edit Gudang</h4>
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
                      <label for="nama2">Nama Gudang</label>
                      <input type="text" class="form-control" id="nama2" name="nama" placeholder="Input nama">
                    </div>
                    <div class="form-group">
                      <label for="kode2">Kode Gudang</label>
                      <input type="text" class="form-control" id="kode2" name="kode" placeholder="Input kode">
                    </div>
                    <div class="form-group">
                      <label for="ket12">Keterangan 1</label>
                      <input type="text" class="form-control" id="ket12" name="ket1" placeholder="Input keterangan 1">
                    </div>
                    <div class="form-group">
                      <label for="ket22">Keterangan 2</label>
                      <input type="text" class="form-control" id="ket22" name="ket2" placeholder="Input keterangan 2">
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
              <h4 class="modal-title">Hapus Gudang</h4>
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
                    <p>Konfirmasi hapus gudang.</p>
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
      url: "/master-gudang/"+id,
      type: "get",
    }).done(function(data) {
      $('#modal-edit').modal('show');
      $('#form-edit').attr("action", "/master-gudang/"+id+"/update");
      $('#nama2').val(data.nama);
      $('#kode2').val(data.kode);
      $('#ket12').val(data.ket1);
      $('#ket22').val(data.ket2);
    });
  }
  function del(id) {
    $.ajax({
      url: "/master-gudang/"+id,
      type: "get",
    }).done(function(data) {
      $('#modal-delete').modal('show');
      $('#form-delete').attr("action", "/master-gudang/"+id+"/delete");
    });
  }
</script>
@endsection