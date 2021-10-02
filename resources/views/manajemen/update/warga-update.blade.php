@extends('layout.main')
@section('title','Edit Warga')
@section('halaman','Edit Data Warga')

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
      <h4>Update Warga</h4>
    </div>

    <!-- Edit warga  -->
    <div class="container-fluid p-1">

        <form class="m-2" method="post" action="{{route('updateWarga',['id' => $data->id])}}" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <div class="form-row">
                <div class="form-group col">
                    <label for="nik">Nomer Induk Kependudukan</label>
                    <input type="text" name="nik" id="nik" class="form-control" autocomplete="off" autofocus value="{{$data->nik}}" required>
                </div>
    
                <div class="form-group col">
                    <label for="nama">Nama Lengkap</label> 
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" autofocus autocomplete="off" value="{{$data->nama}}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="form-control" name="jenis_kelamin"  id="jk" value="{{$data->jk}}" required>
                        <option {{$data->jk}} == 'P' ? ' selected="selected" ' : '' }}>P</option>
                        <option {{$data->jk}} == 'L' ? ' selected="selected" ' : '' }}>L</option>
                    </select>
                </div> 
    
                <div class="form-group col-md-5">
                    <label for="tempat_lahir">Tempat Lahir</label> 
                    <input type="text"  name="tempat_lahir" class="form-control" id="tempat_lahir" autocomplete="on" value="{{$data->tempat_lahir}}" required>
                </div>
    
                <div class="form-group col-md-5">
                    <label for="tanggal_lahir">Tanggal Lahir</label> 
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{$data->tanggal_lahir}}" required>
                </div>
            </div>
            <hr><br>

            <div class="form-row">
                <div class="form-group col">
                    <label for="kelurahan">Kelurahan</label> 
                    <input type="text" name="kelurahan" id="kelurahan" class="form-control" autocomplete="off" value="{{$data->kel}}" required>
                </div>
    
                <div class="form-group col">
                    <label for="kecamatan">Kecamatan</label> 
                    <input type="text" name="kecamatan" id="kecamatan" class="form-control" autocomplete="off" value="{{$data->kec}}" required>
                </div>
    
                <div class="form-group col">
                    <label for="kota">Kota</label> 
                    <input type="text" name="kota" id="kota" class="form-control" autocomplete="off" value="{{$data->kota}}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat" id="alamat" row="10" style="height: 100px;" required>{{$data->alamat}}</textarea>
            </div>
            <hr><br>

            <div class="form-row">
                <div class="form-group col-md-1">
                    <label for="rt">RT</label>
                    <select class="form-control" id="rt" name="rt">
                        <option {{$data->rt == '1' ? ' selected="selected" ' : '' }}>1</option>
                        <option {{$data->rt == '2' ? ' selected="selected" ' : '' }}>2</option> 
                        <option {{$data->rt == '3' ? ' selected="selected" ' : '' }}>3</option>
                        <option {{$data->rt == '4' ? ' selected="selected" ' : '' }}>4</option>
                        <option {{$data->rt == '5' ? ' selected="selected" ' : '' }}>5</option>
                        <option {{$data->rt == '6' ? ' selected="selected" ' : '' }}>6</option>
                        <option {{$data->rt == '7' ? ' selected="selected" ' : '' }}>7</option> 
                        <option {{$data->rt == '8' ? ' selected="selected" ' : '' }}>8</option>
                        <option {{$data->rt == '9' ? ' selected="selected" ' : '' }}>9</option>
                        <option {{$data->rt == '10' ? ' selected="selected" ' : '' }}>10</option>
                        <option {{$data->rt == '11' ? ' selected="selected" ' : '' }}>11</option>
                        <option {{$data->rt == '12' ? ' selected="selected" ' : '' }}>12</option>
                    </select>
                </div>

                <div class="form-group col-md-1">
                    <label for="rw">RW</label>
                    <select class="form-control" id="rw" name="rw">
                        <option {{$data->rw == '1' ? ' selected="selected" ' : '' }}>1</option>
                        <option {{$data->rw == '2' ? ' selected="selected" ' : '' }}>2</option> 
                        <option {{$data->rw == '3' ? ' selected="selected" ' : '' }}>3</option>
                        <option {{$data->rw == '4' ? ' selected="selected" ' : '' }}>4</option>
                        <option {{$data->rw == '5' ? ' selected="selected" ' : '' }}>5</option>
                        <option {{$data->rw == '6' ? ' selected="selected" ' : '' }}>6</option>
                        <option {{$data->rw == '7' ? ' selected="selected" ' : '' }}>7</option> 
                        <option {{$data->rw == '8' ? ' selected="selected" ' : '' }}>8</option>
                        <option {{$data->rw == '9' ? ' selected="selected" ' : '' }}>9</option>
                        <option {{$data->rw == '10' ? ' selected="selected" ' : '' }}>10</option>
                        <option {{$data->rw == '11' ? ' selected="selected" ' : '' }}>11</option>
                        <option {{$data->rw == '12' ? ' selected="selected" ' : '' }}>12</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="agama">Agama</label>
                    <select class="form-control" id="agama" name="agama">
                        <option {{$data->agama_id == 'Islam' ? ' selected="selected" ' : '' }}>Islam</option>
                        <option {{$data->agama_id == 'Khatolik' ? ' selected="selected" ' : '' }}>Khatolik</option> 
                        <option {{$data->agama_id == 'Khatolik' ? ' selected="selected" ' : '' }}>Protestan</option> 
                        <option {{$data->agama_id == 'Khatolik' ? ' selected="selected" ' : '' }}>Hindu</option> 
                        <option {{$data->agama_id == 'Khatolik' ? ' selected="selected" ' : '' }}>Budhha</option> 
                        <option {{$data->agama_id == 'Hindu' ? ' selected="selected" ' : '' }}>Khonghucu</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="kawin">Status Perkawinan</label>
                    <select class="form-control" id="kawin" name="kawin">
                        <option {{$data->kawin == 'Menikah' ? ' selected="selected" ' : '' }}>Menikah</option>
                        <option {{$data->kawin == 'Belum Menikah' ? ' selected="selected" ' : '' }}>Belum Menikah</option> 
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="kerja">Pekerjaan</label>
                    <select class="form-control" id="kerja" name="kerja">
                        @foreach ($kerja as $k)
                        <option {{$k->id == $data->kerja_id ? ' selected="selected" ' : '' }} value={{ $k->id }}>{{$k->nama}}</option>
                        @endforeach
                    </select>
                </div>
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