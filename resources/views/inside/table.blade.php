@extends('inside.app')

@section('content')
  <h1>Dashboard</h1>
  <div class="panel panel-default">
    <div class="panel-body">
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
            <th nowrap class="text-center">NI</th>
            <th nowrap class="text-center">NE</th>
            <th nowrap class="text-center">ND</th>
            <th nowrap class="text-center">NB</th>
            <th nowrap class="text-center"></th>
          </tr>
          @foreach ($members as $member)
            <tr>
              <td nowrap>{{$member->student->name}}</td>
              <td nowrap>{{$member->student->nrp}}</td>
              <td nowrap>{{$member->group->id}} ({{$member->group->status_string}})</td>
              <td nowrap>{{$member->group->start_date}}</td>
              <td nowrap>{{$member->group->end_date}}</td>
              <td nowrap>{{$member->group->lecturer == null ? '-' : $member->group->lecturer->name}}</td>
              <td nowrap>{{$member->group->corporation->name_city}}</td>
              <td nowrap>{{$member->group->mentor == null ? '-' : $member->group->mentor->name}}</td>
              <td class="text-center">{{$member->group->grade == null ? '-' : $member->group->grade->lecturer_grade}}</td>
              <td class="text-center">{{$member->group->grade == null ? '-' : $member->group->grade->mentor_grade}}</td>
              <td class="text-center">{{$member->group->grade == null ? '-' : $member->group->grade->discipline_grade}}</td>
              <td class="text-center">{{$member->group->grade == null ? '-' : $member->group->grade->report_status}}</td>
              <td><a href="#" class="btn btn-info">Edit</a></td>
            </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
@endsection