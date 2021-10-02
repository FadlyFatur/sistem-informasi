@extends('layout.main')
@section('title','Edit Acara')
@section('halaman','Edit Data Acara')

@section('content')
    <div class="container-fluid mt-5">
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
          <h4>Update Acara/Kegiatan</h4>
        </div>
    
        <!-- Edit acara  -->
        <div class="container-fluid p-1">
    
            <form class="m-2" method="post" action="{{route('updateAcara',['id' => $data->id])}}" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul Kegiatan</label>
                  <div class="col-sm-12 col-md-7">
                    <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukan Judul Acara/Kegiatan" autocomplete="off" value="{{$data->judul}}" required>
                    <p></p>
                  </div>
                </div>

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi Berita</label>
                  <div class="col-sm-12 col-md-7">
                  <textarea class="form-control editors" name="deskripsi" placeholder="Masukan Deskripsi Acara/Kegiatan" style="height: 300px;" required>{{$data->deskripsi}}</textarea>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="image">Pilih Image</label>
                  <div class="col-sm-12 col-md-7">
                    <input type="file" class="form-control" name="imageUpdate">
                  </div>
                  <h6 class="p-2 mx-auto">*Max ukuran image/foto : 5 MB</h6>
                </div>

                <div class="form-group row mb-4">
                    <div class="mx-auto button-submit">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
              </div>
            </form> 
          
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
    </script>
@endsection