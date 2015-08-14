@extends('inside.app')

@section('content')
  <h1>Periode</h1>
  <hr>
  @if (session('alert'))
    <div class="alert alert-{{session('alert')['alert']}} alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      {{session('alert')['body']}}
    </div>
  @endif
  <div class="panel panel-default">
    <div class="panel-body">
      <form action="" class="form-horizontal" method="post">
        <div class="form-group">
          <label class="control-label col-md-3">Tahun</label>
          <div class="col-md-2">
            <input type="text" name="year" class="form-control input-sm" value="{{date('Y')}}">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3">Semester</label>
          <div class="col-md-2">
            <select name="odd" class="form-control input-sm">
              <option value="1">Gasal</option>
              <option value="0">Genap</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3">Mulai Semester</label>
          <div class="col-md-2">
            <input type="text" name="start_date" data-provide="datepicker" class="datepicker form-control input-sm">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3">Akhir Semester</label>
          <div class="col-md-2">
            <input type="text" name="end_date" data-provide="datepicker" class="datepicker form-control input-sm">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-3">Batas Akhir Pembuatan Akun</label>
          <div class="col-md-2">
            <input type="text" name="user_due_date" data-provide="datepicker" class="datepicker form-control input-sm">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-3 col-md-offset-3">
            <input type="submit" value="Submit" class="btn btn-primary">
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection