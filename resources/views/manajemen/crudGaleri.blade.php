@extends('layout.main')
@section('title','Data Galeri')
@section('halaman','Data Galeri')

@section('css')
  
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>Upload Foto Galeri</h4>
      <hr>
    </div>
    <div class="card-body">
      <form action="{{route('dz.upload')}}" method="post" class="dropzone dz-clickable" id="mydropzone">
      @csrf
        <div class="dz-default dz-message"><span>Drag/Drop foto kesini</span></div>
      </form>
      <div align="center" class="pt-3">
        <button type="button" class="btn btn-info" id="submit-all">Upload</button>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h4>Foto Galeri</h4>
      <hr>
    </div>
    <div class="card-body" id="uploaded-image">
    
    </div>
  </div>
@endsection

@section('js')
  <script src="{{asset('js/multiUpload.js')}}"></script>
@endsection