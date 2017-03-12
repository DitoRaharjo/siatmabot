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

    <!-- Custom Theme Style -->
    <link href="{{ asset('Template/AdminPage/build/css/custom.min.css') }}" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!-- page content -->
        <div class="col-md-12">
          <div class="col-middle">
            <div class="text-center text-center">

              <div class="mid_center">
              </br>
              </br>
              </br>
              </br>
              </br>
              </br>
                  <div class="col-xs-12 form-group pull-right top_search">
                    <h1 class="error-number">404</h1>
                    <h2>Sorry but we couldn't find this page</h2>
                    <p>This page you are looking for does not exist</a>
                    </p>
                    <a href="{{ route('user.login') }}" class="btn btn-default" >Return to Main Page</a>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('Template/AdminPage/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('Template/AdminPage/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('Template/AdminPage/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('Template/AdminPage/vendors/nprogress/nprogress.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('Template/AdminPage/build/js/custom.min.js') }}"></script>
  </body>
</html>
