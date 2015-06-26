<!doctype html>
<html>
<head>
  <title>[Monitoring Kerja Praktik] Daftar</title>
  {!! HTML::style('public/css/bootstrap.min.css') !!}
  {!! HTML::style('public/css/font-awesome.min.css') !!}
</head>
<body style="background-color:#555;">
  <div class="container" style="margin-top:5%;">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Daftar</div>
          <div class="panel-body">
            @if (count($errors) > 0)
              <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <form action="{{url('auth/register')}}" method="post" class="form-horizontal">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group">
                <label class="col-md-4 control-label">Nama</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label">
                  NRP
                  <i class="fa fa-info text-primary" title="NRP akan digunakan sebagai username untuk login."></i>
                </label>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="nrp" value="{{ old('nrp') }}">
                </div>
                <div class="col-md-1">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label">E-Mail</label>
                <div class="col-md-6">
                  <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label">Password</label>
                <div class="col-md-6">
                  <input type="password" class="form-control" name="password">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-4 control-label">Konfirmasi Password</label>
                <div class="col-md-6">
                  <input type="password" class="form-control" name="password_confirmation">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">Register</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  {!! HTML::script('public/js/jquery.min.js') !!}
  {!! HTML::script('public/js/bootstrap.min.js') !!}
</body>
</html>
