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
@endsection
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Master Stok</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Stok</li>
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
                <h3 class="card-title">Rincian Stok Barang</h3>
                <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus"></i> Tambah</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Tgl Masuk</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Jumlah</th>
                    <th>Kd. Gudang</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($stoks as $stok)
                    <tr>
                      <td>{{$stok->kode_barang}}</td>
                      <td>{{$stok->barang->nama}}</td>
                      <td>{{$stok->tanggal_masuk}}</td>
                      <td>{{$stok->harga_beli}}</td>
                      <td>{{$stok->harga_jual}}</td>
                      <td>{{$stok->jml_stok}}</td>
                      <td>{{$stok->kode_gudang}}</td>
                      <td><button class="btn btn-primary" onclick="edit({{$stok->id}})">edit</button> / <button class="btn btn-danger" onclick="del({{$stok->id}})">delete</button></td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Tgl Masuk</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Jumlah</th>
                    <th>Kd. Gudang</th>
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
              <h4 class="modal-title">Tambah Stok Barang</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- general form elements -->
              <div class="card card-primary">
                <!-- form start -->
                <form method="POST" action="{{route('stok.add')}}">
                  @csrf
                  <div class="card-body dark-mode">
                    <div class="form-group">
                      <label>Kode Barang</label>
                      <select name="kode" class="form-control select2bs4" style="width: 100%;">
                        @foreach($barangs as $barang)
                        <option value="{{$barang->kode}}">{{$barang->nama}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Tanggal Beli</label>
                      <div class="input-group date" id="tanggal_beli" data-target-input="nearest">
                        <input name="tanggal_beli" type="text" class="form-control datetimepicker-input" data-target="#tanggal_beli"/>
                        <div class="input-group-append" data-target="#tanggal_beli" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Tanggal Masuk</label>
                      <div class="input-group date" id="tanggal_masuk" data-target-input="nearest">
                        <input name="tanggal_masuk" type="text" class="form-control datetimepicker-input" data-target="#tanggal_masuk"/>
                        <div class="input-group-append" data-target="#tanggal_masuk" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="harga_beli">Harga Beli (Rp)</label>
                      <input type="number" class="form-control" id="harga_beli" name="harga_beli" placeholder="Input harga beli">
                    </div>
                    <div class="form-group">
                      <label for="harga_jual">Harga Jual (Rp)</label>
                      <input type="number" class="form-control" id="harga_jual" name="harga_jual" placeholder="Input harga jual">
                    </div>
                    <div class="form-group">
                      <label for="jml_stok">Jumlah Opname</label>
                      <input type="number" class="form-control" id="jml_stok" name="jml_stok" placeholder="Input jumlah barang opname">
                    </div>
                    <div class="form-group">
                      <label>Kode Gudang</label>
                      <select name="kode_gudang" class="form-control select2bs4" style="width: 100%;">
                        @foreach($gudangs as $gudang)
                        @if($gudang->kode == 'PST')
                        <option value="{{$gudang->kode}}" selected="selected">{{$gudang->kode}} | {{$gudang->nama}}</option>
                        @else
                        <option value="{{$gudang->kode}}">{{$gudang->kode}} | {{$gudang->nama}}</option>
                        @endif
                        @endforeach
                      </select>
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
              <h4 class="modal-title">Edit Stok Barang</h4>
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
                      <label>Kode Barang</label>
                      <select name="kode" id="kode_barang_2" class="form-control select2bs4" style="width: 100%;">
                        @foreach($barangs as $barang)
                        <option value="{{$barang->kode}}">{{$barang->nama}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Tanggal Beli</label>
                      <div class="input-group date" id="tanggal_beli_2" data-target-input="nearest">
                        <input name="tanggal_beli" id="tb2" type="text" class="form-control datetimepicker-input" data-target="#tanggal_beli_2"/>
                        <div class="input-group-append" data-target="#tanggal_beli_2" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Tanggal Masuk</label>
                      <div class="input-group date" id="tanggal_masuk_2" data-target-input="nearest">
                        <input name="tanggal_masuk" id="tm2" type="text" class="form-control datetimepicker-input" data-target="#tanggal_masuk_2"/>
                        <div class="input-group-append" data-target="#tanggal_masuk_2" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="harga_beli_2">Harga Beli (Rp)</label>
                      <input type="number" class="form-control" id="harga_beli_2" name="harga_beli" placeholder="Input harga beli">
                    </div>
                    <div class="form-group">
                      <label for="harga_jual">Harga Jual (Rp)</label>
                      <input type="number" class="form-control" id="harga_jual_2" name="harga_jual" placeholder="Input harga jual">
                    </div>
                    <div class="form-group">
                      <label for="jml_stok">Jumlah Opname</label>
                      <input type="number" class="form-control" id="jml_stok_2" name="jml_stok" placeholder="Input jumlah barang opname">
                    </div>
                    <div class="form-group">
                      <label>Kode Gudang</label>
                      <select name="kode_gudang" id="kode_gudang_2" class="form-control select2bs4" style="width: 100%;">
                        @foreach($gudangs as $gudang)
                        <option value="{{$gudang->kode}}">{{$gudang->kode}} | {{$gudang->nama}}</option>
                        @endforeach
                      </select>
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
              <h4 class="modal-title">Hapus Barang</h4>
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
                    <p>Konfirmasi hapus stok barang.</p>
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
<!-- Select2 -->
<script src="{{asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('adminlte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
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
    //Date and time picker
    $('#tanggal_beli').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss', locale:'id-ID',icons: { time: 'far fa-clock' } });
    $('#tanggal_masuk').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss', locale:'id-ID',icons: { time: 'far fa-clock' } });
    $('#tanggal_beli_2').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss', locale:'id-ID',icons: { time: 'far fa-clock' } });
    $('#tanggal_masuk_2').datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss', locale:'id-ID',icons: { time: 'far fa-clock' } });
  });
  function edit(id) {
    $.ajax({
      url: "/master-stok-barang/"+id,
      type: "get",
    }).done(function(data) {
      $('#modal-edit').modal('show');
      $('#form-edit').attr("action", "/master-stok-barang/"+id+"/update");
      $('#kode_barang_2').val(data.kode_barang).trigger('change');
      $('#tb2').val(data.tanggal_beli);
      $('#tm2').val(data.tanggal_masuk);
      $('#harga_beli_2').val(data.harga_beli);
      $('#harga_jual_2').val(data.harga_jual);
      $('#jml_stok_2').val(data.jml_stok);
      $('#kode_gudang_2').val(data.kode_gudang).trigger('change');
    });
  }
  function del(id) {
    $.ajax({
      url: "/api/master-stok-barang/"+id,
      type: "get",
    }).done(function(data) {
      $('#modal-delete').modal('show');
      $('#form-delete').attr("action", "/master-stok-barang/"+id+"/delete");
    });
  }
</script>
@endsection