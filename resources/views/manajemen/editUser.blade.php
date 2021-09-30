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
      <table class="table table-sm">
        <thead>
          <tr>
            <th class="text-center">Nomer Pegawai</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Username</th>
            <th class="text-center" data-toggle="tooltip" data-placement="top" title="Mengecek apakah user sudah dihubungkan dengan staff">Integrasi</th>
            <th class="text-center" data-toggle="tooltip" data-placement="top" title="Anda bisa memverifikasi user yang terdaftar">Verifikasi</th>
            <th class="text-center" data-toggle="tooltip" data-placement="top" title="Anda bisa mengatur hak akses user yang mendaftar">Level Hak Akses</th>
            <th class="text-center" data-toggle="tooltip" data-placement="top" title="Anda bisa menghapus data user">Hapus/Reset</th>
          </tr>
        </thead>
        <tbody>
        @foreach($data as $a)
          <tr class="text-center">
            <td>{{ isset($a->staff['no_pegawai']) ? $a->staff['no_pegawai'] : '-' }}</td>
            <td>{{ isset($a->staff['nama']) ? $a->staff['nama'] : '-' }}</td>
            <td>{{ $a['username'] }}</td>
            @if(empty($a->staff['user_id']))
            <td><a><div class="badge badge-light">Belum Ditautkan<i class="fas fa-times"></i></div></a></td>
            @else
            <td><div class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="ditautkan dengan staff : {{$a->staff->nama}}">Ditautkan<i class="fas fa-check-square"></i></div> </td>
            @endif
            @if(empty($a['verified_at']))
            <td><a href="{{route('verifiedUser',['id' => $a->id])}}"><div class="badge badge-light">Belum Terverifikasi <i class="fas fa-times"></i></div></a></td>
            @else
            <td><div class="badge badge-warning">Terverifikasi <i class="fas fa-check-square"></i></div> </td>
            @endif

            @if ($a['status'] != 2)
            <td><a href="{{route('levelUser',['id' => $a->id])}}"> <div class="badge badge-light">User</div> </a> </td>
            @else
            <td><a href="{{route('levelUser',['id' => $a->id])}}"> <div class="badge badge-warning">Admin</div> </a> </td>
            @endif
            <td>
              <a href="{{route('deleteUser',['id' => $a->id])}}" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a>
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