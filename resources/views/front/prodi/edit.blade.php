@extends('front.template')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Edit Program Studi</h3>
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
        <form name="formEditProdi" action="{{ route('prodi.update', $prodi->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" name="_method" value="PATCH">
        <div class="x_title"> <!-------------------------------------------------------FORM ARTIKEL---------------------------->
          <h2>Form Program Studi <small>Detail-detail program studi</small></h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />




            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Program Studi</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="nama" class="form-control" placeholder="Nama Program Studi" required="" value="{{ $prodi->nama }}">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Fakultas
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="select2_single form-control" required="" name="fakultas_id">
                  @foreach($semuaFakultas as $fakultas)
                    @if($prodi->fakultas_id == $fakultas->id)
                      @if($fakultas->deleted_at != NULL)
                        <option value="-1">Fakultas Sudah Dihapus</option>
                      @else
                        <option value="{{ $fakultas->id }}">{{ $fakultas->nama }}</option>
                      @endif
                    @endif
                  @endforeach
                  @foreach($semuaFakultas as $fakultas)
                    @if($prodi->fakultas_id != $fakultas->id)
                      @if($fakultas->deleted_at == NULL)
                        <option value="{{ $fakultas->id }}">{{ $fakultas->nama }}</option>
                      @endif
                    @endif
                  @endforeach
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
            <a class="btn btn-primary btn-lg" href="{{ Route('prodi.index') }}">Batal</a>
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
    $(".select2_single").select2({
      placeholder: "Pilih fakultas",
      allowClear: true
    });
  });
</script>
<!-- /Select2 -->
@endsection
