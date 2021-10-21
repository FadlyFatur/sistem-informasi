@extends('layout.main')
@section('title','Aspirasi')
@section('halaman','Ruang Aspirasi Masyarakat')

@section('css')
<link rel="stylesheet" href="">
@endsection

@section('content')
<div class="card">
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
        <h4>Ruang Aspirasi Masyarakat</h4>
    </div>
    <div class="card-body" style="color: black;">
        <form method="POST" action="{{ route('post-aspirasi') }}">
            @csrf
            <div class="mb-3">
                <label for="deskripsi">Silahkan tulis aspirasi pada kolom dibawah</label>
                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5" style="height: auto;" required>{{ old('deskripsi') }}</textarea>
            </div>
            <div class="mb-3">
              <label for="pengirim">Pengirim</label>
              <input type="text" class="form-control" name="pengirim" id="pengirim">
            </div>
            <div class="mb-3 form-check">
                <input type="hidden" value=0 name="anonim">
                <input type="checkbox" value=1 name="anonim" class="form-check-input" id="anonim">
                <label class="form-check-label" for="anonim">Anonim</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
</div>
@endsection

@section('js')
<script>
    $("#anonim").change(function() {
        if(this.checked) {
            $('input[name=pengirim]').attr('disabled','disabled');
            $('input[name=pengirim]').removeAttr('required');
        }else{
            $('input[name=pengirim]').attr('required','required');
            $('input[name=pengirim]').removeAttr('disabled');
        }
    });
</script>
@endsection