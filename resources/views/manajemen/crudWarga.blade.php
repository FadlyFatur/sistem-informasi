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
