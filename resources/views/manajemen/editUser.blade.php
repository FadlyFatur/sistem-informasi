@extends('layout.main')
@section('title','Data User')
@section('halaman','Data User')

@section('content')
<div class="card user-card-full p-3">
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
  <div class="card-header">
      <h4>Data User</h4>
    </div>


    <div class="table-responsive" style="color:black;">
      <p class="text-center" >Total Data Acara : <span id="total-record">{{$total_data}}</span></p>
      <table class="table table-md table-bordered table-striped table-hover" id="staff-tbl" cellSpacing="0" width="100%">
        <a href="{{ route('export-user') }}" class="btn btn-success my-3">Export Excel <i class='far fa-file-excel'></i></a>
        <thead>
          <tr class="text-center">
            <th >Nomer Pegawai</th>
            <th >Nama</th>
            <th >Username</th>
            <th data-toggle="tooltip" data-placement="top" title="Integrasi membuat user dapat akses penuh ke data">Integrasi</th>
            <th data-toggle="tooltip" data-placement="top" title="Verifikasi user yang terdaftar secara manual">Verifikasi</th>
            <th data-toggle="tooltip" data-placement="top" title="Hak akses user digunakan untuk mengatur akses pada website">Hak Akses</th>
            <th data-toggle="tooltip" data-placement="top" title="Anda bisa menghapus data user atau mereset password">Hapus/Reset</th>
          </tr>
        </thead>
        <tbody>
        @foreach($data as $a)
          <tr class="text-center">
            <td>{{ isset($a->staff['id_pegawai']) ? $a->staff['id_pegawai'] : '-' }}</td>
            <td>{{ isset($a->staff['nama']) ? $a->staff['nama'] : '-' }}</td>
            <td>{{ $a['username'] }}</td>
            @if(empty($a->staff['user_id']))
            <td><a><div class="badge badge-warning">Belum Ditautkan<i class="fas fa-times"></i></div></a></td>
            @else
            <td class="list">
              <a class="badge badge-success" href="{{route('reIntegrasi',['id' => $a->id])}}">
                Ditautkan <i class="fas fa-check-square"></i>
              </a> 
            </td>
            @endif
            @if(empty($a['verified_at']))
            <td><a href="{{route('verifiedUser',['id' => $a->id])}}" onclick="return confirm('Apakah anda yakin meverifikasi user ini?')"><div class="badge badge-warning">Belum Terverifikasi <i class="fas fa-times"></i></div></a></td>
            @else
            <td><div class="badge badge-success">Terverifikasi <i class="fas fa-check-square"></i></div> </td>
            @endif

            @if ($a['role'] == 1)
            <td><a href="{{route('levelUser',['id' => $a->id])}}" onclick="return confirm('Apakah anda yakin menaikan hak akses?')"> <div class="badge badge-light">User</div> </a> </td>
            @elseif ($a['role'] == 2)
            <td><a href="{{route('levelUser',['id' => $a->id])}}" onclick="return confirm('Apakah anda yakin menurunkan hak akses?')"> <div class="badge badge-info">Admin</div> </a> </td>
            @else
            <td><a href="#superadmin"> <div class="badge badge-primary">Super Admin</div> </a> </td>
            @endif
            <td>
              @if ($a['role'] != 3)
              <a href="{{route('deleteUser',['id' => $a->id])}}" onclick="return confirm('Apakah anda yakin mendelete User ini?')" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a>
              @endif
              <a href="" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#reset-{{$a['id']}}"><i class="fas fa-lock-open"></i></a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
</div>
@endsection

@section('modal')
  @foreach($data as $a)
    <div class="modal fade text-body" id="reset-{{$a['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Password Reset</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h4>Apakah yakin akan akan mereset Password?</h4>
            <p>User : {{ $a['username'] }}</p>
            <p>password akan direset menjadi default yaitu "12345" harap langsung mengganti password setelah direset demi menjaga keamanan website.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <a href="{{route('resetUser',['id' => $a->id])}}" type="button" class="btn btn-primary">Reset</a>
          </div>
        </div>
      </div>
    </div>
  @endforeach
@endsection

@section('js')
    <script>
      // $('.rIntg').hover(function () {
      //   var element = document.getElementById("myDIV");
      //   $( this ).classList.toogle('badge-warning');
      //   $( this ).classList.toogle('badge-danger');
      // })
      // $( "td.list" ).hover(
      //   function() {
      //     $( this ).toggle( "badge-warning" );
      //     $( this ).toggle( "badge-danger" );
      //   }
      // );

      $( "td.list .badge").hover(
        function() {
          // $( this ).classList.remove("badge-warning");
          $( this ).removeClass( "badge-warning" );
          $( this ).addClass("badge-danger");
          $( this ).text("Batalkan")
        }, function() {
          $( this ).addClass( "badge-warning" );
          $( this ).removeClass("badge-danger");
          $( this ).html( 'Ditautkan <i class="fas fa-check-square"></i>' );
        }
      );
    </script>
@endsection