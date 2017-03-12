@extends('front.template')

@section('content')

<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3> Jadwal Kuliah </h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_content">
                  <!-------------------------------------------------------------------JADWAL INDEX--------------------------->
                  <div class="x_panel">
                    <div class="x_title">
                      <h2> Tabel Jadwal Kuliah <small>Daftar jadwal kuliah yang telah dimasukkan</small></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <table id="tabel-jadwal" class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th align="center"><h2><b>Sesi</b></h2></th>
                            <th align="center"><h1><b>Senin</b></h1></th>
                            <th align="center"><h1><b>Selasa</b></h1></th>
                            <th align="center"><h1><b>Rabu</b></h1></th>
                            <th align="center"><h1><b>Kamis</b></h1></th>
                            <th align="center"><h1><b>Jumat</b></h1></th>
                          </tr>
                        </thead>


                        <tbody>
                          @for($sesi=1;$sesi<=$sesiMax;$sesi++)
                          <tr>
                            <td style="vertical-align:middle" align="middle"><h1><b>{{ $sesi }}</b></h1></td>
                            @foreach($semuaSesi as $sesiID)
                              @if($sesiID->sesi == $sesi && strcasecmp($sesiID->hari,'Senin')==0)

                                @foreach($semuaJadwal as $jadwal)
                                  @if($jadwal->sesi->sesi_id == $sesiID->id)
                                    <td style="vertical-align:middle" align="middle" >
                                      <table id="{{ $sesiID->id }}" class="table table-striped table-bordered">
                                        <tbody>
                                          <tr>
                                            <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                              {{ $jadwal->makul }}
                                            </td>
                                          </tr>
                                          <tr>
                                            <td align="middle" >Kelas :</td>
                                            <td align="middle" >{{ $jadwal->kelas }}</td>
                                          </tr>
                                          <tr>
                                            <td align="middle" >Ruangan : </td>
                                            <td style="overflow:hidden; width:80px;" align="middle" >{{ $jadwal->ruangan }}</td>
                                          </tr>
                                          <tr>
                                            <td align="middle" >
                                              <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $sesiID->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                            </td>
                                            <td align="middle" >
                                              <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $sesiID->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  @elseif($jadwal->sesi->sesi_id != $sesiID->id && strcasecmp($jadwal->sesi->sesi->hari,'Senin')==0)
                                    <td style="vertical-align:middle" align="middle" >
                                      <a href="{{ route('jadwal.create', $sesiID->id) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                                    </td>
                                  @endif
                                @endforeach

                              @elseif($sesiID->sesi == $sesi && strcasecmp($sesiID->hari,'Selasa')==0)
                                @foreach($semuaJadwal as $jadwal)
                                  @if($jadwal->sesi->sesi_id == $sesiID->id)
                                    <td style="vertical-align:middle" align="middle" >
                                      <table id="{{ $sesiID->id }}" class="table table-striped table-bordered">
                                        <tbody>
                                          <tr>
                                            <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                              {{ $jadwal->makul }}
                                            </td>
                                          </tr>
                                          <tr>
                                            <td align="middle" >Kelas :</td>
                                            <td align="middle" >{{ $jadwal->kelas }}</td>
                                          </tr>
                                          <tr>
                                            <td align="middle" >Ruangan : </td>
                                            <td style="overflow:hidden; width:80px;" align="middle" >{{ $jadwal->ruangan }}</td>
                                          </tr>
                                          <tr>
                                            <td align="middle" >
                                              <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $sesiID->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                            </td>
                                            <td align="middle" >
                                              <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $sesiID->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  @elseif($jadwal->sesi->sesi_id != $sesiID->id && strcasecmp($jadwal->sesi->sesi->hari,'Selasa')==0)
                                    <td style="vertical-align:middle" align="middle" >
                                      <a href="{{ route('jadwal.create', $sesiID->id) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                                    </td>
                                  @endif
                                @endforeach
                              @elseif($sesiID->sesi == $sesi && strcasecmp($sesiID->hari,'Rabu')==0)
                                @foreach($semuaJadwal as $jadwal)
                                  @if($jadwal->sesi->sesi_id == $sesiID->id)
                                    <td style="vertical-align:middle" align="middle" >
                                      <table id="{{ $sesiID->id }}" class="table table-striped table-bordered">
                                        <tbody>
                                          <tr>
                                            <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                              {{ $jadwal->makul }}
                                            </td>
                                          </tr>
                                          <tr>
                                            <td align="middle" >Kelas :</td>
                                            <td align="middle" >{{ $jadwal->kelas }}</td>
                                          </tr>
                                          <tr>
                                            <td align="middle" >Ruangan : </td>
                                            <td style="overflow:hidden; width:80px;" align="middle" >{{ $jadwal->ruangan }}</td>
                                          </tr>
                                          <tr>
                                            <td align="middle" >
                                              <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $sesiID->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                            </td>
                                            <td align="middle" >
                                              <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $sesiID->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  @elseif($jadwal->sesi->sesi_id != $sesiID->id && strcasecmp($jadwal->sesi->sesi->hari,'Rabu')==0)
                                    <td style="vertical-align:middle" align="middle" >
                                      <a href="{{ route('jadwal.create', $sesiID->id) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                                    </td>
                                  @endif
                                @endforeach
                              @elseif($sesiID->sesi == $sesi && strcasecmp($sesiID->hari,'Kamis')==0)
                                @foreach($semuaJadwal as $jadwal)
                                  @if($jadwal->sesi->sesi_id == $sesiID->id)
                                    <td style="vertical-align:middle" align="middle" >
                                      <table id="{{ $sesiID->id }}" class="table table-striped table-bordered">
                                        <tbody>
                                          <tr>
                                            <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                              {{ $jadwal->makul }}
                                            </td>
                                          </tr>
                                          <tr>
                                            <td align="middle" >Kelas :</td>
                                            <td align="middle" >{{ $jadwal->kelas }}</td>
                                          </tr>
                                          <tr>
                                            <td align="middle" >Ruangan : </td>
                                            <td style="overflow:hidden; width:80px;" align="middle" >{{ $jadwal->ruangan }}</td>
                                          </tr>
                                          <tr>
                                            <td align="middle" >
                                              <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $sesiID->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                            </td>
                                            <td align="middle" >
                                              <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $sesiID->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  @elseif($jadwal->sesi->sesi_id != $sesiID->id && strcasecmp($jadwal->sesi->sesi->hari,'Kamis')==0)
                                    <td style="vertical-align:middle" align="middle" >
                                      <a href="{{ route('jadwal.create', $sesiID->id) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                                    </td>
                                  @endif
                                @endforeach
                              @elseif($sesiID->sesi == $sesi && strcasecmp($sesiID->hari,'Jumat')==0)
                                @foreach($semuaJadwal as $jadwal)
                                  @if($jadwal->sesi->sesi_id == $sesiID->id)
                                    <td style="vertical-align:middle" align="middle" >
                                      <table id="{{ $sesiID->id }}" class="table table-striped table-bordered">
                                        <tbody>
                                          <tr>
                                            <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                              {{ $jadwal->makul }}
                                            </td>
                                          </tr>
                                          <tr>
                                            <td align="middle" >Kelas :</td>
                                            <td align="middle" >{{ $jadwal->kelas }}</td>
                                          </tr>
                                          <tr>
                                            <td align="middle" >Ruangan : </td>
                                            <td style="overflow:hidden; width:80px;" align="middle" >{{ $jadwal->ruangan }}</td>
                                          </tr>
                                          <tr>
                                            <td align="middle" >
                                              <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $sesiID->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                            </td>
                                            <td align="middle" >
                                              <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $sesiID->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  @elseif($jadwal->sesi->sesi_id != $sesiID->id && strcasecmp($jadwal->sesi->sesi->hari,'Jumat')==0)
                                    <td style="vertical-align:middle" align="middle" >
                                      <a href="{{ route('jadwal.create', $sesiID->id) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                                    </td>
                                  @endif
                                @endforeach
                              @endif
                            @endforeach
                          </tr>
                          @endfor
                        </tbody>
                      </table>
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
<!-- <script>
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
</script> -->
<!-- Script SweetAlert Konfirmasi Restore -->

<!-- Script SweetAlert Konfirmasi Hapus Permanen -->
<!-- <script>
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
</script> -->
<!-- Script SweetAlert Konfirmasi Hapus Permanen -->

<!-- Script SweetAlert Konfirmasi Hapus -->
<!-- <script>
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
</script> -->
<!-- Script SweetAlert Konfirmasi Hapus -->

<!-- Datatables Artikel Index -->
<!-- <script>
    $('#tabel-jadwal').dataTable({
      "columnDefs" : [
        {
        "targets": [5],
        "visible": false,
        "searchable" : false
        }
      ],
      "order": [[ 5, 'desc'  ]]
    });
</script> -->
<script>
    $('#tabel-jadwal').dataTable();
</script>
<!-- /Datatables Artikel Index -->
@endsection
