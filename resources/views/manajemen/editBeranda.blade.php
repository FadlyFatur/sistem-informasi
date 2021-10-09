@extends('layout.main')
@section('title','Sunting Beranda')
@section('halaman','Sunting Tampilan Beranda')
@section('css')
<link rel="stylesheet" href="{{asset('css/editBeranda.css')}}">
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <h2 class="section-title">Pengelolaan Beranda</h2>
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

    <div class="accordion" id="accordionExample">
      <div class="container-fluid">
        <div id="headingOne">
            <a class="btn btn-primary btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              <i class="fas fa-plus"></i> Edit Kontak
            </a>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
        <div class="container mt-5">
          <form action="{{ route('updateBeranda') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-3 col-form-label">Kontak</label>
              <input type="Text" class="form-control" name="kontak" placeholder="Kontak" value="{{isset($data['kontak']) ? $data['kontak'] : Null}}">
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-3 col-form-label">Email</label>
              <input type="Email" class="form-control" name="email"  placeholder="Email" value="{{isset($data['email']) ? $data['email'] : Null}}">
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-3 col-form-label">Alamat</label>
              <input type="text" class="form-control" name="alamat" placeholder="Alamat Lengkap" value="{{isset($data['alamat']) ? $data['alamat'] : Null}}">
            </div>
            <div class="card-footer d-flex justify-content-center">       
              <button type="submit" class="btn btn-primary mr-1">Submit</button>
            </div>
          </form>
        </div>
        </div>
      </div>
      <hr>

      <div class="container-fluid">
        <div id="headingTwo">
            <a class="btn btn-primary btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              <i class="fas fa-plus"></i> Edit Visi & Misi
            </a>
        </div>

        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">

          <div class="card-body text-body">
          <form action="{{route ('updateMs')}}" method="POST">
          @csrf
          <div class="row">
            
            
            <div class="col">
            <h3>Visi</h3>
              <div class="form-group">
                <div class="col">
                <textarea class="form-control" name="visi" id="visi" placeholder="Masukan visi" style="height: 150px;"></textarea>
                </div>
              </div>
            </div>
            <div class="col">
              <h3>Misi</h3>
              <div class="form-group">
                <div class="col">
                <textarea class="form-control" name="misi" id="misi" placeholder="Masukan misi" style="height: 150px;"></textarea>
                </div>
              </div>
            </div>

          </div>
              <div class="mx-auto d-flex justify-content-center button-submit">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
          </form>
          </div>

        </div>

        
      </div>
      <hr>

      <div class="container-fluid">
        <div id="headingThree">
            <a class="btn btn-primary btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              <i class="fas fa-plus"></i> Thumbnail Beranda
            </a>
        </div>

        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">

          <div class="card-body text-body">
          <form action="{{route ('updateThumb')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">

            <div class="col thumb-input">
              <h3>Thumbnail</h3>
              <img id="prev" class="prev-img" src="{{ asset('assets/img/news/img03.jpg') }}" alt="my-image" />
              <input type='file' name="thumb" onchange="readURL(this);"/>
            </div>
          </div>
              <div class="mx-auto d-flex justify-content-center button-submit">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
          </form>
          </div>

        </div>  
      </div>
      <hr>

    </div>
  </div>
</div>  
@endsection
  
@section('modal')

@endsection

@section('js')
  <script src="{{asset('js/editBeranda.js')}}"></script>
  <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

  <script>
  CKEDITOR.replace('misi');
  CKEDITOR.replace('visi');

  function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#prev')
                  .attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
      }
  }
  </script>
@endsection