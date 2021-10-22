@extends('layout.main')
@section('title','Berita')
@section('halaman','Acara/Kegiatan')

@section('css')
<link rel="stylesheet" href="{{asset('css/berita.css')}}">
@endsection

@section('content')

<div class="container-fluid">

<div class="card">
<div class="card-img-top box-photo p-2">
  @if ($data->foto != Null)
    <img src="{{asset('storage/images/acara/'.$data->foto)}}" alt="{{$data['judul']}}">
    @else
    <img src="{{ asset('assets/img/news/img01.jpg')}}" alt="{{ $data['judul'] }}">
  @endif
</div>
  <hr>
<div class="card-header text-secondary">
  <p href="#">Acara/Kegiatan | Tanggal : {{ date('m/d/Y',strtotime($data['created_at'])) }}</p>
</div>
<div class="card-body">
  <h3 class="card-title text-primary">{{$data['judul']}}</h3>
  <p style="color:black;">{!! $data['deskripsi'] !!}</p>
</div>
</div>


</div>
@endsection