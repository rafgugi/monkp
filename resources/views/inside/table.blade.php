@extends('inside.app')

@section('content')
  <h1>List Mahasiswa Mengambil KP</h1>
  <div id="alert-container"></div>
  <div class="panel panel-default">
    @if (sizeof($members) < 1)
      <div class="panel-body">Tidak ada kelompok KP.</div>
    @else
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
          @foreach ($members as $member)
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
                  {{$member->group->grade == null ? '-' : $member->group->grade->lecturer_grade}}
                </td>
                <td class="text-center">
                  {{$member->group->grade == null ? '-' : $member->group->grade->mentor_grade}}
                </td>
                <td class="text-center">
                  {{$member->group->grade == null ? '-' : $member->group->grade->discipline_grade}}
                </td>
                <td class="text-center">
                  {{$member->group->grade == null ? '-' : $member->group->grade->report_status}}
                </td>
              @else
                <td class="text-center">
                  <input type="text" class="form-control" name="lecturer_grade" value="{{$member->group->grade == null ? '' : $member->group->grade->lecturer_grade}}">
                </td>
                <td class="text-center">
                  <input type="text" class="form-control" name="mentor_grade" value="{{$member->group->grade == null ? '' : $member->group->grade->mentor_grade}}">
                </td>
                <td class="text-center">
                  <input type="text" class="form-control" name="discipline_grade" value="{{$member->group->grade == null ? '' : $member->group->grade->discipline_grade}}">
                </td>
                <td class="text-center">
                  <input type="text" class="form-control" name="report_status" value="{{$member->group->grade == null ? '' : $member->group->grade->report_status}}">
                </td>
              @endif
              <td><a href="#" class="btn btn-info">Edit</a></td>
            </tr>
          @endforeach
        </table>
      </div>
    @endif
  </div>
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
@endsection