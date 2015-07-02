@extends('inside.app')

@section('content')
  <h1>Berita</h1>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" aria-hidden="true">
    <form action="{{url('berita/tambah')}}" method="post" class="form">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Buat Berita</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Judul</label>
              <input class="form-control" name="title" />
            </div>
            <div class="form-group">
              <label>Isi</label>
              <textarea class="form-control" name="post" rows="9"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- /Modal -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <form action="{{url('berita')}}" method="get" class="form-inline">
        @if (Auth::user()->role == 'ADMIN')
          <div class="form-group">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
              Tambah
            </button>
          </div>
        @endif
        <div class="input-group custom-search-form">
          <input type="text" class="form-control" placeholder="Cari berita">
          <span class="input-group-btn">
            <button class="btn btn-default">
              <i class="fa fa-search"></i>
            </button>
          </span>
        </div>
      </form>
    </div>
    
    <ul class="list-group">
      @if (sizeof($posts) < 1)
        <li class="list-group-item">Tidak ada berita.</li>
      @else
        @foreach ($posts as $post)
          <li class="list-group-item" id="accordion">
            <h4>{{$post->title}}</h4>
            <i><small><span class="fa fa-clock-o"></span> Created at: {{strstr($post->created_at, ' ', true)}}</small></i>
            &nbsp;
            <i><small><span class="fa fa-clock-o"></span> Updated at: {{strstr($post->updated_at, ' ', true)}}</small></i>
            <br />
            <p id="less">
              {{$post->post}}
            </p>
          </li>
        @endforeach
      @endif
    </ul>
  </div>

@endsection