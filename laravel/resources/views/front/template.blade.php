<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="description" content="SIATMA Bot : bot penyedia informasi seputar kuliah" />
  	<meta name="author" content="SIATMA Bot" />


    <title>SIATMA Bot</title>
    <link rel="icon" href="{{ asset('images/logo_tabbrowser.png') }}" type="image" sizes="16x16"> <!------------------------------------------ ICON-------------->

    <!----------------------------------------------------Buat Dashboard(index.html)---------->
    <!-- Bootstrap -->
    <link href="{{ asset('Template/AdminPage/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('Template/AdminPage/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('Template/AdminPage/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('Template/AdminPage/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="{{ asset('Template/AdminPage/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('Template/AdminPage/vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('Template/AdminPage/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!----------------------------------------------------Buat Tabel-Tabel (tables_dynamic.html)---------->
    <!-- Datatables -->
    <link href="{{ asset('Template/AdminPage/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Template/AdminPage/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Template/AdminPage/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Template/AdminPage/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Template/AdminPage/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

    <!----------------------------------------------------Buat Form (form.html)---------->
    <!-- bootstrap-wysiwyg -->
    <link href="{{ asset('Template/AdminPage/vendors/google-code-prettify/bin/prettify.min.css') }}" rel="stylesheet">
    <!-- Select2 -->
    <link href="{{ asset('Template/AdminPage/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <!-- Switchery -->
    <link href="{{ asset('Template/AdminPage/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- starrr -->
    <link href="{{ asset('Template/AdminPage/vendors/starrr/dist/starrr.css') }}" rel="stylesheet">
    <!-- Ion.RangeSlider -->
    <link href="{{ asset('Template/AdminPage/vendors/normalize-css/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('Template/AdminPage/vendors/ion.rangeSlider/css/ion.rangeSlider.css') }}" rel="stylesheet">
    <link href="{{ asset('Template/AdminPage/vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">
    <!-- Bootstrap Colorpicker -->
    <link href="{{ asset('Template/AdminPage/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
    <!-- Cropper -->
    <link href="{{ asset('Template/AdminPage/vendors/cropper/dist/cropper.min.css') }}" rel="stylesheet">
    <!-- Preview Upload Image -->
    <style type="text/css">
      .container{
        margin-top:20px;
      }
      .image-preview-input {
        position: relative;
        overflow: hidden;
        margin: 0px;
        color: #333;
        background-color: #fff;
        border-color: #ccc;
      }
      .image-preview-input input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
      }
      .image-preview-input-title {
        margin-left:2px;
      }
    </style>
    <!-- Text Editor Summernote-->
    <link href="{{ asset('css/summernote/summernote.css') }}" rel="stylesheet">


    <!----------------------------------------------------Buat Profile---------->
    @yield('custom_css')


    <!-- Custom Theme Style -->
    <link href="{{ asset('Template/AdminPage/build/css/custom.min.css') }}" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="{{ asset('css/sweetalert/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert/sweetalert2.css') }}" rel="stylesheet">

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              @if(strcasecmp(Auth::user()->role,'admin')==0)
              <a href="{{ route('dashboard.admin') }}" class="site_title"><i class="fa fa-user-md"></i>
              @elseif(strcasecmp(Auth::user()->role,'mahasiswa')==0)
              <a href="{{ route('dashboard.mahasiswa') }}" class="site_title"><i class="fa fa-user-md"></i>
              @endif
                <span>{{ Auth::user()->role }}</span>
              </a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">

              @if( Auth::user()->image == NULL)
              <div class="profile_pic">
                <img src="{{ asset('uploads/ProfilePicture/defaultprofile.png') }}" alt="..." class="img-circle profile_img">
              </div>
              @else
              <div class="profile_pic">
                <img src="{{ asset('uploads/ProfilePicture/'.Auth::user()->image) }}" alt="..." class="img-circle profile_img">
              </div>
              @endif
              <div class="profile_info">
                <span>Selamat datang,</span>
                <h2 style="margin-top:5px">{{ Auth::user()->fullname }}</h2><!-----------------------------------------------------------------------NAMA USER LOGIN---------------->
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3 style="margin-top:85px">Pengelolaan</h3>
                <ul class="nav side-menu">
                  @if(strcasecmp(Auth::user()->role,'admin')==0)
                  <li><a href="{{ Route('dashboard.admin') }}"><i class="fa fa-desktop"></i> Dashboard Admin </a></li>
                  @endif
                  <li><a href="{{ Route('dashboard.mahasiswa') }}"><i class="fa fa-desktop"></i> Dashboard</a></li>
                  <li><a href="{{ Route('fakultas.index') }}"><i class="fa fa-home"></i> Fakultas</a></li>
                  <li><a href="{{ Route('prodi.index') }}"><i class="fa fa-exchange"></i> Program Studi</a>
                  </li>
                  <li><a href="{{ Route('sesi.index') }}"><i class="fa fa-users"></i> Kelola Sesi </a>
                  </li>
                  <li><a href="#"><i class="fa fa-list-ol"></i> Kelola Sesi-Prodi </a>
                  </li>
                </ul>
              </div>

              <div class="menu_section">
                <h3>Website</h3>
                <ul class="nav side-menu">
                  <li><a href="#"><i class="fa fa-info-circle"></i> Kelola Identitas Web </a>
                  </li>
                </ul>
              </div>


            </div>
            <!-- /sidebar menu -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    @if( Auth::user()->image == NULL)
                      <img src="{{ asset('uploads/ProfilePicture/defaultprofile.png') }}" alt="">
                    @else
                      <img src="{{ asset('uploads/ProfilePicture/'.Auth::user()->image) }}" alt="">
                    @endif
                    {{ Auth::user()->fullname }} <!--------------------------------------NAMA USER LOGIN--------->
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="#"><i class="fa fa-user pull-right"></i> Profile</a></li>

                    <li><a href="{{ Route('user.logout') }}"><i class="fa fa-sign-out pull-right"></i> Keluar</a></li>
                  </ul>
                </li>

              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
                @yield('content')  <!------------------------------------------------------CONTENT-------------------------------->
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">

          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-------------------------------------------------------------------Buat Dashboar (index.html)-------------------------->
    <!-- jQuery -->
    <script src="{{ asset('Template/AdminPage/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('Template/AdminPage/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('Template/AdminPage/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('Template/AdminPage/vendors/nprogress/nprogress.js') }}"></script>
    <!-- Chart.js -->
    <script src="{{ asset('Template/AdminPage/vendors/Chart.js/dist/Chart.min.js') }}"></script>
    <!-- gauge.js -->
    <script src="{{ asset('Template/AdminPage/vendors/gauge.js/dist/gauge.min.js') }}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{ asset('Template/AdminPage/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('Template/AdminPage/vendors/iCheck/icheck.min.js') }}"></script>
    <!-- Skycons -->
    <script src="{{ asset('Template/AdminPage/vendors/skycons/skycons.js') }}"></script>
    <!-- Flot -->
    <script src="{{ asset('Template/AdminPage/vendors/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/Flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/Flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/Flot/jquery.flot.resize.js') }}"></script>
    <!-- Flot plugins -->
    <script src="{{ asset('Template/AdminPage/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/flot.curvedlines/curvedLines.js') }}"></script>
    <!-- DateJS -->
    <script src="{{ asset('Template/AdminPage/vendors/DateJS/build/date.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('Template/AdminPage/vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('Template/AdminPage/vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-------------------------------------------------------------------Buat Tabel (tables_dynamic.html)-------------------------->
    <!-- Datatables -->
    <script src="{{ asset('Template/AdminPage/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/datatables.net-scroller/js/datatables.scroller.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/pdfmake/build/vfs_fonts.js') }}"></script>

    <!-------------------------------------------------------------------Buat Form (form.html)-------------------------->
    <!-- bootstrap-wysiwyg -->
    <script src="{{ asset('Template/AdminPage/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/jquery.hotkeys/jquery.hotkeys.js') }}"></script>
    <script src="{{ asset('Template/AdminPage/vendors/google-code-prettify/src/prettify.js') }}"></script>
    <!-- jQuery Tags Input -->
    <script src="{{ asset('Template/AdminPage/vendors/jquery.tagsinput/src/jquery.tagsinput.js') }}"></script>
    <!-- Switchery -->
    <script src="{{ asset('Template/AdminPage/vendors/switchery/dist/switchery.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('Template/AdminPage/vendors/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- Parsley -->
    <script src="{{ asset('Template/AdminPage/vendors/parsleyjs/dist/parsley.min.js') }}"></script>
    <!-- Autosize -->
    <script src="{{ asset('Template/AdminPage/vendors/autosize/dist/autosize.min.js') }}"></script>
    <!-- jQuery autocomplete -->
    <script src="{{ asset('Template/AdminPage/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js') }}"></script>
    <!-- starrr -->
    <script src="{{ asset('Template/AdminPage/vendors/starrr/dist/starrr.js') }}"></script>
    <!-- Ion.RangeSlider -->
    <script src="{{ asset('Template/AdminPage/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js') }}"></script>
    <!-- Bootstrap Colorpicker -->
    <script src="{{ asset('Template/AdminPage/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- jquery.inputmask -->
    <script src="{{ asset('Template/AdminPage/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
    <!-- jQuery Knob -->
    <script src="{{ asset('Template/AdminPage/vendors/jquery-knob/dist/jquery.knob.min.js') }}"></script>
    <!-- Cropper -->
    <script src="{{ asset('Template/AdminPage/vendors/cropper/dist/cropper.min.js') }}"></script>
    <!-- Preview Upload Image -->
    <!--<script src="{{ asset('js/uploadImage/jquery-1.10.2.min.js.download') }}"></script>
    <script src="{{ asset('js/uploadImage/bootstrap.min.js.download') }}"></script>-->

    <!-- Text Editor Summernote-->
    <script src="{{ asset('js/summernote/summernote.js') }}"></script>
    <script src="{{ asset('js/summernote/summernote.min.js') }}"></script>




    <!-- Custom Theme Scripts -->
    <script src="{{ asset('Template/AdminPage/build/js/custom.min.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('js/sweetalert/sweetalert2.js') }}"></script>

    @include('sweet::alert')

    @yield('custom_script') <!-----------------------------------------------------------------------------JAVASCRIPT----------------->

  </body>
</html>
