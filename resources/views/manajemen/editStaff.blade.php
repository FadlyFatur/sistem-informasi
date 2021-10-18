@extends('layout.main')
@section('title','Sunting Staff')
@section('halaman','Sunting Staff')
@section('css')
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/editStaff.css') }}">
@endsection

@section('content')
<div class="container-fluid mt-5">

@if ($message = Session::get('sukses'))
<div class="alert alert-success alert-dismissible show fade">
  <div class="alert-body">
    <button class="close" data-dismiss="alert">
      <span>×</span>
    </button>
    {{ Session::get('sukses') }}
  </div>
</div>
@endif

@if ($message = Session::get('gagal'))
<div class="alert alert-danger alert-dismissible show fade">
  <div class="alert-body">
    <button class="close" data-dismiss="alert">
      <span>×</span>
    </button>
    {{ Session::get('gagal') }}
  </div>
</div>
@endif

@if($errors->any())
  <div class="alert alert-danger alert-dismissible show fade">
    <div class="alert-body">
      <button class="close" data-dismiss="alert">
        <span>x</span>
      </button>
      {!! implode('', $errors->all('<div>:message</div>')) !!}
    </div>
  </div>
@endif

  <div class="card">
    <div class="card-header">
      <a class="btn btn-primary m-3 " id="colapse1" data-toggle="collapse" href="#tambah" role="button" aria-expanded="false" aria-controls="collapseExample">
        <i class="fas fa-plus"></i> Staff
      </a>
    </div>

    <!-- tambah staff  -->
    <div class="collapse p-3" id="tambah">
      <form class="m-2" method="post" action="{{route('tambahStaff')}}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomer Pegawai</label>
            <div class="col-sm-12 col-md-7">
              <input type="number" name="no" id="no" class="form-control" placeholder="Masukan Nomer Pegawai" autocomplete="off" value="{{ old('no') }}">
            </div>
          </div>

          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan Nama Lengkap" autocomplete="on" value="{{ old('nama') }}" required>
            </div>
          </div>

          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomer HP</label>
            <div class="col-sm-12 col-md-7">
              <input type="number" name="no_hp" id="no_hp" class="form-control" placeholder="Masukan Nomor telepon" autocomplete="off" value="{{ old('no_hp') }}">
            </div>
          </div>

          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
            <div class="col-sm-12 col-md-7">
            <textarea class="form-control" name="alamat" id="alamat" placeholder="Masukan Alamat Lengkap" style="height: 150px;" required>{{ old('alamat') }}</textarea>
            </div>
          </div>

          <div class="form-group row mb-4">
            <label for="jabatan" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jabatan</label>
            <div class="col-sm-12 col-md-7">
              <select class="form-control" id="jabatan" name="jabatan" required> 
                <option value="" selected>Pilih...</option>
                @foreach ($jabatan as $j)
                <option value="{{$j->id}}">{{$j->nama}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="image">Foto pegawai</label>
            <div class="col-sm-12 col-md-7">
              <input type="file" class="form-control" name="image">
            </div>
            <h6 class="p-2 mx-auto">*Max ukuran image/foto : 5 MB</h6>
          </div>
          
          
            <div class="form-group row mb-4">
            <div class="mx-auto button-submit">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </div>
      </form> 
    </div>
      
    
  </div>

  
  <div class="card p-3">
      <div class="card-header">
        <h4>Daftar Staff/Pengurus</h4>
      </div>

    <div class="card-body">
      <!-- Table -->
      <table class="table-responsive" style="color:black;" id="stf-tbl">
        <p class="text-center" style="color:black;">Total Data Staff : <span id="total-record">{{$total_data}}</span></p>
        <thead>
          <tr style="color:black; text-align:center; font-size:13px;"> 
            <th>No Pegawai</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>No HP</th>
            <th>Alamat</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="text-center"></tbody>
      </table>
    </div>

  </div>

</div>
@endsection

@section('js')
<script>
  $('#stf-tbl').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("getStaff") }}',
    columns: [
        {data: 'id_pegawai', name: 'judul'},
        {data: 'nama', name: 'penulis', orderable: false, searchable: false},
        {data: 'jabatan_id', name: 'penulis', orderable: false, searchable: false},
        {data: 'no_hp', name: 'penulis', orderable: false, searchable: false},
        {data: 'alamat', name: 'penulis', orderable: false, searchable: false},
        {data: 'status_edit', name: 'status'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
  });
  </script>
@endsection