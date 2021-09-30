@extends('layout.main')
@section('title','Berita')
@section('halaman','Staff/Pengurus RW 2')
@section('css')
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/staff.css') }}">
@endsection

@section('content')
<div class="card author-box card-primary">
  <div class="card-body">
      @if ($data->count() == 0)
        <div class="alert alert-warning alert-has-icon">
          <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
          <div class="alert-body">
            <div class="alert-title">Perhatian</div>
            Belum ada data staff/pengurus dimasukan.
          </div>
        </div>
      @else
        
      <div class="row">
        @foreach ($data as $d)
        <div class="col-md-6 p-5 text-dark">
          <div class="author-box-left">
            <div class="avatar-item mr-5">
            @if (isset($d->foto))
              <img alt="image" src="{{ Storage::url($d['url']) }}" class="" data-toggle="tooltip" title="" data-original-title="{{$d->nama}}">
            @else
            <img alt="image" src="{{ URL::asset('assets/img/avatar/avatar-1.png') }}" class="" data-toggle="tooltip" title="" data-original-title="{{$d->nama}}">
            @endif
            </div>
          </div>
          <div class="author-box-details">
            <div class="author-box-name">
              <h3 class="text-primary">{{$d->nama}}</h3>
            </div>
            <h5 class="text-info">{{$d->jabatan->njabatan}}</h5>
            <div class="author-box-job">No. Pegawai : {{isset($d->no_pegawai) ? $d->no_pegawai : Null}}</div>
            <p style="color:black;">Alamat : {{$d->alamat}}</p>
            <hr>
            <span class="badge badge-info">Nomer Hp : {{$d->no_hp}}</span>
          </div>
        </div>
        <hr>
        @endforeach
      </div>
      @endif
    <hr>
  </div>
</div>
@endsection