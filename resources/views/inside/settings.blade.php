@extends('inside.app')

@section('content')
  <h1>Settings</h1>
  <div class="panel panel-default">
    <div class="panel-body">
      <h4><strong>Ganti semester:</strong></h4>
      <form action="" class="form-horizontal">
        <div class="form-group">
          <label class="control-label col-md-2">Tahun</label>
          <div class="col-md-3">
            <input type="text" name="year" class="form-control input-sm" placeholder="{{date('Y')}}">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-md-2">Semester</label>
          <div class="col-md-3">
            <select name="odd" class="form-control input-sm">
              <option value="1">Gasal</option>
              <option value="0">Genap</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-3 col-md-offset-2">
            <input type="submit" value="Submit" class="btn btn-primary">
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection