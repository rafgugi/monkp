<!doctype html>
<html>
<head>
  <title>
    [Monitoring Kerja Praktik]
    @yield('title')
  </title>
  <link rel="icon" type="image/x-icon" href="{{asset('public/favicon.ico')}}">
  {!! HTML::style('public/css/bootstrap.min.css') !!}
  {!! HTML::style('public/css/bootstrap-table.css') !!}
  {!! HTML::style('public/css/bootstrap-datepicker.css') !!}
  {!! HTML::style('public/css/sb-admin-2.css') !!}
  {!! HTML::style('public/css/metis-menu.min.css') !!}
  {!! HTML::style('public/css/font-awesome.min.css') !!}
  <style>
    .navbar-top-links .dropdown-menu li > div {
      padding: 3px 20px;
      min-height: 0;
    }
    .borderless tbody tr td, .borderless tbody tr th, .borderless thead tr th {
      border: none !important;
    }
    .nav > li.dropdown > a:hover, .nav > li.dropdown > a:focus {
      background-color: #337ab7;
    }
    .navbar-inverse {
      background-color: #428bca;
      border-color: #337ab7;
    }
    .navbar-inverse .navbar-brand, .dropdown a {
      color: #fff;
    }
    .dropdown.open a.dropdown-toggle {
      color: #ddd;
    }
    .dropdown.open {
      background-color: #337ab7;
    }
    .sidebar ul li:hover {
      background-color: #ddd;
    }
    .badge {
      background-color: #fff;
      color: #337ab7;
    }
    .navbar-inverse .navbar-toggle {
      border-color: #fff;
      color: #337ab7;
    }
    .navbar-inverse .navbar-toggle:hover,
    .navbar-inverse .navbar-toggle:focus {
      background-color: #5bc0de;
    }
    .navbar-inverse .navbar-collapse,
    .navbar-inverse .navbar-form {
      border-color: #fff;
    }
  </style>
  @yield('css')
</head>
<body>
  <div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">
          <strong>MonKP Periode
            @if (($semester = App\Semester::current()) == null)
              -
            @else
              {{$semester->toString()}}
            @endif
          </strong>
        </a>
      </div>
      <!-- /.navbar-header -->

      <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-bell fa-fw"></i>
            @if (Auth::user()->notif->contains('is_read', '0'))
            <span class="badge">{{Auth::user()->notif->where('is_read', '0')->count()}}</span>
            @endif
            <i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-alerts">
            @forelse (Auth::user()->notif as $notif)
              <li>
                <div>
                  <div>
                    @if ($notif->notifiable_type == 'App\GroupRequest')
                      <i class="fa fa-envelope fa-fw"></i> <strong>Permintaan bergabung</strong>
                      <span class="pull-right text-muted small">{{strstr($notif->created_at, ' ', true)}}</span><br>
                      from: {{$notif->notifiable->group->students->get(0)->name}}<br>
                      {{$notif->notifiable->group->corporation->name_city}}
                      @if ($notif->notifiable->status == 1)
                        <span class="pull-right text-muted small">Accepted</span>
                      @elseif ($notif->notifiable->status == 2)
                        <span class="pull-right text-muted small">Rejected</span>
                      @else
                        <span class="pull-right">
                          <a href="{{url('pengajuan/accept/'.$notif->notifiable->id)}}" class="btn btn-success btn-xs fa fa-check"></a>
                          <a href="{{url('pengajuan/reject/'.$notif->notifiable->id)}}" class="btn btn-danger btn-xs fa fa-remove"></a>
                        </span>
                      @endif
                    @endif
                  </div>
                </div>
              </li>
              <li class="divider"></li>
            @empty
              <li>
                <div>
                  <div>Tidak ada pemberitahuan.</div>
                </div>
              </li>
            @endforelse
          </ul>
          <!-- /.dropdown-alerts -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i>
            {{Auth::user()->personable->name}}
            <i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-user">
            <li><a href="{{url('auth/profile')}}"><i class="fa fa-gear fa-fw"></i> Settings</a>
            </li>
            <li class="divider"></li>
            <li><a href="{{url('auth/logout')}}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </li>
          </ul>
        </li>
      </ul>

      <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
          <ul class="nav" id="side-menu">
            <li>
              <a href="{{url('home')}}"><i class="fa fa-users fa-fw"></i> Kelompok</a>
            </li>
            <li>
              <a href="{{url('berita')}}"><i class="fa fa-newspaper-o fa-fw"></i> Berita</a>
            </li>
            @if ($role = Auth::user()->role)
            @endif
            @if ($role == 'STUDENT')
              <li>
                <a href="{{url('pengajuan')}}"><i class="fa fa-edit fa-fw"></i> Pengajuan</a>
              </li>
            @endif
            @if ($role == 'ADMIN')
              <li>
                <a href="{{url('table')}}"><i class="fa fa-table fa-fw"></i> Tabel</a>
              </li>
              <li>
                <a href="{{url('stats')}}"><i class="fa fa-bar-chart fa-fw"></i> Statistik</a>
              </li>
              <li>
                <a href="{{url('periode')}}"><i class="fa fa-cog fa-fw"></i> Periode</a>
              </li>
              <li>
                <a href="{{url('users')}}"><i class="fa fa-user-plus fa-fw"></i> User</a>
              </li>
            @endif
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
  <div class="modal fade" id="mainModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" id="mainModalContent"></div>
    </div>
  </div>
  {!! HTML::script('public/js/jquery.min.js') !!}
  {!! HTML::script('public/js/bootstrap.min.js') !!}
  {!! HTML::script('public/js/bootstrap-table.js') !!}
  {!! HTML::script('public/js/bootstrap-datepicker.js') !!}
  {!! HTML::script('public/js/bootstrap-table-en-US.js') !!}
  {!! HTML::script('public/js/metis-menu.min.js') !!}
  {!! HTML::script('public/js/sb-admin-2.js') !!}
  @yield('js')
  <script>
    $(document).ready(function(){
      $(".mainmodal").click(function() {
        $("#mainModal").modal('show');
        $.ajax({
          type: "GET",
          url: $(this).attr('data-url'),
          success: function(data){
            $("#mainModalContent").html(data);
          },
          error: function(data) {
            $("#mainModalContent").html(data);
          }
        });
      });
    });
  </script>
</body>
