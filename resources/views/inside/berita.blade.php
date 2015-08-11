@extends('inside.app')

@section('content')
  <h1>Berita</h1>
  @if (session('alert'))
    <div class="alert alert-{{session('alert')['alert']}} alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      {{session('alert')['body']}}
    </div>
  @endif
  <div class="modal fade" id="createModal" role="dialog" aria-hidden="true">
    <form action="{{url('berita/tambah')}}" enctype="multipart/form-data" method="post" class="form">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="createModalLabel">Buat Berita</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Judul</label>
              <input class="form-control" name="title">
            </div>
            <div class="form-group">
              <label>Isi</label>
              <textarea class="form-control" name="post" rows="9"></textarea>
            </div>
            <div class="form-group">
              <label>Attach</label>
              <input type="file" class="form-control" name="file">
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
  <div class="modal fade" id="editModal" role="dialog" aria-hidden="true">
    <form action="{{url('berita/edit')}}" method="post" class="form" id="form-edit">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="editModalLabel">Edit Berita</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Judul</label>
              <input class="form-control" name="title" id="title-edit">
              <input class="form-control hidden" name="id" id="id-edit">
            </div>
            <div class="form-group">
              <label>Isi</label>
              <textarea class="form-control" name="post" rows="9" id="post-edit"></textarea>
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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
              Tambah
            </button>
          </div>
        @endif
        <div class="input-group custom-search-form">
          <input type="text" class="form-control" placeholder="Cari berita">
          <span class="input-group-btn">
            <button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </form>
    </div>
    @if (sizeof($posts) < 1)
      <div class="panel-body">Tidak ada berita.</div>
    @else
      <table class="table">
        @foreach ($posts as $post)
          <tr>
            <td>
              <h4>
                <span class="id hidden">{{$post->id}}</span>
                <span class="title">{{$post->title}}</span>
                @if (Auth::user()->role == 'ADMIN')
                  <small>
                    <a class="pull-right text-danger" title="delete" href="{{url('berita/hapus/'.$post->id)}}">
                      <span class="glyphicon glyphicon-remove"></span>
                    </a>
                    <span class="pull-right text-info">&nbsp;</span>
                    <a class="pull-right edit-post" title="edit" href="#" data-toggle="modal" data-target="#editModal">
                      <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                  </small>
                @endif
              </h4>
              <p class="post">{{$post->post}}</p>
              @if (($file = $post->file) != null)
                <p class="text-muted">Attachment: {!!link_to($file->path, $file->name)!!}</p>
              @endif
              <i><small><span class="fa fa-clock-o"></span> Created at: {{strstr($post->created_at, ' ', true)}}</small></i>
              &nbsp;
              <i><small><span class="fa fa-clock-o"></span> Updated at: {{strstr($post->updated_at, ' ', true)}}</small></i>
            </td>
          </tr>
        @endforeach
      </table>
    @endif
  </div>
@endsection

@section('js')
  <script>
    $(".edit-post").click(function() {
      $parent = $(this).parent().parent().parent();
      title = $(".title", $parent).html();
      post = $(".post", $parent).html();
      id = $(".id", $parent).html();

      $("#title-edit").val(title);
      $("#post-edit").html(post);
      $("#id-edit").val(id);
    });
  </script>
@endsection
