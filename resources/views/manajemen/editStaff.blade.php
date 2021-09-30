@extends('layout.main')
@section('title','Sunting Staff')
@section('halaman','Sunting Staff')
@section('css')
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/editStaff.css') }}">
@endsection

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
              <input type="number" name="no" id="no" class="form-control" placeholder="Masukan Nomer Pegawai" autocomplete="off">
            </div>
          </div>

          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan Nama Lengkap" autocomplete="on" required>
            </div>
          </div>

          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomer HP</label>
            <div class="col-sm-12 col-md-7">
              <input type="number" name="no_hp" id="no_hp" class="form-control" placeholder="Masukan Nomor telepon" autocomplete="off">
            </div>
          </div>

          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
            <div class="col-sm-12 col-md-7">
            <textarea class="form-control" name="alamat" id="alamat" placeholder="Masukan Alamat Lengkap" style="height: 150px;" required></textarea>
            </div>
          </div>

          <div class="form-group row mb-4">
            <label for="jabatan" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jabatan</label>
            <div class="col-sm-12 col-md-7">
              <select class="form-control" id="jabatan" name="jabatan" required> 
                <option value="" selected>Pilih...</option>
                @foreach ($jabatan as $j)
                <option value="{{$j->id}}">{{$j->njabatan}}</option>
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
        <h4>Staff RW 02</h4>

          <!-- pencarian  -->
          <form class="card-header-form" action="{{ route('staff') }}" name="cari" method="GET">
            <div class="input-group">
              <input type="text" name="cari" id="cari" class="form-control" placeholder="Cari staff...">
              <div class="input-group-btn">
              <button class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </form>

      </div>

    <div class="card-body">
      <!-- Table -->
      <table class="table table-md table-bordered table-striped table-hover" style="color:black">
        <thead>
          <tr style="color:black; text-align:center; font-size:13px;"> 
            <th>No Pegawai</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>No HP</th>
            <th>Alamat</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody class="text-center">
      @foreach($data as $a)
          <tr>
            <td>{{ $a['no_pegawai'] }}</td>
            <td>{{ $a['nama'] }}</td>
            <td>{{ $a->jabatan->njabatan }}</td>
            <td>{{ $a['no_hp'] }}</td>
            <td>{{ $a['alamat'] }}</td>
            @if ($a['status'] != 0)
              <td><a href="{{route('aktifStaff',['id' => $a->id])}}"> <div class="badge badge-success">Aktif</div> </a> </td>
            @else
            <td><a href="{{route('aktifStaff',['id' => $a->id])}}"> <div class="badge badge-success">Non-Aktif</div> </a> </td>
            @endif
            <td>
              <button data-toggle="modal" data-target="#edit-{{$a['id']}}" class="btn btn-sm btn-outline-danger"><i class="fa fa-edit"></i></button>
              <a href="{{route('deleteStaff',['id' => $a->id])}}" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
        @endforeach
      </tbody>

      </table>
    </div>
    <div class="d-flex justify-content-center pag">
      {{ $data->links() }}
    </div>
  </div>

</div>
@endsection

@section('modal')
 <!-- Modal Edit-->
 @foreach ($data as $a)
    <div class="modal fade" id="edit-{{$a['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="color:black;">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="m-2" method="post" action="{{route('updateStaff',['id' => $a->id])}}" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
  
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomer Pegawai</label>
              <div class="col-sm-12 col-md-7">
                <input type="number" name="no" id="no" class="form-control" placeholder="Masukan Nomer Pegawai" value="{{ $a['no_pegawai'] }}" autocomplete="off">
              </div>
            </div>

            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan Nama Lengkap" autocomplete="off" value="{{ $a['nama'] }}" required>
              </div>
            </div>

            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomer Telefon</label>
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
                  <option value="{{$j->id}}" {{$a->jabatan_id == $j->id ? ' selected="selected" ' : '' }}>{{$j->njabatan}}</option>
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

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Update!</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  @endforeach
@endsection