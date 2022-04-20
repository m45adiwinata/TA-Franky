@extends('layouts.main')
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endsection
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pembelian Barang</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
              <li class="breadcrumb-item">Transaksi</li>
              <li class="breadcrumb-item active">Pembelian</li>
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
                <h3 class="card-title">Daftar Pembelian Barang</h3>
                <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus"></i> Tambah</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Barang</th>
                    <th>Suplier</th>
                    <th>Harga (Rp)</th>
                    <th>Kuantitas</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($pembelians as $key => $pembelian)
                    <tr>
                      <td>{{$pembelian->tanggal}}</td>
                      <td>{{$pembelian->nama_barang}}</td>
                      <td>{{$pembelian->nama_suplier}}</td>
                      <td>{{$pembelian->harga}}</td>
                      <td>{{$pembelian->kuantitas}}</td>
                      <td><button class="btn btn-primary" onclick="edit({{$pembelian->id}})">edit</button> / <button class="btn btn-danger" onclick="del({{$pembelian->id}})">delete</button></td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Tanggal</th>
                    <th>Barang</th>
                    <th>Suplier</th>
                    <th>Harga (Rp)</th>
                    <th>Kuantitas</th>
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
      <input type="hidden" id="session-0" value="{{session()->get('success')}}">
      <!-- /.container-fluid -->
      <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Pembelian Barang</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- general form elements -->
              <div class="card card-primary">
                <!-- form start -->
                <form method="POST" action="{{route('pembelian.add')}}">
                  @csrf
                  <div class="card-body dark-mode">
                    <div class="form-group">
                      <label>Tanggal</label>
                      <div class="input-group date" id="tanggal" data-target-input="nearest">
                        <input name="tanggal" type="text" class="form-control datetimepicker-input" data-target="#tanggal"/>
                        <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Kode Barang</label>
                      <select name="kode_barang" class="form-control select2bs4" style="width: 100%;">
                        @foreach($barangs as $barang)
                        <option value="{{$barang->kode}}">{{$barang->nama}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Kode Suplier</label>
                      <select name="id_suplier" class="form-control select2bs4" style="width: 100%;">
                        @foreach($supliers as $suplier)
                        <option value="{{$suplier->id}}">{{$suplier->nama}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="harga">Harga (Rp)</label>
                      <input type="number" class="form-control" id="harga" name="harga" placeholder="Input harga beli">
                    </div>
                    <div class="form-group">
                      <label for="kuantitas">Kuantitas</label>
                      <input type="number" class="form-control" id="kuantitas" name="kuantitas" placeholder="Input kuantitas" step="0.25">
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
              <h4 class="modal-title">Edit Pembelian Barang</h4>
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
                      <label>Tanggal</label>
                      <div class="input-group date" id="tanggal2" data-target-input="nearest">
                        <input name="tanggal" id="tgl2" type="text" class="form-control datetimepicker-input" data-target="#tanggal2"/>
                        <div class="input-group-append" data-target="#tanggal2" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Kode Barang</label>
                      <select name="kode_barang" id="kode_barang2" class="form-control select2bs4" style="width: 100%;">
                        @foreach($barangs as $barang)
                        <option value="{{$barang->kode}}">{{$barang->nama}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Kode Suplier</label>
                      <select name="id_suplier" id="id_suplier2" class="form-control select2bs4" style="width: 100%;">
                        @foreach($supliers as $suplier)
                        <option value="{{$suplier->id}}">{{$suplier->nama}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="harga2">Harga (Rp)</label>
                      <input type="number" class="form-control" id="harga2" name="harga" placeholder="Input harga beli">
                    </div>
                    <div class="form-group">
                      <label for="kuantitas2">Kuantitas</label>
                      <input type="number" class="form-control" id="kuantitas2" name="kuantitas" placeholder="Input kuantitas" step="0.25">
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
              <h4 class="modal-title">Hapus Pembelian</h4>
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
                    <p>Konfirmasi hapus pembelian. Jika data stok yang dibeli sudah berubah, 
                      penghapusan ini akan digagalkan.</p>
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
<!-- Select2 -->
<script src="{{asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('adminlte/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Page specific script -->
<script>
  $(document).keydown(function(event) { 
    if (event.keyCode == 27) { 
      $('.modal.fade').modal('hide');
    }
  });
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });

    //Date and time picker
    $('#tanggal').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss', locale:'id-ID',icons: { time: 'far fa-clock' } });
    $('#tanggal2').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss', locale:'id-ID',icons: { time: 'far fa-clock' } });

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

    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    if ($('#session-0').val()) {
      Toast.fire({
        icon: 'success',
        title: $('#session-0').val()
      });
    }
  });
  function edit(id) {
    $.ajax({
      url: "/pembelian/"+id,
      type: "get",
    }).done(function(data) {
      $('#modal-edit').modal('show');
      $('#form-edit').attr("action", "/pembelian/"+id+"/update");
      $('#tgl2').val(data.tanggal);
      $('#kode_barang2').val(data.kode_barang).trigger('change');
      $('#id_suplier2').val(data.id_suplier).trigger('change');
      $('#harga2').val(data.harga);
      $('#kuantitas2').val(data.kuantitas);
    });
  }
  function del(id) {
    $.ajax({
      url: "/pembelian/"+id,
      type: "get",
    }).done(function(data) {
      $('#modal-delete').modal('show');
      $('#form-delete').attr("action", "/pembelian/"+id+"/delete");
    });
  }
</script>
@endsection