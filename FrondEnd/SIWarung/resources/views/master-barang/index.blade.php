@extends('layouts.master')

@section('content')
<div class="modal fade" id="modal_add">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Form Tambah Data Barang</h4>
        </div>
        <form action="{{ url('data-barang') }}" method="POST" role="form">
            @csrf
            <div class="modal-body">
                <div class="box-body">
                    <div class="form-group">
                      <label for="nama_barang">Nama Barang</label>
                      <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Enter Nama Barang">
                    </div>
                    <div class="form-group">
                      <label for="jenis_barang">Jenis Barang</label>
                      <select class="form-control" name="jenis_barang" id="jenis_barang">
                        <option value="konsumsi">Konsumsi</option>
                        <option value="pembersih">Pembersih</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="text" class="form-control" name="stok" id="stok" placeholder="Enter Stok">
                    </div>
                    <div class="form-group">
                        <label for="satuan">Satuan</label>
                        <select class="form-control" name="satuan" id="satuan">
                            <option value="pcs">PCS</option>
                            <option value="galon">Galon</option>
                            <option value="liter">Liter</option>
                        </select>
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

<div class="modal fade" id="modal_edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Form Tambah Data Barang</h4>
        </div>
        <form action="{{ url('data-barang/update') }}" method="POST" role="form">
            @csrf
            <div class="modal-body">
                <div class="box-body">
                    <div class="form-group">
                      <label for="kode_barang">Kode Barang</label>
                      <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Enter Kode Barang" readonly>
                    </div>

                    <div class="form-group">
                      <label for="tanggal_update">Tanggal Update</label>
                      <input type="text" class="form-control" name="tanggal_update" id="tanggal_update" placeholder="Enter Kode Barang" readonly>
                    </div>

                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" id="nama_barangView" placeholder="Enter Nama Barang" readonly>
                    </div>

                    <div class="form-group">
                        <label for="satuan">satuan</label>
                        <input type="text" class="form-control" name="satuan" id="satuanView" placeholder="Enter satuan" readonly>
                    </div>

                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="text" class="form-control" name="stok" id="stokView" placeholder="Enter Stok">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="modal_delete" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Konfirmasi Hapus Data</h4>
            </div>

            <form action="{{ url('data-barang/delete') }}" method="POST">
                @csrf
                <input type="hidden" name="kode_barang" id="kode_barangDel">
                <div class="modal-body">
                    <div class="alert bg-danger text-white alert-styled-left alert-dismissible">
                        <span class="font-weight-semibold">Apakah Anda Yakin ingin Menghapus data ini</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background: rgb(38,39,44);color:white"
                        data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger change-nonaktif">Delete</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
      Data Barang
    </h1>
    <ol class="breadcrumb">
      <li class="active">Data Barang</li>
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
            <button type="button" class="btn btn-primary btn-sm add" style="margin-bottom: 10px">Tambah Data Barang</button>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jenis Barang</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Tanggal Update Barang</th>
                <th>Action</th>
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
                                <td>{{ $item['kode_barang'] }}</td>
                                <td>{{ $item['nama_barang'] }}</td>
                                <td>{{ $item['jenis_barang'] }}</td>
                                <td>{{ $item['satuan'] }}</td>
                                <td>{{ $item['stok'] }}</td>
                                <td>{{ $item['tanggal_update'] }}</td>
                                <td>
                                    <button type="button"
                                        class="btn btn-warning btn-icon btn-sm edit"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Update"
                                        id="{{ $item['kode_barang'] }}" namaBarang="{{ $item['nama_barang'] }}" jenisBarang="{{ $item['jenis_barang'] }}" satuan="{{ $item['satuan'] }}" stok="{{ $item['stok'] }}" tanggalUpdate="{{ $item['tanggal_update'] }}" style="margin:2px">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button data-id="{{ $item['kode_barang'] }}" type="button"
                                        class="btn btn-danger btn-icon delete btn-sm" style="margin:2px"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </button>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                <tbody></tbody>
                @endif
              <tfoot>
              <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jenis Barang</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Tanggal Update Barang</th>
                <th>Action</th>
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

        $('.table tbody').on('click', 'button.edit', function() {
            var id = $(this).attr('id');
            var namaBarang = $(this).attr('namaBarang');
            var jenisBarang = $(this).attr('jenisBarang');
            var satuan = $(this).attr('satuan');
            var stok = $(this).attr('stok');
            var tanggalUpdate = $(this).attr('tanggalUpdate');

          //  console.log("Kode Barang:", id);


            $('#kode_barang').val(id);
            $('#nama_barangView').val(namaBarang);
            $('#jenis_barangView').val(jenisBarang);
            $('#satuanView').val(satuan);
            $('#stokView').val(stok);
            $('#tanggal_update').val(tanggalUpdate);
            $('#modal_edit').modal('show')
        })

        $('.table tbody').on('click', 'button.delete', function() {
            var id = $(this).data('id'); // Menggunakan data-id untuk mendapatkan kode_barang

            console.log("Kode Barang:", id); // Mencetak nilai kode barang ke konsol
            $('#kode_barangDel').val(id);
            $('#modal_delete').modal('show');
        });

    })
</script>
@endsection
