@extends('inside.app')

@section('content')
  <h1>List Mahasiswa Mengambil KP</h1>
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
  </div>
@endsection