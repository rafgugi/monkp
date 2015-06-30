@extends('inside.app')

@section('css')
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endsection

@section('js')  
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <script>
    new Morris.Donut({
      // ID of the element in which to draw the chart.
      element: 'myfirstchart',
      // Chart data records -- each entry in this array corresponds to a point on
      // the chart.
      colors: ["#337ab7", "#5cb85c","#5bc0de","#f0ad4e","#d9534f"],
      formatter: function(y, data) { return y+' | '+100*y/{{$groups->count()}}+'%' },
      data: [
        @if (($c = $groups->where('status', 0)->count()) != 0)
          {label: "Created", value: {{$c}}},
        @endif
        @if (($c = $groups->where('status', -1)->count()) != 0)
          {label: "Denied", value: {{$c}}},
        @endif
        @if (($c = $groups->where('status', 1)->count()) != 0)
          {label: "Confirmed", value: {{$c}}},
        @endif
        @if (($c = $groups->where('status', -2)->count()) != 0)
          {label: "Rejected", value: {{$c}}},
        @endif
        @if (($c = $groups->where('status', 2)->count()) != 0)
          {label: "Progress", value: {{$c}}},
        @endif
        @if (($c = $groups->where('status', 3)->count()) != 0)
          {label: "Finished", value: {{$c}}},
        @endif
      ],
    });
  </script>
@endsection

@section('content')
  <h1>Statistic</h1>
  <div class="row">
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">Kelompok Kerja Praktik</div>
        <div class="panel-body">
          @if ($groups->count() == 0)
            Tidak ada kelompok KP
          @else
            <div id="myfirstchart" style="height: 250px;"></div>
            <a class="btn btn-default btn-block" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              View Details
            </a>
            <div class="collapse" id="collapseExample">
              <table class="table table-condensed table-hover">
                <tr>
                  <th>Status</th>
                  <th class="text-center">Count</th>
                </tr>
                <tr>
                  <td>Created</td>
                  <td class="text-center">{{$groups->where('status', 0)->count()}}</td>
                </tr>
                <tr>
                  <td>Denied</td>
                  <td class="text-center">{{$groups->where('status', -1)->count()}}</td>
                </tr>
                <tr>
                  <td>Confirmed</td>
                  <td class="text-center">{{$groups->where('status', 1)->count()}}</td>
                </tr>
                <tr>
                  <td>Rejected</td>
                  <td class="text-center">{{$groups->where('status', -2)->count()}}</td>
                </tr>
                <tr>
                  <td>Progress</td>
                  <td class="text-center">{{$groups->where('status', 2)->count()}}</td>
                </tr>
                <tr>
                  <td>Finished</td>
                  <td class="text-center">{{$groups->where('status', 3)->count()}}</td>
                </tr>
                <tr class="active">
                  <td><strong>Total</strong></td>
                  <td class="text-center"><strong>{{$groups->count()}}</strong></td>
                </tr>
              </table>
            </div>
          @endif
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">Perusahaan</div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th>Nama</th>
                <th>Kota</th>
                <th>Count</th>
              </tr>
              @foreach ($corps as $corp)
                <tr>
                  <td>{{$corp->name}}</td>
                  <td>{{$corp->city}}</td>
                  <td>{{$corp->groups->count()}}</td>
                </tr>
              @endforeach
              <tr class="active">
                <td colspan="2"><strong>Total</strong></td>
                <td class="text-center"><strong>{{$corps->count()}}</strong></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">Dosen Pembimbing</div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th>Nama</th>
                <th>Count</th>
              </tr>
              @foreach ($dosens as $dosen)
                <tr>
                  <td>{{$dosen->initial}} - {{$dosen->name}}</td>
                  <td>{{$dosen->groups->count()}}</td>
                </tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection