@extends('layout.main')
@section('title','Data Warga')
@section('halaman','Data Warga')


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
              <h4>Daftar Warga</h4>

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
                  <th>Tempat/Tanggal Lahir</th>
                  <th>Jenis Kelamin</th>
                  <th>Alamat</th>
                  <th>RT/RW</th>
                  <th>Agama</th>
                  <th>Status Perkawinan</th>
                  <th>Pekerjaan</th>
                  <th>Aktivasi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              @foreach($wargas as $a)
                <tr class="text-center">
                  <td>{{ $a['nik'] }}</td>
                  <td>{{ $a['nama'] }}</td>
                  <td>{{ $a['tempat_lahir'] }}-{{ $a['tanggal_lahir'] }}</td>
                  <td class=>{{ $a['jk'] }}</td>
                  <td>{{ $a['alamat'] }}, {{ $a['kel'] }}, {{ $a['kec'] }}, {{ $a['kota'] }}</td>
                  <td>{{ $a['rt'] }}/{{ $a['rw'] }}</td>
                  <td>{{ $a['agama'] }}</td>
                  <td>{{ $a['kawin'] }}</td>
                  <td>{{ $a['kerja']['nama'] }}</td>
                  @if ($a['status'] != 0)
                  <td><a href="{{route('aktifWarga',['id' => $a->id])}}"> <div class="badge badge-success">Aktif</div> </a> </td>
                  @else
                  <td><a href="{{route('aktifWarga',['id' => $a->id])}}"> <div class="badge badge-success">Non-Aktif</div> </a> </td>
                  @endif
                  <td>
                    <a href="{{route('upWarga',['id'=>$a->id])}}" class="btn btn-sm btn-outline-info fa fa-edit"></a>
                    {{-- <a href="#" type="button" class="btn btn-sm btn-outline-primary fa fa-edit" data-toggle="modal" data-target="#edit-{{$a['id']}}"></a> --}}
                    <a href="{{route('deleteWarga',['id'=>$a->id])}}" class="btn btn-sm btn-outline-danger fa fa-trash"></a>
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
  <!-- Modal Tambah-->
  <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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

          <div class="form-row">
            <div class="form-group col">
                <label for="nik">Nomer Induk Kependudukan</label>
                <input type="text" name="nik" id="nik" class="form-control" autocomplete="off" autofocus required>
            </div>

            <div class="form-group col">
                <label for="nama">Nama Lengkap</label> 
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" autofocus autocomplete="off" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-2">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select class="form-control" name="jenis_kelamin"  id="jk" required>
                    <option>P</option>
                    <option>L</option>
                </select>
            </div> 

            <div class="form-group col-md-5">
                <label for="tempat_lahir">Tempat Lahir</label> 
                <input type="text"  name="tempat_lahir" class="form-control" id="tempat_lahir" autocomplete="on" required>
            </div>

            <div class="form-group col-md-5">
                <label for="tanggal_lahir">Tanggal Lahir</label> 
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
            </div>
        </div>
        <hr><br>

        <div class="form-row">
            <div class="form-group col">
                <label for="kelurahan">Kelurahan</label> 
                <input type="text" name="kelurahan" id="kelurahan" class="form-control" autocomplete="on" autofocus required>
            </div>

            <div class="form-group col">
                <label for="kecamatan">Kecamatan</label> 
                <input type="text" name="kecamatan" id="kecamatan" class="form-control" autocomplete="on" autofocus required>
            </div>

            <div class="form-group col">
                <label for="kota">Kota</label> 
                <input type="text" name="kota" id="kota" class="form-control" autocomplete="on" autofocus required>
            </div>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat" style="height: 50px;" required></textarea>
        </div>
        <hr><br>

        <div class="form-row">
            <div class="form-group col-md-1">
                <label for="rt">RT</label>
                <select class="form-control" id="rt" name="rt">
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

            <div class="form-group col-md-1">
                <label for="rw">RW</label>
                <select class="form-control" id="rw" name="rw">
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

            <div class="form-group col-md-3">
                <label for="agama">Agama</label>
                <select class="form-control" id="agama" name="agama">
                    <option>Islam</option>
                    <option>Khatolik</option> 
                    <option>Protestan</option> 
                    <option>Hindu</option> 
                    <option>Budhha</option> 
                    <option>Khonghucu</option>
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="kawin">Status Perkawinan</label>
                <select class="form-control" id="kawin" name="kawin">
                    <option>Menikah</option>
                    <option>Belum Menikah</option> 
                </select>
            </div>

            <div class="form-group col-md-4">
                <label for="kerja">Pekerjaan</label>
                <select class="form-control" id="kerja" name="kerja">
                    @foreach ($kerja as $k)
                    <option value={{ $k->id }}>{{$k->nama}}</option>
                    @endforeach
                </select>
            </div>
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
