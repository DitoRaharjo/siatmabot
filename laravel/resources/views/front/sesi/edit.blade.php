@extends('front.template')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Edit Sesi</h3>
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
        <form name="formCreateSesi" action="{{ route('sesi.update', $sesi->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" name="_method" value="PATCH">
        <div class="x_title"> <!-------------------------------------------------------FORM ARTIKEL---------------------------->
          <h2>Form Sesi <small>Detail-detail sesi</small></h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Hari
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="select2_singleHari form-control" required="" name="hari">
                <option value="{{ $sesi->hari }}">{{ $sesi->hari }}</option>
                @if($sesi->hari != "Senin")
                <option value="Senin">Senin</option>
                @endif
                @if($sesi->hari != "Selasa")
                <option value="Selasa">Selasa</option>
                @endif
                @if($sesi->hari != "Rabu")
                <option value="Rabu">Rabu</option>
                @endif
                @if($sesi->hari != "Kamis")
                <option value="Kamis">Kamis</option>
                @endif
                @if($sesi->hari != "Jumat")
                <option value="Jumat">Jumat</option>
                @endif
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sesi</label>
            <div class="col-md-6 col-sm-6 col-xs-12"><select class="select2_singleSesi form-control" required="" name="sesi">
                <option value="{{ $sesi->sesi }}">{{ $sesi->sesi }}</option>
                @for($counter = 1;$counter<=5;$counter++)
                  @if($counter != $sesi->sesi)
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
            <a class="btn btn-primary btn-lg" href="{{ Route('sesi.index') }}">Batal</a>
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
    $(".select2_singleHari").select2({
      placeholder: "Pilih hari",
      allowClear: true
    });
    $(".select2_singleSesi").select2({
      placeholder: "Pilih sesi",
      allowClear: true
    });
  });
</script>
<!-- /Select2 -->
@endsection
