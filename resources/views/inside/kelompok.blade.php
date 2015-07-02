@extends('inside.app')

@section('css')
  <style>
    .hidden-row {
      padding: 0px !important; 
    }
    .hidden-row > div:first-child {
      padding: 8px;
    }
    .form-horizontal .control-text {
      padding-top: 7px;
    }
  </style>
@endsection

@section('content')
  <h1>Dashboard</h1>
  <div id="alert-container"></div>
  <div class="panel panel-default">
    <div class="panel-heading">
      List Kelompok
    </div>
    @if (sizeof($groups) < 1)
      <div class="panel-body">Tidak ada kelompok KP.</div>
    @else
      <table class="table table-striped table-hover">
        <tr>
          <th>Status</th>
          <th>Peserta</th>
          <th>Perusahaan</th>
        </tr>
        @foreach ($groups as $group)
          <tr data-toggle="collapse" data-target="#clps{{$group->id}}" class="accordion-toggle" title="klik untuk lihat detail">
            <td>
              <span title="{{$group->status['desc']}}">{{strtoupper($group->status['name'])}}</span>
            </td>
            <td>
              {{$group->students->get(0)->name}}
              @if (sizeof($group->students) > 1)
                - {{$group->students->get(1)->name}}
              @endif
            </td>
            <td>{{$group->corporation->name_city}}</td>
          </tr>
          <tr>
            <td colspan="3" class="hidden-row">
              <div class="accordion-body collapse" id="clps{{$group->id}}">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-horizontal">
                      <div class="form-group">
                        <label class="col-md-5 control-label">Status KP</label>
                        <div class="col-md-7">
                          <select class="form-control input-sm" id="status{{$group->id}}" onchange="change({{$group->id}})">
                            <option value="{{$group->status['status']}}">
                              {{strtoupper($group->status['name'])}}
                              ({{$group->status['desc']}})
                            </option>
                            @if (Auth::user()->role != 'STUDENT')
                              @foreach ($group->status['changeto'] as $s)
                                <option value="{{$group->getStatusAttribute($s)['status']}}">
                                  {{strtoupper($group->getStatusAttribute($s)['name'])}}
                                  ({{$group->getStatusAttribute($s)['desc']}})
                                </option>
                              @endforeach
                            @endif
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-5 control-label">Dosen Pembimbing</label>
                        <div class="col-md-7 control-text" id="dosentext{{$group->id}}">
                          {{$group->lecturer == null ? '-' : $group->lecturer->name}}
                        </div>
                        @if (Auth::user()->role != 'STUDENT')
                          <div class="col-md-7" id="dosenselect{{$group->id}}">
                            <select class="form-control input-sm" id="dosen{{$group->id}}">
                              <option value="-">-- PILIH DOSEN PEMBIMBING --</option>
                              @foreach ($lecturers as $l)
                                <option value="{{$l->id}}">
                                  {{$l->initial}} - {{$l->name}} ({{$l->groups->count()}})
                                </option>
                              @endforeach
                            </select>
                          </div>
                        @endif
                      </div>
                    </div> 
                  </div>
                  <div class="col-md-6">
                    <div class="form-horizontal">
                      <div class="form-group">
                        <label class="col-md-5 control-label">Tanggal Mulai</label>
                        <div class="col-md-7 control-text">
                          <strong class="control-text">{{$group->start_date}}</strong>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-5 control-label">Tanggal Selesai</label>
                        <div class="col-md-7 control-text">
                          <strong class="control-text">{{$group->end_date}}</strong>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-offset-3">
                  @if (Auth::user()->role != 'STUDENT')
                    <button type="button" class="btn btn-primary" onclick="save({{$group->id}})">Save</button>
                  @endif
                  @if ($group->status['status'] == 0)
                    <a href="{{url('pengajuan/destroy/'.$group->id)}}" class="btn btn-danger">
                      Hapus
                    </a>
                  @endif
                </div>
              </div>
            </td>
          </tr>
        @endforeach
      </table>
    @endif
  </div>
@endsection

@section('js')
  @if (Auth::user()->role != 'STUDENT')
  <script>
    function niceAlert(msg) {
      $("#alert-container").html(
        '<div class="alert alert-'+ msg.alert +' alert-dismissible" role="alert">'
          + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
          + msg.body + '</div>'
      );
    }

    function change(id) {
      if ($("#status" + id).val() == 2) { // jika statusnya 'progress'
        $("#dosenselect{{$group->id}}").removeClass("hidden");
        $("#dosentext{{$group->id}}").addClass("hidden");
      } else {
        $("#dosenselect{{$group->id}}").addClass("hidden");
        $("#dosentext{{$group->id}}").removeClass("hidden");
      }
    }

    function save(id) {
      var status = $("#status"+id).val();
      var dosen = $("#dosen"+id).val();
      $.ajax({
        type: "GET",
        dataType: "json",
        data: {
          dosen: $("#dosen"+id).val(),
          status: $("#status"+id).val()
        },
        url: "{{url('pengajuan/update')}}/" + id + '/' + status + '/' + dosen,
        success: function(data){
          niceAlert(data);
        },
        error: function(data) {
          niceAlert({alert: 'danger', body: 'Failed to fetch data via ajax.'});
        }
      });
    }

    $(document).ready(function() {
      @foreach ($groups as $group)
        // kalau status group itu 2, maka tampilkan dropdown dosen.
        @if ($group->status['status'] != 2)
          $("#dosenselect{{$group->id}}").addClass("hidden");
        @else
          $("#dosentext{{$group->id}}").addClass("hidden");
        @endif
        // default isi dosen nya
        @if ($group->lecturer != null)
          $("#dosen{{$group->id}}").val({{$group->lecturer->id}});
        @endif
      @endforeach
    });
  </script>
  @endif
@endsection