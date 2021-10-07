@extends('layout.main')
@section('title','Sunting Acara')
@section('halaman','Acara/Kegiatan')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/editAcara.css') }}">
@endsection

@section('content')
  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible show fade">
    <div class="alert-body">
      <button class="close" data-dismiss="alert">
        <span>×</span>
      </button>
      <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
      </ul>
    </div>
    </div>
  @endif

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

  <div class="card acara-size">
    <div class="card-header">
      <h4>Manajemen Acara/Kegiatan</h4>
    </div>

    <!-- tambah acara  -->
    <div class="container-fluid p-1" id="myGroup">
      <a class="btn btn-primary m-3 " id="colapse1" data-toggle="collapse" href="#tambah" role="button" aria-expanded="false" aria-controls="collapseExample">
      <i class="fas fa-plus"></i> Tambah Acara/Kegiatan
      </a>

      <div class="collapse p-3" id="tambah" data-parent="#myGroup">
        <form class="m-2" method="post" action="{{route('post')}}" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul Kegiatan</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukan Judul Acara/Kegiatan" autocomplete="off" required>
              </div>
            </div>

            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi/Berita</label>
              <div class="col-sm-12 col-md-7">
              <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Masukan Deskripsi kegiatan atau acara" style="height: 300px;" required></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="image">Pilih Image</label>
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
  </div>

  <!-- tabel  -->
    <div class="card acara-size">
      <div class="card-header">
        <h4>Data Acara/Kegiatan</h4>
      </div>

      <div class="card-body">

        <div class="container p-3" style="color:black;">
          <div class="table-responsive">
            <p class="text-center" >Total Data Acara : <span id="total-record">{{$total_data}}</span></p>
            <table class="table" id="acr-tbl">
              <thead class="text-left">
                <tr>
                  <th>Judul</th>
                  <th>Penulis</th>
                  <th>Tanggal Ditulis</th>
                  <th>Publikasi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
    </div>
@endsection

@section('js')
  <script src="{{ asset('js/editAcara.js') }}"></script>
  <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

    <script>
    CKEDITOR.replace('deskripsi');
    $('.editors').each(function () {
          CKEDITOR.replace($(this).prop('id'));
    });

    $('#acr-tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route("getAcara") }}',
      columns: [
          {data: 'judul', name: 'judul'},
          {data: 'penulis_id', name: 'penulis', orderable: false, searchable: false},
          {data: 'created_at', name: 'tanggal', searchable: false},
          {data: 'status_edit', name: 'status'},
          {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });
    </script>
@endsection