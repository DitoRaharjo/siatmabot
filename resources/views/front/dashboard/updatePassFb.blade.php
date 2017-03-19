<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SIATMA Bot : Bot penyedia informasi seputar perkuliahan" />
  	<meta name="author" content="Dito Raharjo" />

    <title>SIATMA Bot</title>
    <link rel="icon" href="{{ asset('images/logo_tabbrowser.png') }}" type="image" sizes="16x16"> <!------------------------------------------ ICON-------------->

    <!-- Bootstrap -->
    <link href="{{ asset('Template/AdminPage/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('Template/AdminPage/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('Template/AdminPage/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ asset('Template/AdminPage/vendors/animate.css/animate.min.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('Template/AdminPage/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Select2 -->
    <link href="{{ asset('Template/AdminPage/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('Template/AdminPage/build/css/custom.min.css') }}" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="{{ asset('css/sweetalert/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert/sweetalert2.css') }}" rel="stylesheet">


  </head>

  <body class="login">
    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">

            <form action="{{ route('fb.login') }}" method="post">
              {{ csrf_field() }}
              <h1>Tambahan Data</h1>
              <div>
                <input name="telegram_username" type="text" class="form-control" placeholder="Telegram Username, ex : vincentiusdito, Without @ "/>
              </div>
              <div>
                <input name="npm" type="number" class="form-control" placeholder="NPM" required="" />
              </div>
              <div>
                </br>
              </div>
              <div>
                <select class="select2_group form-control" required="" name="prodi_id">
                  @foreach($semuaFakultas as $fakultas)
                    @if($fakultas->deleted_at == NULL)
                    <optgroup label="{{ $fakultas->nama }}">
                              @foreach($semuaProdi as $prodi)
                                @if($prodi->fakultas_id == $fakultas->id)
                                <option value="{{ $prodi->id }}">{{ $prodi->nama }}</option>
                                @endif
                              @endforeach
                    </optgroup>
                    @endif
                  @endforeach
                </select>
              </div>
              <div>
                </br>
              </div>
              <div>
                <input type="hidden" name="email" class="form-control" placeholder="Email" required="" value="{{ $emailUser }}"/>
                <input type="email" name="emailAbalAbal" class="form-control" placeholder="Email" required="" disabled="" value="{{ $emailUser }}"/>
              </div>
              <div>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password Baru" required=""/>
              </div>
              <div>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password Baru" required="" />
              </div>
              <div class="clearfix"></div>
            <button type="submit" class="btn btn-default submit" >Submit</button>
            </form>
          </section>
        </div>
      </div>
    </div>

    <!--<script src="{{ asset('js/loginadmin/index.js') }}"></script>-->
    <!-- jQuery Tags Input -->
    <script src="{{ asset('Template/AdminPage/vendors/jquery.tagsinput/src/jquery.tagsinput.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('Template/AdminPage/vendors/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert/sweetalert2.js') }}"></script>
    <!-- Include this after the sweet alert js file -->

    <!-- Select2 -->
    <script>
      $(document).ready(function() {
        $(".select2_group").select2({});
      });
    </script>
    <!-- /Select2 -->

    <!-- Untuk Pencocokan Konfirmasi Password -->
    <script>
      var password = document.getElementById("password")
      , confirm_password = document.getElementById("password_confirmation");

      function validatePassword(){
      if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords Don't Match");
      } else {
        confirm_password.setCustomValidity('');
      }
      }

      password.onchange = validatePassword;
      confirm_password.onkeyup = validatePassword;
    </script>
    <!-- Untuk Pencocokan Konfirmasi Password -->

    @include('sweet::alert')

  </body>
</html>
