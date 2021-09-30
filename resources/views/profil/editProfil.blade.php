@extends('layout.main')
@section('title','Edit Profil')
@section('halaman','Edit Profil')

@section('css')
  <link rel="stylesheet" href="{{asset('css/profil.css')}}">
@endsection

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

    <div class="row m-l-0 m-r-0">
        <div class="col-sm-6">
            <div class="card-block">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Detail Akun</h6>
                <div class="row">
                    <div class="col-sm-6">
                        <p class="m-b-10 f-w-600">Username</p>
                        <h6 class="text-muted f-w-400">{{ Auth::user()->username }}</h6>
                    </div>
                    <div class="col-sm-6">
                        <p class="m-b-10 f-w-600">Nomer Pegawai</p>
                        @if(isset(Auth::user()->staff['no_pegawai']))
                        <h6 class="text-muted f-w-400">{{ isset(Auth::user()->staff["no_pegawai"]) ? Auth::user()->staff["no_pegawai"] : Null }}</h6>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <p class="m-b-10 f-w-600">Verifikasi</p>
                        @if ( empty(Auth::user()->verified_at) )
                        <h6 class="text-muted f-w-400">Belum diverifikasi</h6>
                        @else
                        <h6 class="text-muted f-w-400">Telah diverifikasi ({{Auth::user()->verified_at}})</h6>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <p class="m-b-10 f-w-600">Status</p>
                        @if ( Auth::user()->status == '1' )
                        <h6 class="text-muted f-w-400">Level User</h6>
                        @else
                        <h6 class="text-muted f-w-400">Level Admin</h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card-block">
            <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Detail Staff</h6>
            <div class="row">
                <div class="col-sm-6">
                    <p class="m-b-10 f-w-600">Nama</p>
                    <h6 class="text-muted f-w-400">{{ isset(Auth::user()->staff["no_pegawai"]) ? Auth::user()->staff["nama"]: Null}}</h6>
                </div>
                <div class="col-sm-6">
                    <p class="m-b-10 f-w-600">Nomer Hp</p>
                    <h6 class="text-muted f-w-400">{{ isset(Auth::user()->staff["no_pegawai"]) ? Auth::user()->staff["no_hp"] : Null }}</h6>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-8">
                    <p class="m-b-10 f-w-600">Alamat</p>
                    <h6 class="text-muted f-w-400">{{ isset(Auth::user()->staff["no_pegawai"]) ?Auth::user()->staff["alamat"] : Null}}</h6>
                </div>
            </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="container" id="profilParent">
        <button class="btn btn-primary" data-toggle="collapse" href="#resetPassword" role="button" aria-expanded="false" aria-controls="collapseExample">
            <i class="fas fa-edit"></i> Reset Password
        </button>
        <button class="btn btn-primary" data-toggle="collapse" href="#taut" role="button" aria-expanded="false" aria-controls="collapseExample" {{isset($data['user_id']) ? 'disabled' : '' }}>
            <i class="fas fa-user"></i> Tautkan Akun
        </button>


        <div class="collapse" id="resetPassword" data-parent="#profilParent">
            <div class="card card-body">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('updatePass',['id' => Auth::id()] ) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password Lama') }}</label>

                            <div class="col-md-6">
                                <input id="old-password" type="password" class="form-control @error('old-password') is-invalid @enderror" name="old-password" required autocomplete="old-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password Baru') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="collapse" id="taut" data-parent="#profilParent">
            <div class="card card-body">
                Menautkan Akun web dengan staff
                <hr>
                <form action="{{route('tautkan')}}" method="post">
                @csrf
                
                <div class="form-group row mb-4">
                    <label for="staff" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pilih Staff</label>
                    <div class="col-sm-12 col-md-7">
                    <select class="form-control" id="staff" name="staff" required> 
                        <option value="" selected>Pilih...</option>
                        @foreach ($staff as $s)
                            <option value="{{$s->id}}">Nama : {{$s->nama}} | No : {{$s->no_pegawai}} | {{ $s['user_id'] === NULL ? 'Belum Terpakai' : 'Terpakai' }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Tautkan Akun!') }}
                        </button>
                    </div>
                </div>
                </form>

            </div>
        </div>
    </div>
    
</div>


@endsection