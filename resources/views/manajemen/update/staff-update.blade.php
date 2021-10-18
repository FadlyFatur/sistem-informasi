@extends('layout.main')
@section('title','Edit Staff')
@section('halaman','Edit Data Staff')

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
          <h4>Update staff</h4>
        </div>
    
        <!-- Edit staff  -->
        <div class="container-fluid p-1">
    
            <form class="m-2" method="post" action="{{route('updateStaff',['id' => $a->id])}}" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomer Pegawai</label>
                    <div class="col-sm-12 col-md-7">
                      <input type="number" name="no" id="no" class="form-control" placeholder="Masukan Nomer Pegawai" value="{{ $a['id_pegawai'] }}" autocomplete="off">
                    </div>
                  </div>
    
                  <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama</label>
                    <div class="col-sm-12 col-md-7">
                      <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan Nama Lengkap" autocomplete="off" value="{{ $a['nama'] }}" required>
                    </div>
                  </div>
    
                  <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomer Telepon</label>
                    <div class="col-sm-12 col-md-7">
                      <input type="number" name="no_hp" id="no_hp" class="form-control" placeholder="Masukan Nomor telepon" value="{{ $a['no_hp'] }}" autocomplete="off">
                    </div>
                  </div>
    
                  <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
                    <div class="col-sm-12 col-md-7">
                    <textarea class="form-control" name="alamat" id="alamat" placeholder="Masukan Alamat Lengkap" style="height: 50px;" required>{{ $a['alamat'] }}</textarea>
                    </div>
                  </div>
    
                  <div class="form-group row mb-4">
                    <label for="jabatan" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jabatan</label>
                    <div class="col-sm-12 col-md-7">
                      <select class="form-control" id="jabatan" name="jabatan" required> 
                        @foreach ($jabatan as $j)
                        <option value="{{$j->id}}" {{$a->jabatan_id == $j->id ? ' selected="selected" ' : '' }}>
                            {{$j->nama}}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
    
                  <div class="form-group row">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="image">Foto pegawai</label>
                    <div class="col-sm-12 col-md-7">
                      <input type="file" class="form-control" name="imageUpdate">
                    </div>
                    <h6 class="p-2 mx-auto">*Max ukuran image/foto : 5 MB</h6>
                  </div>
                </div>
                <div class="form-group row mb-4">
                    <div class="mx-auto button-submit">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form> 
        </div>
    </div>
</div>
@endsection