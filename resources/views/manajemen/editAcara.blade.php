@extends('layout.main')
@section('title','Sunting Acara')
@section('halaman','Acara/Kegiatan')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/editAcara.css') }}">
@endsection

@section('content')
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
      <h4>Manajemen Acara/Kegiatan</h4>
    </div>

    <!-- tambah acara  -->
    <div class="container-fluid p-1" id="myGroup">
      <a class="btn btn-primary m-3 " id="colapse1" data-toggle="collapse" href="#tambah" role="button" aria-expanded="false" aria-controls="collapseExample">
      <i class="fas fa-plus"></i> Tambah Acara/Kegiatan
      </a>

      <div class="collapse p-3" id="tambah" data-parent="#myGroup">
        <form class="m-2" method="post" action="{{route('post')}}" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul Kegiatan</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukan Judul Acara/Kegiatan" autocomplete="off" required>
              </div>
            </div>

            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi/Berita</label>
              <div class="col-sm-12 col-md-7">
              <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Masukan Deskripsi kegiatan atau acara" style="height: 300px;" required></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="image">Pilih Image</label>
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
  </div>

  <!-- tabel  -->
    <div class="card acara-size">
      <div class="card-header">
        <h4>Data Acara/Kegiatan</h4>
      </div>

      <div class="card-body">

        <div class="container p-3" style="color:black;">
          <div class="row justify-content-center">
              <div class="col-12 col-md-10 col-lg-8">
                  <form class="card card-sm" action="{{route('editAcara')}}" method="get">
                      <div class="card-body row no-gutters align-items-center">
                          <div class="col-auto">
                              <i class="fas fa-search h4 text-body"></i>
                          </div>
                          <!--end of col-->
                          <div class="col">
                              <input class="form-control form-control-lg form-control-borderless" type="search" placeholder="Cari berdasarkan judul..." name="cari">
                          </div>
                          <!--end of col-->
                          <div class="col-auto">
                              <button class="btn btn-lg btn-primary" type="submit">Search</button>
                          </div>
                          <!--end of col-->
                      </div>
                  </form>
              </div>
              <!--end of col-->
          </div>

          <div class="table-responsive">
          <p class="text-center" >Total Data Acara : <span id="total-record">{{$total_data}}</span></p>
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>Judul</th>
                  <th class="text-center">Tanggal</th>
                  <th class="text-center">Publikasi</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
              @foreach($data as $a)
                <tr>
                  <td>{{ $a['judul'] }}</td>
                  <td class="text-center">{{ date('m/d/Y',strtotime($a['created_at'])) }}</td>
                  @if ($a['status'] != 0)
                  <td class="text-center"><a href="{{route('aktifAcara',['id' => $a->id])}}"> <div class="badge badge-success">Aktif</div> </a> </td>
                  @else
                  <td class="text-center"><a href="{{route('aktifAcara',['id' => $a->id])}}"> <div class="badge badge-success">Non-Aktif</div> </a> </td>
                  @endif
                  <!-- <td></td> -->
                  <td class="text-center">
                    <a href="{{route('showAcara',['slug' => $a->slug])}}" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fas fa-eye"></i></a>
                    <button data-toggle="modal" data-target="#edit-{{$a['id']}}" class="btn btn-sm btn-outline-danger" id="tag{{$a['id']}}"><i class="fa fa-edit"></i></button>
                    <a href="{{route('deleteAcara',['id' => $a->id])}}" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="d-flex justify-content-center pag">
          {{ $data->links() }}
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

@section('modal')
  <!-- Modal -->
  @foreach ($data as $a)
    <div class="modal fade text-body" id="edit-{{$a['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form class="m-2" method="post" action="{{route('updateAcara',['id' => $a->id])}}" enctype="multipart/form-data">
          @csrf
            <div class="modal-body">

              <div class="card-body">
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul Kegiatan</label>
                  <div class="col-sm-12 col-md-7">
                    <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukan Judul Acara/Kegiatan" autocomplete="off" value="{{$a['judul']}}" required>
                    <p></p>
                  </div>
                </div>

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi Berita</label>
                  <div class="col-sm-12 col-md-7">
                  <textarea class="form-control editors" name="deskripsi" id="modal-{{$a['id']}}" placeholder="Masukan Deskripsi Acara/Kegiatan" style="height: 300px;" required>{{$a['deskripsi']}}</textarea>
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
                    <button type="submit" class="btn btn-primary">Update!</button>
                  </div>
                </div>
              </div>

            </div>
            <div class="modal-footer">
            </div>
            
          </form> 
        </div>
      </div>
    </div>
  @endforeach
@endsection