@extends('app')

@section('content')
  <h1>Pengajuan
  <small>Welcome, J</small></h1>
  <div class="panel panel-default">
    <div class="panel-heading">
      <ul class="nav nav-pills" role="tablist">
        <li role="presentation" class="active">
          <a href="#perusahaan" aria-controls="perusahaan" role="tab" data-toggle="tab">Perusahaan</a>
        </li>
        <li role="presentation">
          <a href="#pengajuan" aria-controls="pengajuan" role="tab" data-toggle="tab">Pengajuan</a>
        </li>
      </ul>
    </div>
    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="perusahaan">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Perusahaan</label>
                <select class="form-control" id="perusahaan">
                  <option value="1">Perusahaan ABC</option>
                  <option value="2">Perusahaan CDE</option>
                </select>
              </div>
              <div class="form-group">
                <label>Nama Perusahaan</label>
                <input type="text" class="form-control" name="corporation[name]">
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <input type="text" class="form-control" name="corporation[address]">
              </div>
              <div class="form-group">
                <label>Kota</label>
                <input type="text" class="form-control" name="corporation[city]">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Kode Pos</label>
                <input type="text" class="form-control" name="corporation[post_code]">
              </div>
              <div class="form-group">
                <label>Telp Kantor</label>
                <input type="text" class="form-control" name="corporation[telp]">
              </div>
              <div class="form-group">
                <label>Fax Kantor</label>
                <input type="text" class="form-control" name="corporation[fax]">
              </div>
              <div class="form-group">
                <label>Jenis Bisnis</label>
                <input type="text" class="form-control" name="corporation[business_type]">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Profil</label>
                <textarea class="form-control" rows="4" name="corporation[description]"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="panel-footer text-right">
          <a href="#pengajuan" class="btn btn-default" aria-controls="pengajuan" role="tab" data-toggle="tab">Next</a>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane" id="pengajuan">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Periode Awal</label>
                <input type="date" class="form-control" name="group[start_date]">
              </div>
              <div class="form-group">
                <label>Periode Akhir</label>
                <input type="date" class="form-control" name="group[end_date]">
              </div>
            </div>
          </div>
        </div>
        <div class="panel-footer text-right">
          <button class="btn btn-success">Submit</button>
        </div>
      </div>
    </div>
  </div>
@endsection