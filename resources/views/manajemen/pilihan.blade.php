@extends('layout.main')
@section('title','Sunting Pilihan')
@section('halaman','Sunting Pilihan Form')
@section('css')
<link rel="stylesheet" href="{{asset('css/editBeranda.css')}}">
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <h2 class="section-title">Pengelolaan Pilihan</h2>
  </div>
  <div class="card-body">
  
    @if ($message = Session::get('sukses'))
        <div class="alert alert-success alert-dismissible show fade">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
            <span>×</span>
            </button>
            Data Berhasil Disimpan.
        </div>
        </div>
    @endif

    @if ($message = Session::get('gagal'))
        <div class="alert alert-danger alert-dismissible show fade">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
            <span>×</span>
            </button>
            Gagal disimpan.
        </div>
        </div>
    @endif

    <div class="accordion" id="accordionList">
      <div class="container-fluid">

        <div id="headingOne">
            <a class="btn btn-primary btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
              <i class="fas fa-plus"></i> Opsi Pekerjaan Warga
            </a>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionList">

          <div class="card-body">

            <div class="row">

              <div class="col-md-4">
                <form action="{{route('addKerja')}}" method="post">
                @csrf 
                  <div class="form-row align-items-center">
                    <div class="col-auto">
                      <label class="sr-only" for="inlineFormInput">Kerja</label>
                      <input type="text" name="nama" class="form-control mb-2" id="inlineFormInput" placeholder="Kerja">
                    </div>
                    <div class="col-auto">
                      <button type="submit" class="btn btn-primary mb-2">Tambah</button>
                    </div>
                  </div>
                </form>
                <hr>
                <table class="table text-body" id="kj-tbl">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Nama</th>
                      <th scope="col">Delete</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>

            </div>

          </div>

        </div>
      <hr>

        <div id="headingTwo">
            <a class="btn btn-primary btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseOne">
              <i class="fas fa-plus"></i> Opsi Jabatan Staff
            </a>
        </div>

        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionList">

          <div class="card-body">

            <div class="row">

              <div class="col-md-4">
                <form action="{{route('addJabatan')}}" method="post">
                @csrf 
                  <div class="form-row align-items-center">
                    <div class="col-auto">
                      <label class="sr-only" for="inlineFormInput">Jabatan</label>
                      <input type="text" name="nama" class="form-control mb-2" id="inlineFormInput" placeholder="Kerja">
                    </div>
                    <div class="col-auto">
                      <button type="submit" class="btn btn-primary mb-2">Tambah</button>
                    </div>
                  </div>
                </form>
                <hr>
                <table class="table text-body" id="jb-tbl">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Nama</th>
                      <th scope="col">Delete</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>

            </div>

          </div>

        </div>
      <hr>


    </div>
  </div>
</div>  
@endsection
  
@section('js')
<script>
  $('#kj-tbl').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("getKerja") }}',
    columns: [
        {data: 'nama', name: 'nama'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
  });

  $('#jb-tbl').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("getJabatan") }}',
    columns: [
        {data: 'nama', name: 'nama'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
  });
</script>
@endsection

