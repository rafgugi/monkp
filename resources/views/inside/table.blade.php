@extends('inside.app')

@section('content')
  <h1>List Mahasiswa Mengambil KP{{date('Y-m-d')}}</h1>
  <div id="alert-container"></div>
  @if (sizeof($members) < 1)
    <div class="panel panel-default">
      <div class="panel-body">Tidak ada kelompok KP.</div>
    </div>
  @else
    <p class="">
      <a href="{{url('table/export')}}" class="btn btn-success">Export All</a>
    </p>
    <div class="panel panel-default">
      <div class="table-responsive">
        <table class="table table-bordered">
          <tr>
            <th nowrap>Nama</th>
            <th nowrap>NRP</th>
            <th nowrap>Kelompok</th>
            <th nowrap>Mulai</th>
            <th nowrap>Selesai</th>
            <th nowrap>Dosen Pembimbing</th>
            <th nowrap>Perusahaan</th>
            <th nowrap>Pembimbing Lapangan</th>
            <th nowrap class="text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NI&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th nowrap class="text-center">&nbsp;&nbsp;&nbsp;&nbsp;NE&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th nowrap class="text-center">&nbsp;&nbsp;&nbsp;&nbsp;ND&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th nowrap class="text-center">&nbsp;&nbsp;&nbsp;&nbsp;NB&nbsp;&nbsp;&nbsp;&nbsp;</th>
            <th nowrap class="text-center"></th>
          </tr>
          @foreach ($members->slice(($members->currentPage() - 1) * $members->perPage(), $members->perPage()) as $member)
            <tr>
              <td nowrap>{{$member->student->name}}</td>
              <td nowrap>{{$member->student->nrp}}</td>
              <td nowrap>{{$member->group->id}} ({{$member->group->status['name']}})</td>
              <td nowrap>{{$member->group->start_date}}</td>
              <td nowrap>{{$member->group->end_date}}</td>
              <td nowrap>{{$member->group->lecturer == null ? '-' : $member->group->lecturer->name}}</td>
              <td nowrap>{{$member->group->corporation->name_city}}</td>
              <td nowrap>{{$member->group->mentor == null ? '-' : $member->group->mentor->name}}</td>
              @if ($member->group->status['status'] != 2)
                <td class="text-center">
                  {{$member->grade == null ? '-' : $member->grade->lecturer_grade}}
                </td>
                <td class="text-center">
                  {{$member->grade == null ? '-' : $member->grade->mentor_grade}}
                </td>
                <td class="text-center">
                  {{$member->grade == null ? '-' : $member->grade->discipline_grade}}
                </td>
                <td class="text-center">
                  {{$member->grade == null ? '-' : $member->grade->report_status}}
                </td>
              @else
                <td class="text-center">
                  <input type="text" class="form-control" id="lecturer_grade{{$member->id}}" value="{{$member->grade == null ? '' : $member->grade->lecturer_grade}}">
                </td>
                <td class="text-center">
                  <input type="text" class="form-control" id="mentor_grade{{$member->id}}" value="{{$member->grade == null ? '' : $member->grade->mentor_grade}}">
                </td>
                <td class="text-center">
                  <input type="text" class="form-control" id="discipline_grade{{$member->id}}" value="{{$member->grade == null ? '' : $member->grade->discipline_grade}}">
                </td>
                <td class="text-center">
                  <input type="text" class="form-control" id="report_status{{$member->id}}" value="{{$member->grade == null ? '' : $member->grade->report_status}}">
                </td>
              @endif
              <td><button type="button" class="btn btn-primary" onclick="save({{$member->id}})">Save</button></td>
            </tr>
          @endforeach
        </table>
      </div>
    </div>
    {!!$members->render()!!}
  @endif
@endsection

@section('js')
  <script>
    function niceAlert(msg) {
      $("#alert-container").html(
        '<div class="alert alert-'+ msg.alert +' alert-dismissible" role="alert">'
          + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
          + msg.body + '</div>'
      );
    }

    function save(id) { // member id
      $.ajax({
        type: "GET",
        dataType: "json",
        data: {
          lecturer_grade: $("#lecturer_grade"+id).val(),
          mentor_grade: $("#mentor_grade"+id).val(),
          discipline_grade: $("#discipline_grade"+id).val(),
          report_status: $("#report_status"+id).val()
        },
        url: "{{url('table/grading')}}/" + id,
        success: function(data){
          console.log(data);
          niceAlert(data);
        },
        error: function(data) {
          console.log(data);
          niceAlert({alert: 'danger', body: data});
        }
      });
    }
  </script>
@endsection