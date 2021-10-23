@extends('layout.main')
@section('title','Data Aspirasi')
@section('halaman','Data Apirasi Masyarakat')

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

    <div class="container p-3" style="color:black;">
      <table class="table table-md table-bordered table-striped table-hover" style="color:black;" cellSpacing="0" width="100%" id="asptbl">
        <p class="text-center" >Total Aspirasi : <span id="total-record">{{ $count }}</span></p>
        <a href="{{ route('exportAspirasi') }}" class="btn btn-success my-3">Export Excel <i class='far fa-file-excel'></i></a>
        <thead class="text-center">
          <tr>
            <th>Pengirim</th>
            <th>Aspirai</th>
            <th>Tanggal dibuat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="text-center"></tbody>
      </table>

    </div>
</div>
@endsection

@section('modal')
  <div class="modal fade text-body" id="aspirasi" tabindex="-1" role="dialog" aria-labelledby="aspirasi" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="aspirasi">Password Reset</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{-- konteks --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary">Reset</button>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('js')
  <script>

  $('#asptbl').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("getAspirasi") }}',
    columns: [
        {data: 'pengirim', name: 'pengirim'},
        {data: 'aspirasi', name: 'aspirasi', orderable: false, searchable: false},
        {data: 'created_at', name: 'tanggal', searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
  });

  </script>
@endsection