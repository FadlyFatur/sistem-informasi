@extends('layout.main')
@section('title','Data Warga RW 02')
@section('halaman','Data Warga RW02')


@section('css')
  <link rel="stylesheet" href="{{ URL::asset('css/crudWarga.css') }}">
@endsection

@section('content')

  <div class="container-fluid mt-5">
  <a href="#" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal2"><i class="fa fa-plus"></i> Data Warga</a> 
    <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="card-header">
              <h4>Warga RW.02 Pelita</h4>

                <form class="card-header-form" action="{{ route('crudWarga') }}" name="cari" method="GET">
                  <div class="input-group">
                    <input type="text" name="cari" id="cari" class="form-control" placeholder="cari...">
                    <div class="input-group-btn">
                    <button class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </form>
                
            </div>
          </div>
          @if ($message = Session::get('sukses'))
          <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>x</span>
              </button>
              {{ Session::get('sukses') }}
            </div>
          </div>
          @endif

          @if ($message = Session::get('gagal'))
          <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>x</span>
              </button>
              {{ Session::get('gagal') }}
            </div>
          </div>
          @endif
            <!-- table -->
            <table class="table table-md table-bordered table-striped table-hover">
            <a href="{{ route('exportWarga') }}" class="btn btn-success my-3" target="_blank">EXPORT EXCEL <i class='far fa-file-excel'></i></a>
              <thead>
                <tr style="color:black; text-align:center; font-size:13px;"> 
                  <th>NIK</th>
                  <th>Nama Lengkap</th>
                  <th>Jenis Kelamin</th>
                  <th>Alamat</th>
                  <th>RT</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              @foreach($wargas as $a)
                <tr class="text-center">
                  <td>{{ $a['nik'] }}</td>
                  <td>{{ $a['nama_lengkap'] }}</td>
                  <td class=>{{ $a['jenis_kelamin'] }}</td>
                  <td>{{ $a['alamat'] }}</td>
                  <td>{{ $a['rt'] }}</td>
                  @if ($a['status'] != 0)
                  <td><a href="{{route('aktifWarga',['id' => $a->id])}}"> <div class="badge badge-success">Aktif</div> </a> </td>
                  @else
                  <td><a href="{{route('aktifWarga',['id' => $a->id])}}"> <div class="badge badge-success">Non-Aktif</div> </a> </td>
                  @endif
                  <td>
                  <a href="#" type="button" class="btn btn-sm btn-outline-primary fa fa-edit" data-toggle="modal" data-target="#edit-{{$a['id']}}"></a>
                  <a href="{{route('deleteWarga',['id'=>$a->id])}}" class="btn btn-sm btn-outline-danger fa fa-trash">
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
      </div>
    </div>
    <div class="d-flex justify-content-center pag">
        {{ $wargas->links() }}
      </div>
  </div>
         
@endsection

@section('modal')
  <!-- Modal Edit-->
  @foreach ($wargas as $a)
    <div class="modal fade" id="edit-{{$a['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="m-2" method="post" action="{{route('updateWarga',['id' => $a->id])}}" enctype="multipart/form-data">
              <div class="modal-body">
              @csrf
    
          <div class="form-group">
            <label for="exampleFormControlInput2">Nomer Induk Kependudukan</label>
            <input type="text" name="nik" id="nik" class="form-control" placeholder="Masukan nik" autocomplete="off" value="{{$a['nik']}}" required>
          </div>


          <div class="form-group">
              <label for="exampleFormControlInput3">Nama Lengkap</label> 
              <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="Masukan nama lengkap" autocomplete="off" value="{{$a['nama_lengkap']}}" required>
          </div>

            <div class="form-group">
              <label for="exampleFormControlSelect1">Jenis Kelamin</label>
              <select class="form-control" name="jenis_kelamin"  id="exampleFormControlSelect1" value="{{$a['jenis_kelamin']}}" required>
                <option {{$a['jenis_kelamin'] == 'P' ? ' selected="selected" ' : '' }}>P</option>
                <option {{$a['jenis_kelamin'] == 'L' ? ' selected="selected" ' : '' }}>L</option>
              </select>
            </div> 

            <div class="form-group">
              <label for="exampleFormControlInput4">Tempat Lahir</label> 
              <input type="text"  name="tempat_lahir" class="form-control" id="exampleFormControlInput4" placeholder="Masukan tempat lahir" value="{{$a['tempat_lahir']}}" required>
            </div>

            <div class="form-group">
              <label for="exampleFormControlInput5">Tanggal Lahir</label> 
              <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" placeholder="Masukan tanggal lahir" autocomplete="off" value="{{$a['tanggal_lahir']}}" required>
            </div>

            <div class="form-group">
              <label>Alamat</label>
              <textarea class="form-control" name="alamat" id="alamat" placeholder="Masukan alamat" row="10" style="height: 100px;" required>{{$a['alamat']}}</textarea>
            </div>

            <div class="form-group">
              <label for="exampleFormControlInput6">Kelurahan</label> 
              <input type="text" name="kelurahan" id="kelurahan" class="form-control" placeholder="Kelurahan" autocomplete="off" value="{{$a['kelurahan']}}" required>
            </div>

            <div class="form-group">
              <label for="exampleFormControlInput7">Kecamatan</label> 
              <input type="text" name="kecamatan" id="kecamatan" class="form-control" placeholder="Kecamatan" autocomplete="off" value="{{$a['kecamatan']}}" required>
            </div>

            <div class="form-group">
              <label for="exampleFormControlInput7">Kota</label> 
              <input type="text" name="kota" id="kota" class="form-control" placeholder="Masukan kota" autocomplete="off" value="{{$a['kota']}}" required>
            </div>

            <div class="form-group">
              <label for="exampleFormControlSelect1">Status</label>
              <select class="form-control" id="exampleFormControlSelect1" name="status" name="status">
                <option {{$a['status'] == '1' ? ' selected="selected" ' : '' }}>Aktif</option>
                <option {{$a['status'] == '0' ? ' selected="selected" ' : '' }}>Non Aktif</option>
              </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect2">RT</label>
                <select class="form-control" id="exampleFormControlSelect2" name="rt">
                  <option {{$a['rt'] == '1' ? ' selected="selected" ' : '' }}>1</option>
                  <option {{$a['rt'] == '2' ? ' selected="selected" ' : '' }}>2</option> 
                  <option {{$a['rt'] == '3' ? ' selected="selected" ' : '' }}>3</option>
                  <option {{$a['rt'] == '4' ? ' selected="selected" ' : '' }}>4</option>
                  <option {{$a['rt'] == '5' ? ' selected="selected" ' : '' }}>5</option>
                  <option {{$a['rt'] == '6' ? ' selected="selected" ' : '' }}>6</option>
                  <option {{$a['rt'] == '7' ? ' selected="selected" ' : '' }}>7</option> 
                  <option {{$a['rt'] == '8' ? ' selected="selected" ' : '' }}>8</option>
                  <option {{$a['rt'] == '9' ? ' selected="selected" ' : '' }}>9</option>
                  <option {{$a['rt'] == '10' ? ' selected="selected" ' : '' }}>10</option>
                  <option {{$a['rt'] == '11' ? ' selected="selected" ' : '' }}>11</option>
                  <option {{$a['rt'] == '12' ? ' selected="selected" ' : '' }}>12</option>
                </select>
            </div>

            <div class="form-group">
              <label for="exampleFormControlSelect3">Agama</label>
              <select class="form-control" id="exampleFormControlSelect3" name="agama">
                <option {{$a['agama_id'] == 'Islam' ? ' selected="selected" ' : '' }}>Islam</option>
                <option {{$a['agama_id'] == 'Khatolik' ? ' selected="selected" ' : '' }}>Khatolik</option> 
                <option {{$a['agama_id'] == 'Khatolik' ? ' selected="selected" ' : '' }}>Protestan</option> 
                <option {{$a['agama_id'] == 'Khatolik' ? ' selected="selected" ' : '' }}>Hindu</option> 
                <option {{$a['agama_id'] == 'Khatolik' ? ' selected="selected" ' : '' }}>Budhha</option> 
                <option {{$a['agama_id'] == 'Hindu' ? ' selected="selected" ' : '' }}>Khonghucu</option>
              </select>
            </div>

            <div class="form-group">
              <label for="exampleFormControlSelect4">Pekerjaan</label>
              <select class="form-control" id="exampleFormControlSelect4" name="kerja">
                @foreach ($kerja as $k)
                  <option {{$k['nama'] == $a['kerja'] ? ' selected="selected" ' : '' }}>{{$k->nama}}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="exampleFormControlSelect3">Status Perwinan</label>
              <select class="form-control" id="exampleFormControlSelect3" name="kawin">
                <option {{$a['perkawinan'] == 'Menikah' ? ' selected="selected" ' : '' }}>Menikah</option>
                <option {{$a['perkawinan'] == 'Belum Menikah' ? ' selected="selected" ' : '' }}>Belum Menikah</option> 
              </select>
            </div>
          
          </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
        </div>
      </div>
    </div>
  @endforeach


  <!-- Modal Tambah-->
  <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
          <form action="{{route('tambahWarga')}}" method="post">
          @csrf
          <div class="form-group">
            <label for="exampleFormControlInput2">Nomer Induk Kependudukan</label>
            <input type="nik" name="nik" class="form-control" id="exampleFormControlInput2" placeholder="NIK" required>
          </div>

          <div class="form-group">
              <label for="exampleFormControlInput3">Nama</label> 
              <input type="nama_lengkap" name="nama_lengkap" class="form-control" id="exampleFormControlInput3"  placeholder="Nama Lengkap" required>
          </div>
          
     
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                <select class="form-control" name="jenis_kelamin" id="exampleFormControlSelect1" required>
                  <option>P</option>
                  <option>L</option>
                </select>
              </div> 
            </div>
            <div class="col">
              <div class="form-group">
                <label for="exampleFormControlInput4">Tempat Lahir</label> 
                <input type="tempat_lahir" name="tempat_lahir" class="form-control" id="exampleFormControlInput4" placeholder="tempat lahir" required>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="exampleFormControlInput5">Tanggal Lahir</label> 
                <input type="date" class="form-control" name="tanggal_lahir" id="exampleFormControlInput5"  placeholder="tanggal lahir" required>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="exampleFormControlInput6">Kelurahan</label> 
                <input type="kelurahan" name="kelurahan" class="form-control" id="exampleFormControlInput6"  placeholder="kelurahan" required>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="exampleFormControlInput7">Kecamatan</label> 
                <input type="kecamatan" name="kecamatan" class="form-control" id="exampleFormControlInput7"  placeholder="kecamatan" required>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="exampleFormControlInput7">Kota</label> 
                <input type="kota" name="kota" class="form-control" id="exampleFormControlInput7"  placeholder="kota" required>
              </div>
            </div>
          </div>

            <div class="form-group">
                <label for="exampleFormControlSelect2">RT</label>
                <select class="form-control" id="exampleFormControlSelect2" name="rt" required>
                  <option>1</option>
                  <option>2</option> 
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                  <option>6</option>
                  <option>7</option> 
                  <option>8</option>
                  <option>9</option>
                  <option>10</option>
                  <option>11</option>
                  <option>12</option>
                </select>
            </div>


            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="exampleFormControlSelect3">Agama</label>
                  <select class="form-control" id="exampleFormControlSelect3" name="agama" required>
                    <option>Islam</option>
                    <option>Khatolik</option> 
                    <option>Protestan</option> 
                    <option>Hindu</option>
                    <option>Buddha</option>
                  </select>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="exampleFormControlSelect3">Status Perwinan</label>
                  <select class="form-control" id="exampleFormControlSelect3" name="perkawinan" required>
                    <option>Menikah</option>
                    <option>Belum Menikah</option> 
                  </select>
                </div>
              </div>
            </div>
            

            <div class="form-group">
              <label for="exampleFormControlSelect4">Pekerjaan</label>
              <select class="form-control" id="exampleFormControlSelect4" name="kerja" required> 
                @foreach ($kerja as $k)
                <option>{{$k->nama}}</option>
                @endforeach
              </select>
            </div>

            

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
