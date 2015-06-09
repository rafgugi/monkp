@extends('inside.app')

@section('content')
  <h1>Berita
  <small>Welcome, J</small></h1>
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="input-group custom-search-form">
        <input type="text" class="form-control" placeholder="Cari berita">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">
            <i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </div>
    <ul class="list-group">
      <li class="list-group-item">
        <h4>Judul</h4>
        <i><small><span class="fa fa-clock-o"></span> Created at: 2015-06-09 01:54:50</small></i>
        <p>
          Isi. Dapibus ac facilisis in. Morbi leo risus. Dapibus ac facilisis in
          Morbi leo risus
          Porta ac consectetur ac
          Vestibulum at eros
        </p>
        <p class="text-right">
          <button type="button" class="btn btn-link">Read more..</button>
        </p>
      </li>
      <li class="list-group-item">
        <h4>Judul</h4>
        <i><small><span class="fa fa-clock-o"></span> Created at: 2015-06-09 01:54:50</small></i>
        <p>
          Isi. Dapibus ac facilisis in. Morbi leo risus. Dapibus ac facilisis in
          Morbi leo risus
          Porta ac consectetur ac
          Vestibulum at eros
        </p>
        <p class="text-right">Read more..</p>
      </li>
    </ul>
  </div>
@endsection