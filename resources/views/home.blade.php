<!doctype html>
<html>
<head>
  <title>
    [Monitoring Kerja Praktik] Home
  </title>
  {!! HTML::style('public/css/bootstrap.min.css') !!}
  {!! HTML::style('public/css/font-awesome.min.css') !!}
  <!--style>
/* Carousel base class */
.carousel, .carousel .item {
  min-height: 200px;
}
.carousel .carousel-caption, .carousel-control {
  color: #333;
  text-shadow: none;
}
.carousel-control:hover, .carousel-control:focus {
  color: #222;
}
.carousel-control, .carousel-control:hover {
  background-image: none !important;
}
  </style-->
</head>
<body>
  <div class="jumbotron" style="background-color:#428bca;">
    <div class="container">
      <h2 style="color:#fff;">
        Monitoring Kerja Praktik
        <small style="color:#ddd;">Institut Teknologi Sepuluh Nopember</small>
      </h2>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <!--div class="col-md-9">
        <h4>carousel</h4>
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner" role="listbox">
            <div class="item active">
              <div class="container">
                <div class="carousel-caption">
                  <h1>Example headline.</h1>
                  <p>Note: If you're viewing this page via a <code>file://</code> URL, the "next" and "previous" Glyphicon buttons on the left and right might not load/display properly due to web browser security rules.</p>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="container">
                <div class="carousel-caption">
                  <h1>Another example headline.</h1>
                  <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="container">
                <div class="carousel-caption">
                  <h1>One more for good measure.</h1>
                  <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                </div>
              </div>
            </div>
          </div>
          <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
      <!-- /.carousel -->
      <div class="col-md-offset-4 col-md-4">
        <form action="{{url('auth/login')}}" method="post">
          <h4>Login</h4>
          @if (count($errors) > 0)
            <div class="alert alert-info">
              <strong>Whoops!</strong> Login failed.
            </div>
          @endif
          <div class="form-group form-group-lg">
            <input class="form-control" placeholder="Username" name="username" type="text" value="{{old('username')}}" autofocus>
          </div>
          <div class="form-group form-group-lg">
            <input class="form-control" placeholder="Password" name="password" type="password" value="">
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-lg btn-primary btn-block" value="Sign in">
          </div>
          <p>Silakan <a href="{{url('auth/register')}}">register</a> jika belum punya akun.</p>
        </form>
      </div>
    </div>
  </div>
  {!! HTML::script('public/js/jquery.min.js') !!}
  {!! HTML::script('public/js/bootstrap.min.js') !!}
  {!! HTML::script('public/js/sb-admin-2.js') !!}
</body>
