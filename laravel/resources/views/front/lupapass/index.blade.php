<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Seputar Farmasi : Informasi dan Konsultasi Kesehatan" />
  	<meta name="author" content="Seputar Farmasi" />

    <title>Seputar Farmasi</title>
    <link rel="icon" href="{{ asset('images/logo_tabbrowser.png') }}" type="image" sizes="16x16"> <!------------------------------------------ ICON-------------->

    <!-- Bootstrap -->
    <link href="{{ asset('Template/AdminPage/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('Template/AdminPage/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('Template/AdminPage/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ asset('Template/AdminPage/vendors/animate.css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('Template/AdminPage/build/css/custom.min.css') }}" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="{{ asset('css/sweetalert/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert/sweetalert2.css') }}" rel="stylesheet">


  </head>

  <body class="login">
    <div>
      <!--
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
    -->

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">

            <form action="{{ route('GantiPass.do') }}" method="post">
              {{ csrf_field() }}
              <h1>Ganti Password Baru</h1>
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

              <!--
              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
            -->
            <button type="submit" class="btn btn-default submit" >Submit</button>
            </form>
          </section>
        </div>

        <!--
        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form>
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <a class="btn btn-default submit" href="index.html">Submit</a>
              </div>

              <div class="clearfix"></div>


              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>

            </form>
          </section>
        </div>
      -->
      </div>
    </div>

    <!--<script src="{{ asset('js/loginadmin/index.js') }}"></script>-->
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert/sweetalert2.js') }}"></script>
    <!-- Include this after the sweet alert js file -->

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
