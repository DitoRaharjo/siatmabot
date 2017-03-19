@extends('front.template')

@section('custom_css')
<!-- Untuk Hover Foto -->
<style type="text/css">
  .hovereffect {
  width:100%;
  height:100%;
  float:left;
  overflow:hidden;
  position:relative;
  text-align:center;
  cursor:default;
  }

  .hovereffect .overlay {
  width:100%;
  height:100%;
  position:absolute;
  overflow:hidden;
  top:0;
  left:0;
  opacity:0;
  background-color:rgba(0,0,0,0.5);
  -webkit-transition:all .4s ease-in-out;
  transition:all .4s ease-in-out
  }

  .hovereffect img {
  display:block;
  position:relative;
  -webkit-transition:all .4s linear;
  transition:all .4s linear;
  }

  .hovereffect h2 {
  text-transform:uppercase;
  color:#fff;
  text-align:center;
  position:relative;
  font-size:17px;
  background:rgba(0,0,0,0.6);
  -webkit-transform:translatey(-100px);
  -ms-transform:translatey(-100px);
  transform:translatey(-100px);
  -webkit-transition:all .2s ease-in-out;
  transition:all .2s ease-in-out;
  padding:10px;
  }

  .hovereffect a.info {
  text-decoration:none;
  display:inline-block;
  text-transform:uppercase;
  color:#fff;
  border:1px solid #fff;
  background-color:transparent;
  opacity:0;
  filter:alpha(opacity=0);
  -webkit-transition:all .2s ease-in-out;
  transition:all .2s ease-in-out;
  margin:50px 0 0;
  padding:7px 14px;
  }

  .hovereffect a.info:hover {
  box-shadow:0 0 5px #fff;
  }

  .hovereffect:hover img {
  -ms-transform:scale(1.2);
  -webkit-transform:scale(1.2);
  transform:scale(1.2);
  }

  .hovereffect:hover .overlay {
  opacity:1;
  filter:alpha(opacity=100);
  }

  .hovereffect:hover h2,.hovereffect:hover a.info {
  opacity:1;
  filter:alpha(opacity=100);
  -ms-transform:translatey(0);
  -webkit-transform:translatey(0);
  transform:translatey(0);
  }

  .hovereffect:hover a.info {
  -webkit-transition-delay:.2s;
  transition-delay:.2s;
  }
</style>
<!-- Untuk Hover Foto -->

<!-- Untuk Hide Upload -->
<style type="text/css">
#upload_link{
  text-decoration:none;
}
#upload{
  display:none
}
</style>
<!-- Untuk Hide Upload -->
@endsection

@section('content')
<div class="right_col" role="main">
        <div class="">

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

          <div class="page-title">
            <div class="title_left">
              <h3>Profile Pengguna</h3>
            </div>
          </div>

          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

              <div class="x_panel">
                <div class="x_title">
                  <h2>Profile Pengguna <small>Keterangan Lengkap Profile Pengguna</small></h2>

                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

                    <form id="demo-form4" action="{{ route('Profile.updatefoto', $pengguna->id) }}" method="POST" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
                      {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PATCH">

                    <div class="profile_img">
                      <!---------------------------------------------------------- PROFILE PICTURE --------------------->
                      <div id="crop-avatar">
                        <!-- Current avatar -->
                        <div class="hovereffect">
                            @if( $pengguna->image == NULL)
                              <img id="blah" class="img-responsive avatar-view" src="{{ asset('uploads/ProfilePicture/defaultprofile.png') }}" alt="Avatar" title="Change the avatar">
                            @else
                              <img id="blah" class="img-responsive avatar-view" src="{{ asset('uploads/ProfilePicture/'.$pengguna->image) }}" alt="Avatar" title="Change the avatar">
                            @endif
                            <div class="overlay">
                               <h2>Ganti Gambar Profile</h2>
                               <input id="upload" type="file" accept="image/png, image/jpeg, image/gif" name="image" onchange="readURL(this);">
                               <a id="upload_link" class="info" href="#">pilih foto</a>
                            </div>
                        </div>
                      </div>
                    </div>

                  </form>

                    <h10>(Disarankan Panjang : Lebar = 1 : 1)</h10>
                  </br>

                    <h3>{{ $pengguna->fullname }}</h3>

                    <ul class="list-unstyled user_data">
                      <li>
                        <i class="fa fa-briefcase user-profile-icon"></i> {{ $pengguna->role }}
                      </li>

                      <li class="m-top-xs">
                        <i class="fa fa-envelope user-profile-icon"></i>  {{ $pengguna->email }}
                      </li>
                    </ul>

                  </br>

                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">

                    <div class="profile_title">
                      <div class="col-md-6">
                        <h2>Detail pengguna</h2>
                      </div>
                    </div>

                  </br>
                  </br>


                  <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                      <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><span class="fa fa-user"></span> Profile</a>
                      </li>
                      <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><span class="fa fa-key"></span> Ubah Password</a>
                      </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                        <form id="demo-form2" action="{{ route('Profile.update', $pengguna->id) }}" method="POST" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
                          {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">

                        <!-------------------------------------------------------------------KATEGORI INDEX--------------------------->
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nama Lengkap
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="fullname" id="fullname" required="required" placeholder="Fullname" class="form-control col-md-7 col-xs-12" value="{{ $pengguna->fullname }}">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="email" id="email" name="email" required="required" placeholder="Email yang digunakan pada FB, LINE, dan Telegram" class="form-control col-md-7 col-xs-12" value="{{ $pengguna->email }}">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Telegram Username</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="telegram_username" class="form-control col-md-7 col-xs-12" type="text" name="telegram_username" placeholder="Telegram Username, ex : vincentiusdito, Without @ " value="{{ $pengguna->telegram_username }}">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">NPM</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="npm" class="form-control col-md-7 col-xs-12" type="number" placeholder="NPM" name="npm" required="required" value="{{ $pengguna->npm }}">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Program Studi</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="select2_group form-control" required="" name="prodi_id" tabindex="-1">
                              @foreach($semuaFakultas as $fakultas)
                                @if($fakultas->id == $fakultasId)
                                  @if($fakultas->deleted_at != NULL)
                                    <option value="-1">Fakultas sudah dihapus</option>
                                  @else
                                    <optgroup label="{{ $fakultas->nama }}">
                                      @foreach($semuaProdi as $prodi)
                                        @if($prodi->fakultas_id == $fakultas->id)
                                          @if($prodi->id == $prodiId)
                                            @if($prodi->deleted_at != NULL)
                                              <option value="-1">Prodi sudah dihapus</option>
                                            @else
                                              <option value="{{ $prodi->id }}">{{ $prodi->nama }}</option>
                                            @endif
                                          @endif
                                        @endif
                                      @endforeach

                                      @foreach($semuaProdi as $prodi)
                                        @if($prodi->fakultas_id == $fakultas->id)
                                          @if($prodi->id != $prodiId)
                                            @if($prodi->deleted_at == NULL)
                                              <option value="{{ $prodi->id }}">{{ $prodi->nama }}</option>
                                            @endif
                                          @endif
                                        @endif
                                      @endforeach
                                    </optgroup>
                                  @endif
                                @endif
                              @endforeach

                              @foreach($semuaFakultas as $fakultas)
                                @if($fakultas->id != $fakultasId)
                                  @if($fakultas->deleted_at == NULL)
                                    <optgroup label="{{ $fakultas->nama }}">
                                      @foreach($semuaProdi as $prodi)
                                        @if($prodi->fakultas_id == $fakultas->id)
                                          @if($prodi->deleted_at == NULL)
                                            <option value="{{ $prodi->id }}">{{ $prodi->nama }}</option>
                                          @endif
                                        @endif
                                      @endforeach
                                    </optgroup>
                                  @endif
                                @endif
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success"><span class="fa fa-edit m-right-xs"></span> Simpan Perubahan Profile</button>
                          </div>
                        </div>

                      </form>

                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                        <form id="demo-form3" action="{{ route('Profile.updatepass', $pengguna->id) }}" method="POST" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
                          {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">

                        <!-------------------------------------------------------------------KATEGORI TERHAPUS INDEX--------------------------->
                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Password Lama</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="password_lama" class="form-control col-md-7 col-xs-12" type="password" name="password_lama" placeholder="Password Lama" required="">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Konfirmasi Password</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="password" class="form-control col-md-7 col-xs-12" type="password" name="password" placeholder="Password Baru" required="">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Konfirmasi Password Baru</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="password_confirmation" class="form-control col-md-7 col-xs-12" type="password" name="password_confirmation" placeholder="Konfirmasi Password Baru" required="">
                          </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success"><span class="fa fa-edit m-right-xs"></span> Ubah Password</button>
                          </div>
                        </div>

                        </form>

                      </div>
                    </div>
                  </div>





                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('custom_script')
<!-- Select2 -->
<script>
  $(document).ready(function() {
    $(".select2_group").select2({});
  });
</script>
<!-- /Select2 -->

<!-- Upload Foto habis di pilih -->
<script>
document.getElementById("upload").onchange = function() {
    document.getElementById("demo-form4").submit();
};
</script>
<!-- Upload Foto habis di pilih -->

<!-- Upload Foto -->
<script>
$(function(){
$("#upload_link").on('click', function(e){
  e.preventDefault();
  $("#upload:hidden").trigger('click');
});
});
</script>
<!-- Upload Foto -->

<!-- Preview Upload -->
<script>
function readURL(input) {
       if (input.files && input.files[0]) {
           var reader = new FileReader();

           reader.onload = function (e) {
               $('#blah')
                   .attr('src', e.target.result)
                   .width(256)
                   .height(256);
           };

           reader.readAsDataURL(input.files[0]);
       }
   }
  </script>
<!-- Preview Upload -->
@endsection
