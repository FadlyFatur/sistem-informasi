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
        <div id="headingThree">
            <a class="btn btn-primary btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              <i class="fas fa-plus"></i> Edit Pilihan Pekerjaan
            </a>
        </div>

        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">

          <div class="card-body">

            <div class="row">

              <div class="col">
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
              </div>
              <div class="col">
                <table class="table text-body">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Nama</th>
                      <th scope="col">Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($kerjas as $k)
                    <tr>
                      <td>{{$k->nama}}</td>
                      <td> <a href="{{route('deleteKerja',['id' => $k->id])}}" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a></td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>

            </div>

          </div>

        </div>

        
      </div>

      <hr>

      <div class="container-fluid">
        <div id="headingfour">
            <a class="btn btn-primary btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
              <i class="fas fa-plus"></i> Edit Visi & Misi
            </a>
        </div>

        <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordionExample">

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
  </script>
@endsection