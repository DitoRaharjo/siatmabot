@extends('front.template')

@section('content')

<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3> Data Sesi </h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_content">

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab1" class="nav nav-tabs bar_tabs left" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content11" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><span class="fa fa-archive"></span> Data Sesi</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content22" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><span class="fa fa-trash"></span> Data Sesi Sudah Dihapus</a>
                        </li>
                      </ul>
                      <div id="myTabContent2" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="home-tab">

                          <!-------------------------------------------------------------------ARTIKEL INDEX--------------------------->
                          <div class="x_panel">
                            <div class="x_title">
                              <h2> Tabel Sesi <small>Daftar sesi yang telah dimasukkan</small></h2>
                              <ul class="nav navbar-right panel_toolbox">
                                <a href="{{ route('sesi.create') }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Sesi Baru</a>
                              </ul>
                              <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                              <table id="tabel-sesi" class="table table-striped table-bordered">
                                <thead>
                                  <tr>
                                    <th align="center">Hari</th>
                                    <th align="center">Sesi</th>
                                    <th align="center">Dibuat pada</th>
                                    <th align="center">Dibuat oleh</th>
                                    <th align="center">Diupdate Pada</th>
                                    <th align="center">Diupdate oleh</th>
                                    <th align="center">Aksi</th>
                                  </tr>
                                </thead>


                                <tbody>
                                  @foreach($semuaSesi as $sesi)
                                  @if( $sesi->deleted_at == NULL)
                                  <tr>
                                    <td valign="middle" >{{ $sesi->hari }}</td>
                                    <td valign="middle" >{{ $sesi->sesi }}</td>
                                    <td align="center" valign="middle">{{ $sesi->created_at }}</td>
                                    <td valign="middle">{{ $sesi->userCreate->fullname }}</td>
                                    <td align="center" valign="middle">{{ $sesi->updated_at }}</td>
                                    @if($sesi->updated_by == NULL)
                                    <td align="center" valign="middle"> - </td>
                                    @else
                                    <td valign="middle"> {{ $sesi->userUpdate->fullname }}</td>
                                    @endif

                                    <td valign="middle">
                                      <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('sesi.edit', $sesi->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('sesi.destroy', $sesi->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                    </td>
                                  </tr>
                                  @endif
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>


                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="profile-tab">


                          <!-------------------------------------------------------------------ARTIKEL TERHAPUS INDEX--------------------------->
                          <div class="x_panel">
                            <div class="x_title">
                              <h2> Tabel Sesi Terhapus <small>Daftar sesi yang telah dihapus</small></h2>
                              <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                              <table id="tabel-sesiTerhapus" class="table table-striped table-bordered">
                                <thead>
                                  <tr>
                                    <th align="center">Hari</th>
                                    <th align="center">Sesi</th>
                                    <th align="center">Dihapus Pada</th>
                                    <th align="center">Dihapus oleh</th>
                                    <th align="center">Aksi</th>
                                  </tr>
                                </thead>


                                <tbody>
                                  @foreach($semuaSesi as $sesi)
                                  @if( $sesi->deleted_at != NULL)
                                  <tr>
                                    <td valign="middle" >{{ $sesi->hari }}</td>
                                    <td valign="middle" >{{ $sesi->sesi }}</td>
                                    <td align="center" valign="middle">{{ $sesi->deleted_at }}</td>
                                    <td valign="middle">{{ $sesi->userDelete->fullname }}</td>
                                    <td valign="middle">
                                      <a id="restore-btn" class="btn btn-warning btn-xs" customParam="{{ route('sesiTerhapus.restore', $sesi->id) }}" href="#"><span class="fa fa-retweet"></span> Kembalikan Data</a>
                                    </td>
                                  </tr>
                                  @endif
                                  @endforeach
                                </tbody>
                              </table>
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
<!-- /page content -->

@endsection

@section('custom_script')

<!-- Script SweetAlert Konfirmasi Restore -->
<script>
    var deleter = {

        linkSelector : "a#restore-btn",

        init: function() {
            $(this.linkSelector).on('click', {self:this}, this.handleClick);
        },

        handleClick: function(event) {
            event.preventDefault();

            var self = event.data.self;
            var link = $(this);

        swal({
            title: 'Apakah anda yakin?',
            text: "Data akan dipulihkan ke kondisi sebelum dihapus!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Restore',
            cancelButtonText: 'Batal',
            confirmButtonClass: 'btn btn-success btn-lg',
            cancelButtonClass: 'btn btn-danger btn-lg',
            buttonsStyling: false
          }).then(function () {
              window.location = link.attr('customParam');
          }, function (dismiss) {
            // dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
            if (dismiss === 'cancel') {
              swal(
                'Batal',
                'Data batal untuk dipulihkan',
                'error'
              )
            }
          })
        },
    };

    deleter.init();
</script>
<!-- Script SweetAlert Konfirmasi Restore -->

<!-- Script SweetAlert Konfirmasi Hapus Permanen -->
<script>
    var deleter = {

        linkSelector : "a#deletePermanent-btn",

        init: function() {
            $(this.linkSelector).on('click', {self:this}, this.handleClick);
        },

        handleClick: function(event) {
            event.preventDefault();

            var self = event.data.self;
            var link = $(this);

        swal({
            title: 'Apakah anda yakin?',
            text: "Data terhapus permanen tidak bisa dikembalikan!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus Permanen',
            cancelButtonText: 'Batal',
            confirmButtonClass: 'btn btn-success btn-lg',
            cancelButtonClass: 'btn btn-danger btn-lg',
            buttonsStyling: false
          }).then(function () {
              window.location = link.attr('customParam');
          }, function (dismiss) {
            // dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
            if (dismiss === 'cancel') {
              swal(
                'Batal',
                'Data batal untuk dihapus permanen',
                'error'
              )
            }
          })
        },
    };

    deleter.init();
</script>
<!-- Script SweetAlert Konfirmasi Hapus Permanen -->

<!-- Datatables Artikel Terhapus Index -->
<script>
    $('#tabel-sesiTerhapus').dataTable();
</script>
<!-- /Datatables Artikel Terhapus Index -->

<!-- Script SweetAlert Konfirmasi Hapus -->
<script>
    var deleter = {

        linkSelector : "a#delete-btn",

        init: function() {
            $(this.linkSelector).on('click', {self:this}, this.handleClick);
        },

        handleClick: function(event) {
            event.preventDefault();

            var self = event.data.self;
            var link = $(this);

        swal({
            title: 'Hapus Data',
            text: "Apakah anda yakin ingin menghapus data ini?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            confirmButtonClass: 'btn btn-success btn-lg',
            cancelButtonClass: 'btn btn-danger btn-lg',
            buttonsStyling: false
          }).then(function () {
              window.location = link.attr('customParam');
          }, function (dismiss) {
            // dismiss can be 'cancel', 'overlay',
            // 'close', and 'timer'
            if (dismiss === 'cancel') {
              swal(
                'Batal',
                'Data batal untuk dihapus',
                'error'
              )
            }
          })
        },
    };

    deleter.init();
</script>
<!-- Script SweetAlert Konfirmasi Hapus -->

<!-- Datatables Artikel Index -->
<script>
    $('#tabel-sesi').dataTable({
      "columnDefs" : [
        {
        "targets": [4],
        "visible": false,
        "searchable" : false
        }
      ],
      "order": [[ 4, 'desc'  ]]
    });
</script>
<!-- /Datatables Artikel Index -->
@endsection
