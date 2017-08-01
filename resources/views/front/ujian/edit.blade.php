@extends('front.template')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Edit Jadwal</h3>
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
        <form name="formEditJadwal" action="{{ route('jadwal.update', $jadwal->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" name="_method" value="PATCH">
        <div class="x_title"> <!-------------------------------------------------------FORM ARTIKEL---------------------------->
          <h2>Form Jadwal <small>Detail-detail jadwal</small></h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Mata Kuliah</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="makul" class="form-control" placeholder="Nama Mata Kuliah" required="" value="{{ $jadwal->makul }}">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kata Kunci</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="keyword" class="form-control" placeholder="Kata Kunci Untuk Memanggil Mata Kuliah Di Telegram" required="" value="{{ $jadwal->keyword }}">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kelas</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="kelas" class="form-control" placeholder="Kelas" required="" value="{{ $jadwal->kelas }}">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ruangan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="ruangan" class="form-control" placeholder="Ruangan Kuliah" required="" value="{{ $jadwal->ruangan }}">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sesi
            </label>
            <div class="col-md-2 col-sm-6 col-xs-12">
              <input type="text" name="hari" class="form-control" placeholder="Hari" disabled="" value="{{ $jadwal->sesi->sesi->hari }}">
              <input type="hidden" name="hari" class="form-control" placeholder="Hari" value="{{ $jadwal->sesi->sesi->hari }}">
            </div>
            <label class="control-label col-md-1 col-sm-3 col-xs-12">Mulai</label>
            <div class="col-md-1 col-sm-6 col-xs-12">
              <input type="text" name="sesiMulai" class="form-control" placeholder="Sesi" disabled="" value="{{ $jadwal->sesi->sesi->sesi }}">
              <input type="hidden" name="sesiMulai" class="form-control" placeholder="Sesi" value="{{ $jadwal->sesi->sesi->sesi }}">
            </div>
            <label class="control-label col-md-1 col-sm-3 col-xs-12">Selesai </label>
            <div class="col-md-1 col-sm-6 col-xs-12">
              <select class="select2_singleSesi form-control" name="sesiSelesai">
                @if($jadwal->sesi_prodi_id_selesai != 0)
                  <option value="{{ $jadwal->sesiSelesai->sesi->sesi }}">{{ $jadwal->sesiSelesai->sesi->sesi }}</option>
                  @for($counter = 1;$counter<=5;$counter++)
                    @if($counter > $jadwal->sesiSelesai->sesi->sesi)
                      <option value="{{ $counter }}">{{ $counter }}</option>
                    @endif
                  @endfor
                @else
                <option></option>
                @for($counter = 1;$counter<=5;$counter++)
                  @if($counter > $jadwal->sesiSelesai->sesi->sesi)
                    <option value="{{ $counter }}">{{ $counter }}</option>
                  @endif
                @endfor
                @endif
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
