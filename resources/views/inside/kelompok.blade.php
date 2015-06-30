@extends('inside.app')

@section('css')
<style>
  .hidden-row {
    padding: 0px !important; 
  }
  .hidden-row > div:first-child {
    padding: 8px;
  }
</style>
@endsection

@section('content')
  <h1>Dashboard</h1>
  <div class="panel panel-default">
    <div class="panel-heading">
      <ul class="nav nav-pills" role="tablist">
        <!--li role="presentation" class="active"><a href="#kp" aria-controls="kp" role="tab" data-toggle="tab">KP</a></li-->
        <li role="presentation" class="active"><a href="#list" aria-controls="list" role="tab" data-toggle="tab">List KP</a></li>
        <li role="presentation"><a href="#nilai" aria-controls="nilai" role="tab" data-toggle="tab">Nilai KP</a></li>
      </ul>
    </div>
    <!-- Tab panes -->
    <div class="tab-content">
      <!--div role="tabpanel" class="tab-pane active" id="kp">
        <div class="panel-body">
          <div class="row">
            <p class="col-md-3 text-right"><strong>Status</strong></p>
            <p class="col-md-3">-</p>
            <p class="col-md-3 text-right"><strong>Tempat KP</strong></p>
            <p class="col-md-3">-</p>
          </div>
          <div class="row">
            <p class="col-md-3 text-right"><strong>Periode Awal</strong></p>
            <p class="col-md-3">-</p>
            <p class="col-md-3 text-right"><strong>Periode Akhir</strong></p>
            <p class="col-md-3">-</p>
          </div>
          <div class="row">
            <p class="col-md-3 text-right"><strong>Dosen Pembimbing</strong></p>
            <p class="col-md-3">-</p>
            <p class="col-md-3 text-right"><strong>Pembimbing Lapangan</strong></p>
            <p class="col-md-3">-</p>
          </div>
          <div class="row">
            <p class="col-md-3 text-right"><strong>Anggota</strong></p>
            <p class="col-md-3">-</p>
          </div>
        </div>
      </div-->
      <div role="tabpanel" class="tab-pane active" id="list">
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
                <td>{{$group->status_string}}</td>
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
                      <div class="col-md-2">
                        <strong>Status KP</strong>
                      </div>
                      <div class="col-md-4">
                        <select name="status" class="form-control input-sm">
                          @if ($group->status == 0)
                            <option value="-1">Tolak Pengajuan</option>
                            <option value="1">Terima Pengajuan</option>
                          @elseif ($group->status == 1)
                            <option value="-2">Ditolak Perusahaan</option>
                            <option value="2">Diterima Perusahaan</option>
                          @endif
                        </select>
                      </div>
                      <div class="col-md-2">
                        <strong>Dosen pembimbing</strong>
                      </div>
                      <div class="col-md-4">
                        @if ($group->lecturer != null)
                          {{$group->lecturer->name}}
                        @else
                          <select name="lecturer_id" class="form-control input-sm">
                            @foreach ($lecturers as $l)
                              <option value="{{$l->id}}">{{$l->initial}} - {{$l->name}} ({{$l->groups->count()}})</option>
                            @endforeach
                          </select>
                        @endif
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <strong>Tanggal Mulai</strong>
                      </div>
                      <div class="col-md-4"><strong>{{$group->start_date}}</strong></div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <strong>Tanggal Selesai</strong>
                      </div>
                      <div class="col-md-4"><strong>{{$group->end_date}}</strong></div>
                    </div>
                    <div class="row">
                    </div>
                    <p>
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal{{$group->id}}">
            Edit
          </button>
          @if ($group->status == 0)
            <a href="{{url('pengajuan/destroy/'.$group->id)}}" class="btn btn-danger">
              Hapus
            </a>
          @endif
      <div class="modal fade" id="modal{{$group->id}}" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              Ubah data kelompok
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="#">
                <div class="form-group">
                  <label class="col-sm-4 control-label">Dosen Pembimbing</label>
                  <div class="col-sm-6">
                    <select class="form-control" name="internal_id">
                      <option value="1">Radityo Anggoro</option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <button class="btn btn-default">Konfirm</button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Tanggal Mulai</label>
                  <div class="col-sm-6">
                    <input type="date" data-provide="datepicker" class="datepicker form-control">
                  </div>
                  <div class="col-sm-2">
                    <button class="btn btn-default">Konfirm</button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Tanggal Selesai</label>
                  <div class="col-sm-6">
                    <input type="date" data-provide="datepicker" class="datepicker form-control">
                  </div>
                  <div class="col-sm-2">
                    <button class="btn btn-default">Konfirm</button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Nilai Internal</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control">
                  </div>
                  <div class="col-sm-2">
                    <button class="btn btn-default">Konfirm</button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Nilai Lapangan</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control">
                  </div>
                  <div class="col-sm-2">
                    <button class="btn btn-default">Konfirm</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
                    </p>
                  </div>
                </td>
              </tr>
            @endforeach
          </table>
        @endif
      </div>
      <div role="tabpanel" class="tab-pane" id="nilai">
        <div class="panel-body">
          Nilai belum dapat diakses.
        </div>
      </div>
    </div>
  </div>
@endsection