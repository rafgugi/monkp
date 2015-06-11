<!doctype html>
<html>
<head>
  <title>
    [Monitoring Kerja Praktik]
    @yield('title')
  </title>
  {!! HTML::style('public/css/bootstrap.min.css') !!}
  {!! HTML::style('public/css/bootstrap-table.css') !!}
  {!! HTML::style('public/css/bootstrap-datepicker.css') !!}
  {!! HTML::style('public/css/sb-admin-2.css') !!}
  {!! HTML::style('public/css/metis-menu.min.css') !!}
  {!! HTML::style('public/css/font-awesome.min.css') !!}
  @yield('css')
</head>
<body>
  <div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><strong>MonKP</strong></a>
      </div>
      <!-- /.navbar-header -->

      <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-alerts">
            <li>
              <a href="#">
                <div>
                  <i class="fa fa-envelope fa-fw"></i> Message Sent
                  <span class="pull-right text-muted small">4 minutes ago</span>
                </div>
              </a>
            </li>
            <li class="divider"></li>
            <li>
              <a href="#">
                <div>
                  <i class="fa fa-upload fa-fw"></i> Server Rebooted
                  <span class="pull-right text-muted small">4 minutes ago</span>
                </div>
              </a>
            </li>
            <li class="divider"></li>
            <li>
              <a class="text-center" href="#">
                <strong>See All Alerts</strong>
                <i class="fa fa-angle-right"></i>
              </a>
            </li>
          </ul>
          <!-- /.dropdown-alerts -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i>
            {{Auth::user()->name}}
            <i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-user">
            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
            </li>
            <li class="divider"></li>
            <li><a href="{{url('auth/logout')}}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </li>
          </ul>
          <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
      </ul>
      <!-- /.navbar-top-links -->

      <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
          <ul class="nav" id="side-menu">
            <!--li class="sidebar-search">
              <div class="input-group custom-search-form">
                <input type="text" class="form-control" placeholder="Cari">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">
                    <i class="fa fa-search"></i>
                  </button>
                </span>
              </div>
            </li-->
            <li>
              <a href="{{url('home')}}"><i class="fa fa-home fa-fw"></i> Dashboard</a>
            </li>
            <li>
              <a href="{{url('berita')}}"><i class="fa fa-newspaper-o fa-fw"></i> Berita</a>
            </li>
            <li>
              <a href="{{url('pengajuan')}}"><i class="fa fa-edit fa-fw"></i> Pengajuan</a>
            </li>
          </ul>
        </div>
        <!-- /.sidebar-collapse -->
      </div>
      <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
      <div class="row">
        <div class="col-md-12 col-lg-12">
          @yield('content')
        </div>
      </div>
    </div>
    <!-- /#page-wrapper -->
  </div>
  <!-- /#wrapper -->

  {!! HTML::script('public/js/jquery.min.js') !!}
  {!! HTML::script('public/js/bootstrap.min.js') !!}
  {!! HTML::script('public/js/bootstrap-table.js') !!}
  {!! HTML::script('public/js/bootstrap-datepicker.js') !!}
  {!! HTML::script('public/js/bootstrap-table-en-US.js') !!}
  {!! HTML::script('public/js/metis-menu.min.js') !!}
  {!! HTML::script('public/js/sb-admin-2.js') !!}
  @yield('js')
</body>
