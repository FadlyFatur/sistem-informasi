@extends('layout.main')
@section('title','Sunting Acara')
@section('halaman','Acara/Kegiatan')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/editAcara.css') }}">
@endsection

@section('content')
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
            <div class="row">
              <div class="form-group col-12 mb-4">
                <label for="judul">Judul Kegiatan</label>
                <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukan Judul Acara/Kegiatan" autocomplete="off" required value="{{ old('judul') }}">
              </div>

              <div class="form-group col-12 mb-4">
                <label for="deskripsi">Deskripsi/Berita</label>
                <textarea class="form-control" name="deskripsi" id="deskripsi" required>{{ old('deskripsi') }}</textarea>
              </div>

              <div class="form-group col-12">
                <label for="image">Pilih Thumbnail/Foto Acara</label>
                <input type="file" class="form-control" name="image">
                <h6 class="p-2 mx-auto">*Max ukuran image/foto : 10 MB</h6>
              </div>

              <div class="form-group col mb-4">
              <div class="mx-auto button-submit">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
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
    CKEDITOR.replace( 'deskripsi', {
        language: 'fr',
        height : 500,
        
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