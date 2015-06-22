@extends('inside.app')

@section('js')
  <script>
    var corps = {!!$corps!!};
    $(document).ready(function(){
      // fill corporation dropdown
      for (var i = corps.length - 1; i >= 0; i--) {
        c = corps[i];
        $("#corporation").append('<option value="'+c.id+'">'+c.name_city+'</option>');
      };
      // add onChange event
      $("#corporation").change(function(){
        if ($(this).val() != 0) {
          var c;
          for (var i = 0; i < corps.length; i++) {
            if (corps[i].id == $(this).val()) {
              c = corps[i];
            }
          };
          $("#corpname").val(c.name);
          $("#corpaddress").val(c.address);
          $("#corpcity").val(c.city);
          $("#corppost_code").val(c.post_code);
          $("#corptelp").val(c.telp);
          $("#corpfax").val(c.fax);
          $("#corpbusiness_type").val(c.business_type);
          $("#corpdescription").val(c.description);
        } else {
          $("#corpname").val("");
          $("#corpaddress").val("");
          $("#corpcity").val("");
          $("#corppost_code").val("");
          $("#corptelp").val("");
          $("#corpfax").val("");
          $("#corpbusiness_type").val("");
          $("#corpdescription").val("");
        }
      });
    });
  </script>
@endsection

@section('content')
  <h1>Pengajuan</h1>
  <form method="post" action="{{url('pengajuan')}}">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Perusahaan</label>
              <select class="form-control" id="corporation">
                <option value="0">-</option>
              </select>
            </div>
            <div class="form-group">
              <label>Nama Perusahaan</label>
              <input type="text" class="form-control" id="corpname" name="corporation[name]">
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <input type="text" class="form-control" id="corpaddress" name="corporation[address]">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Kota</label>
              <input type="text" class="form-control" id="corpcity" name="corporation[city]">
            </div>
            <div class="form-group">
              <label>Kode Pos</label>
              <input type="text" class="form-control" id="corppost_code" name="corporation[post_code]">
            </div>
            <div class="form-group">
              <label>Telp Kantor</label>
              <input type="text" class="form-control" id="corptelp" name="corporation[telp]">
            </div>
            <div class="form-group hidden">
              <label>Fax Kantor</label>
              <input type="text" class="form-control" id="corpfax" name="corporation[fax]">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Jenis Bisnis</label>
              <input type="text" class="form-control" id="corpbusiness_type" name="corporation[business_type]">
            </div>
            <div class="form-group">
              <label>Profil</label>
              <textarea class="form-control" rows="4" id="corpdescription" name="corporation[description]"></textarea>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Tanggal Mulai</label>
              <input type="date" data-provide="datepicker" class="datepicker form-control" name="group[start_date]">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Tanggal Selesai</label>
              <input type="date" data-provide="datepicker" class="datepicker form-control" name="group[end_date]">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Kelompok</label>
              <select class="form-control" name="friend">
                <option value="0">-</option>
                  @foreach ($students as $student)
                    <option value="{{$student->id}}">{{$student->name}}</option>
                  @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="panel-footer text-right">
        <button class="btn btn-success">Submit</button>
      </div>
    </div>
  </form>
@endsection