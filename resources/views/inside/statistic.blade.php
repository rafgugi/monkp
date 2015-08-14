@extends('inside.app')

@section('css')
  {!! HTML::style('public/css/morris.css') !!}
@endsection

@section('content')
  <h1>Statistik</h1>
  <form class="form-inline">
    <select name="semester" class="form-control input-sm">
      <option value="0">-- Pilih semester --</option>
      @foreach(App\Semester::get()->sortBy('year')->sortByDesc('odd') as $semester)
        <option value="{{$semester->id}}">{{$semester->toString()}}</option>
      @endforeach
    </select>
    <button class="btn btn-default btn-sm">Pilih</button>
  </form>
  <hr>
  <div class="row">
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Kelompok Kerja Praktik</div>
        <div class="panel-body">
          @if ($groups->count() == 0)
            Tidak ada kelompok KP
          @else
            <div id="myfirstchart" style="height: 250px;"></div>
            <div class="col-md-10 col-md-offset-1">
              <a class="btn btn-default btn-block" role="button" data-toggle="collapse" href="#group-collapse" aria-expanded="false" aria-controls="group-collapse">
                Lihat Detil
              </a>
              <div class="collapse" id="group-collapse" style="padding-top: 7px;">
                <table class="table table-condensed table-bordered">
                  <tr>
                    <td class="text-right">Created</td>
                    <td>{{$groups->where('status.status', 0)->count()}}</td>
                  </tr>
                  <tr>
                    <td class="text-right">Denied</td>
                    <td>{{$groups->where('status.status', -1)->count()}}</td>
                  </tr>
                  <tr>
                    <td class="text-right">Confirmed</td>
                    <td>{{$groups->where('status.status', 1)->count()}}</td>
                  </tr>
                  <tr>
                    <td class="text-right">Rejected</td>
                    <td>{{$groups->where('status.status', -2)->count()}}</td>
                  </tr>
                  <tr>
                    <td class="text-right">Progress</td>
                    <td>{{$groups->where('status.status', 2)->count()}}</td>
                  </tr>
                  <tr>
                    <td class="text-right">Finished</td>
                    <td>{{$groups->where('status.status', 3)->count()}}</td>
                  </tr>
                  <tr class="active">
                    <td class="text-right"><strong>Total</strong></td>
                    <td><strong>{{$groups->count()}}</strong></td>
                  </tr>
                </table>
              </div>  
            </div>
          @endif
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">Perusahaan</div>
        @if ($corps->count() == 0)
          <div class="panel-body">Tidak ada data perusahaan.</div>
        @else
          <table class="table">
            <tr>
              <th>Nama</th>
              <th>Kota</th>
              <th class="text-center">Jumlah</th>
            </tr>
            @foreach ($corps as $corp)
              <tr>
                <td>{{$corp->name}}</td>
                <td>{{$corp->city}}</td>
                <td class="text-center">{{$corp->groups->count()}}</td>
              </tr>
            @endforeach
            <tr class="active">
              <td colspan="2"><strong>Total</strong></td>
              <td class="text-center"><strong>{{App\Corporation::total()}}</strong></td>
            </tr>
          </table>
        @endif
      </div>
    </div>
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          Dosen Pembimbing
          <a class="btn btn-default btn-xs" role="button" data-toggle="collapse" href=".dsn" aria-expanded="false" aria-controls="dosen-collapse">
            Lihat Semua
          </a>
        </div>
        <table class="table">
          <tr>
            <th>Nama</th>
            <th class="text-center">Jumlah</th>
          </tr>
          @foreach ($lects->take(10) as $dosen)
            <tr>
              <td>{{$dosen->initial}} - {{$dosen->name}}</td>
              <td class="text-center">{{$dosen->lect_count}}</td>
            </tr>
          @endforeach
          @foreach ($lects->slice(10) as $dosen)
            <tr class="dsn collapse">
              <td>{{$dosen->initial}} - {{$dosen->name}}</td>
              <td class="text-center">{{$dosen->lect_count}}</td>
            </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
@endsection

@section('js')  
  {!! HTML::script('public/js/raphael-min.js') !!}
  {!! HTML::script('public/js/morris.min.js') !!}
  <script>
    new Morris.Donut({
      // ID of the element in which to draw the chart.
      element: 'myfirstchart',
      // Chart data records -- each entry in this array corresponds to a point on
      // the chart.
      colors: ["#337ab7", "#5cb85c","#5bc0de","#f0ad4e","#d9534f", "#ff69b4"],
      formatter: function(y, data) {
        return y + ' | ' + Math.round(10000*y/{{$groups->count()}})/100+'%';
      },
      data: [
        @if (($c = $groups->where('status.status', 0)->count()) != 0)
          {label: "Created", value: {{$c}}},
        @endif
        @if (($c = $groups->where('status.status', -1)->count()) != 0)
          {label: "Denied", value: {{$c}}},
        @endif
        @if (($c = $groups->where('status.status', 1)->count()) != 0)
          {label: "Confirmed", value: {{$c}}},
        @endif
        @if (($c = $groups->where('status.status', -2)->count()) != 0)
          {label: "Rejected", value: {{$c}}},
        @endif
        @if (($c = $groups->where('status.status', 2)->count()) != 0)
          {label: "Progress", value: {{$c}}},
        @endif
        @if (($c = $groups->where('status.status', 3)->count()) != 0)
          {label: "Finished", value: {{$c}}},
        @endif
      ],
    });
  </script>
@endsection