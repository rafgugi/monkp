@extends('inside.app')

@section('content')
  <h1>Settings</h1>
  <div class="panel panel-default">
    <div class="panel-body">
      <p>
        <strong>Periode sekarang:</strong>
        {{$semester==null?'-':$semester->toString()}}
      </p>
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
      </form>
    </div>
  </div>
@endsection