@extends('inside.app')

@section('content')
  <h1>Dashboard
  <small>Welcome, J</small></h1>
  <div class="panel panel-default">
    <div class="panel-heading">
      <ul class="nav nav-pills" role="tablist">
        <li role="presentation" class="active"><a href="#kp" aria-controls="kp" role="tab" data-toggle="tab">KP</a></li>
        <li role="presentation"><a href="#list" aria-controls="list" role="tab" data-toggle="tab">List KP</a></li>
        <li role="presentation"><a href="#nilai" aria-controls="nilai" role="tab" data-toggle="tab">Nilai KP</a></li>
      </ul>
    </div>
    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="kp">
        <div class="panel-body">
          <div class="row">
            <p class="col-md-3 text-right"><strong>Status</strong></p>
            <p class="col-md-3">-</p>
            <p class="col-md-3 text-right"><strong>Tempat KP</strong></p>
            <p class="col-md-3">-</p>
          </div>
          <div class="row">
            <p class="col-md-3 text-right"><strong>Periode Awal</strong></p>
            <p class="col-md-3">-</p>
            <p class="col-md-3 text-right"><strong>Periode Akhir</strong></p>
            <p class="col-md-3">-</p>
          </div>
          <div class="row">
            <p class="col-md-3 text-right"><strong>Dosen Pembimbing</strong></p>
            <p class="col-md-3">-</p>
            <p class="col-md-3 text-right"><strong>Pembimbing Lapangan</strong></p>
            <p class="col-md-3">-</p>
          </div>
          <div class="row">
            <p class="col-md-3 text-right"><strong>Anggota</strong></p>
            <p class="col-md-3">-</p>
          </div>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="list">
        <table class="table table-striped table-hover">
          <tr class="info">
            <th>Status</th>
            <th>Perusahaan</th>
            <th>Pembimbing Lapangan</th>
          </tr>
          <tr>
            <td>Status</td>
            <td>Teknik Informatika</td>
            <td>Orang</td>
          </tr>
        </table>
      </div>
      <div role="tabpanel" class="tab-pane" id="nilai">
        <div class="panel-body">
          Nilai belum dapat diakses.
        </div>
      </div>
    </div>
  </div>
@endsection