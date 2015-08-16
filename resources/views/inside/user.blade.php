@extends('inside.app')

@section('content')
  <h1>Buat Akun</h1>
  <hr>
  @if (session('alert'))
    <div class="alert alert-{{session('alert')['alert']}} alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      {{session('alert')['body']}}
    </div>
  @endif
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">Mahasiswa</div>
        <div class="panel-body">
          <form action="{{url('users/mahasiswa')}}" method="post" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label class="col-md-4 control-label">Nama</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="name" value="{{old('name')}}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label">NRP</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="nrp" value="{{old('nrp')}}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label">Password</label>
              <div class="col-md-6">
                <input type="password" class="form-control" name="password">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">Tambah</button>
              </div>
            </div>
          </form>
        </div>
      </div>    
    </div>
        <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">Dosen</div>
        <div class="panel-body">
          <form action="{{url('users/dosen')}}" method="post" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label class="col-md-4 control-label">Nama</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="name" value="{{old('name')}}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label">Nama Lengkap</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="full_name" value="{{old('full_name')}}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label">NIP</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="nip" value="{{old('nip')}}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label">Inisial</label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="initial" value="{{old('initial')}}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label">Password</label>
              <div class="col-md-6">
                <input type="password" class="form-control" name="password">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">Tambah</button>
              </div>
            </div>
          </form>
        </div>
      </div>    
    </div>
  </div>
  
@endsection