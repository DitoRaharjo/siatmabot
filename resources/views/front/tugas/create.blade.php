@extends('front.template')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Tambah Jadwal</h3>
      </div>
    </div>
    <div class="clearfix"></div>

    <div class="col-md-12 col-sm-12 col-xs-12">
      @if(count($errors)>0)
      <div class="x_panel">
        <h2><font size="5" color="red"><b>Maaf data gagal disimpan, berikut error yang terjadi : </b></font></h2>
        <ul>
          @foreach($errors->all() as $error)
            <li><font size="3">{{ $error }}</font></li>
          @endforeach
        </ul>
      </div>
      @endif

      <div class="x_panel">
        <!------------------------------------------FORM INPUT DATA-------------->
        <form name="formCreateJadwal" action="{{ route('jadwal.store') }}" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
          {{ csrf_field() }}
        <div class="x_title"> <!-------------------------------------------------------FORM ARTIKEL---------------------------->
          <h2>Form Jadwal <small>Detail-detail jadwal</small></h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />

          <input type="hidden" name="sesi_id" class="form-control" placeholder="ID Sesi" value="{{ $sesi_id }}">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Mata Kuliah</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="makul" class="form-control" placeholder="Nama Mata Kuliah" required="">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kata Kunci</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="keyword" class="form-control" placeholder="Kata Kunci Untuk Memanggil Mata Kuliah Di Telegram" required="">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kelas</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="kelas" class="form-control" placeholder="Kelas" required="">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ruangan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="ruangan" class="form-control" placeholder="Ruangan Kuliah" required="">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sesi
            </label>
            <div class="col-md-2 col-sm-6 col-xs-12">
              <input type="text" name="hari" class="form-control" placeholder="Hari" disabled="" value="{{ $hari }}">
              <input type="hidden" name="hari" class="form-control" placeholder="Hari" value="{{ $hari }}">
            </div>
            <label class="control-label col-md-1 col-sm-3 col-xs-12">Mulai</label>
            <div class="col-md-1 col-sm-6 col-xs-12">
              <input type="text" name="sesiMulai" class="form-control" placeholder="Sesi" disabled="" value="{{ $sesi }}">
              <input type="hidden" name="sesiMulai" class="form-control" placeholder="Sesi" value="{{ $sesi }}">
            </div>
            <label class="control-label col-md-1 col-sm-3 col-xs-12">Selesai </label>
            <div class="col-md-1 col-sm-6 col-xs-12">
              <select class="select2_singleSesi form-control" name="sesiSelesai">
                <option></option>
                @for($counter = 1;$counter<=5;$counter++)
                  @if($counter > $sesi)
                  <option value="{{ $counter }}">{{ $counter }}</option>
                  @endif
                @endfor
              </select>
            </div>
          </div>

        </div>

        <div class="x_title">
          <div class="clearfix"></div>
        </div>

          <div class="col-md-2 col-sm-12 col-xs-12 form-group">

          </div>
          <div class="col-md-2 col-sm-12 col-xs-12 form-group">

          </div>
          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <a class="btn btn-primary btn-lg" href="{{ Route('jadwal.index') }}">Batal</a>
          </div>
          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
              <button type="submit" class="btn btn-success btn-lg">Simpan</button>
          </div>
          <div class="col-md-2 col-sm-12 col-xs-12 form-group">

          </div>
        </form> <!--------------------------------------------------------------------------------PENUTUP FORM------------------>
        </div>




      </div> <!---------------------------------------------DIV CONTENT---------------------------->
    </div>

  </div>
</div>
<!-- /page content -->
@endsection

@section('custom_script')
<!-- Select2 -->
<script>
  $(document).ready(function() {
    $(".select2_singleSesi").select2({
      placeholder: "Sesi",
      allowClear: true
    });
  });
</script>
<!-- /Select2 -->
@endsection
