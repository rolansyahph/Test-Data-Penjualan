@extends('layouts.master')

@section('content')
<div class="modal fade" id="modal_add">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Form Tambah Penjualan</h4>
        </div>
        <form action="{{ url('data-penjualan') }}" method="POST" role="form">
            @csrf
            <div class="modal-body">
                <div class="box-body">
                    <div class="form-group">
                      <label for="kode_barang">Kode Barang</label>
                      <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Enter Kode Barang">
                    </div>

                    <div class="form-group">
                        <label for="jumlah_terjual">Jumlah Terjual</label>
                        <input type="text" class="form-control" name="jumlah_terjual" id="jumlah_terjual" placeholder="Enter Jumlah Terjual">
                      </div>

                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
      Data Penjualan Barang
    </h1>
    <ol class="breadcrumb">
      <li class="active">Data Penjualan Barang</li>
    </ol>
</section>
<section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Data</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <button type="button" class="btn btn-primary btn-sm add" style="margin-bottom: 10px">Tambah Penjualan</button>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Tanggal Trasaksi</th>
                <th>Jumlah Terjual</th>
              </tr>
              </thead>
              @if ($status == 200)
                    <tbody>
                        @php
                        $counter = 0;
                        @endphp
                        @foreach ($values as $item)
                            <tr>
                                <td style="width: 5%">{{ $counter += 1 }}</td>
                                <td>{{ $item['nama_barang'] }}</td>
                                <td>{{ $item['tanggal_transaksi'] }}</td>
                                <td>{{ $item['jumlah_terjual'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                <tbody></tbody>
                @endif
              <tfoot>
              <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jenis Barang</th>
                <th>Satuan</th>
              </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
@endsection


@section('javascript')
<script>
    $(document).ready(function() {
        $('.add').on('click', function() {
            $('#modal_add').modal('show');
        });
    })
</script>
@endsection
