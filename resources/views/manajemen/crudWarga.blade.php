@extends('layout.main')
@section('title','Data Warga')
@section('halaman','Data Warga')

@section('css')
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
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
            <div class="alert alert-danger alert-dismissible show fade">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>x</span>
                </button>
                {{ Session::get('gagal') }}
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

            <!-- table -->
            <table class="table table-md table-bordered table-striped table-hover" id="warga-tbl" cellSpacing="0" width="100%">
              <a href="{{ route('exportWarga') }}" class="btn btn-success my-3">Export Excel <i class='far fa-file-excel'></i></a>
              <thead>
                <tr style="color:black; text-align:center; font-size:13px;"> 
                  <th data-toggle="tooltip" data-placement="top" title="NIK tidak akan dibagikan umum">NIK</th>
                  <th>Nama</th>
                  <th>TTL</th>
                  <th>Jenis Kelamin</th>
                  <th>Alamat</th>
                  <th>RT/RW</th>
                  <th>Agama</th>
                  <th>Perkawinan</th>
                  <th>Pekerjaan</th>
                  <th data-toggle="tooltip" data-placement="top" title="Data nonaktif tidak akan dimuculkan untuk umum">Aktivasi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody class="text-center"></tbody>
            </table>
      </div>
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
                <input type="number" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" autocomplete="off" value="{{ old('nik') }}" autofocus required>
                @error('nik')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col">
                <label for="nama">Nama Lengkap</label> 
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" autofocus autocomplete="off" required>
                @error('nama_lengkap')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-2">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select class="form-control" name="jenis_kelamin" id="jk" required>
                    <option>P</option>
                    <option>L</option>
                </select>
                @error('jenis_kelamin')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> 

            <div class="form-group col-md-5">
                <label for="tempat_lahir">Tempat Lahir</label> 
                <input type="text"  name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" autocomplete="on" value="{{ old('tempat_lahir') }}" required>
                @error('tempat_lahir')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-5">
                <label for="tanggal_lahir">Tanggal Lahir</label> 
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required value="{{ old('tanggal_lahir') }}">
            </div>
            @error('tanggal_lahir')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <hr><br>

        <div class="form-row">
            <div class="form-group col">
                <label for="kelurahan">Kelurahan</label> 
                <input type="text" name="kelurahan" id="kelurahan" class="form-control @error('kelurahan') is-invalid @enderror" autocomplete="on" autofocus value="{{ old('kelurahan') }}" required>
                @error('kelurahan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col">
                <label for="kecamatan">Kecamatan</label> 
                <input type="text" name="kecamatan"  id="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror" autocomplete="on" autofocus value="{{ old('kecamatan') }}" required>
                @error('kecamatan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col">
                <label for="kota">Kota</label> 
                <input type="text" name="kota" id="kota" class="form-control @error('kota') is-invalid @enderror" autocomplete="on" autofocus value="{{ old('kota') }}" required>
            </div>
            @error('kota')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" style="height: 50px;" required>{{ old('alamat') }}</textarea>
            @error('alamat')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <hr><br>

        <div class="form-row">
            <div class="form-group col-md-2">
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

            <div class="form-group col-md-2">
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

            <div class="form-group col-md-2">
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

            <div class="form-group col-md-3">
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

@section('js')
  
  <script>
    $('#warga-tbl').DataTable({
      pageLength: 25,
      processing: true,
      serverSide: true,
      ajax: '{{ route("getWarga") }}',
      columns: [
          {data: 'nik', name: 'NIK'},
          {data: 'nama', name: 'nama'},
          {data: 'TTL', name: 'Tempat/Tanggal Lahir'},
          {data: 'jk', name: 'Jenis Kelamin '},
          {data: 'alamat_lengkap', name: 'Alamat'},
          {data: 'rt/rw', name: 'RT/RW'},
          {data: 'agama', name: 'Agama'},
          {data: 'kerja_id', name: 'Kerja'},
          {data: 'kawin', name: 'Perkawinan'},
          {data: 'status_edit', name: 'Status', orderable: false, searchable: false},
          {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });
  </script>
@endsection