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
                          <tr>
                            <td style="vertical-align:middle" align="middle"><h1><b>1</b></h1></td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($senin1 == NULL)
                                <a href="{{ route('jadwal.create', $senin1ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="senin-1" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $senin1->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $senin1->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $senin1->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $senin1->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $senin1->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($selasa1 == NULL)
                                <a href="{{ route('jadwal.create', $selasa1ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="selasa-1" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $selasa1->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $selasa1->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $selasa1->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $selasa1->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $selasa1->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($rabu1 == NULL)
                                <a href="{{ route('jadwal.create', $rabu1ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="rabu-1" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $rabu1->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $rabu1->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $rabu1->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $rabu1->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $rabu1->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($kamis1 == NULL)
                                <a href="{{ route('jadwal.create', $kamis1ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="kamis-1" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $kamis1->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $kamis1->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $kamis1->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $kamis1->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $kamis1->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($jumat1 == NULL)
                                <a href="{{ route('jadwal.create', $jumat1ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="senin-1" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $jumat1->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $jumat1->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $jumat1->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $jumat1->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $jumat1->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                          </tr>

                          <!--------------------------------------------------------- SAMPE SINI --------------------------------->
                          <tr>
                            <td style="vertical-align:middle" align="middle"><h1><b>2</b></h1></td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($senin2 == NULL)
                                <a href="{{ route('jadwal.create', $senin2ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="senin-2" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $senin2->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $senin2->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $senin2->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $senin2->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $senin2->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($selasa2 == NULL)
                                <a href="{{ route('jadwal.create', $selasa2ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="selasa-2" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $selasa2->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $selasa2->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $selasa2->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $selasa2->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $selasa2->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($rabu2 == NULL)
                                <a href="{{ route('jadwal.create', $rabu2ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="rabu-2" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $rabu2->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $rabu2->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $rabu2->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $rabu2->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $rabu2->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($kamis2 == NULL)
                                <a href="{{ route('jadwal.create', $kamis2ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="kamis-2" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $kamis2->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $kamis2->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $kamis2->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $kamis2->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $kamis2->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($jumat2 == NULL)
                                <a href="{{ route('jadwal.create', $jumat2ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="jumat-2" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $jumat2->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $jumat2->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $jumat2->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $jumat2->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $jumat2->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td style="vertical-align:middle" align="middle"><h1><b>3</b></h1></td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($senin3 == NULL)
                                <a href="{{ route('jadwal.create', $senin3ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="senin-3" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $senin3->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $senin3->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $senin3->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $senin3->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $senin3->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($selasa3 == NULL)
                                <a href="{{ route('jadwal.create', $selasa3ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="selasa-3" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $selasa3->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $selasa3->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $selasa3->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $selasa3->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $selasa3->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($rabu3 == NULL)
                                <a href="{{ route('jadwal.create', $rabu3ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="rabu-3" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $rabu3->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $rabu3->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $rabu3->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $rabu3->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $rabu3->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($kamis3 == NULL)
                                <a href="{{ route('jadwal.create', $kamis3ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="kamis-3" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $kamis3->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $kamis3->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $kamis3->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $kamis3->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $kamis3->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($jumat3 == NULL)
                                <a href="{{ route('jadwal.create', $jumat3ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="jumat-3" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $jumat3->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $jumat3->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $jumat3->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $jumat3->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $jumat3->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td style="vertical-align:middle" align="middle"><h1><b>4</b></h1></td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($senin4 == NULL)
                                <a href="{{ route('jadwal.create', $senin4ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="senin-4" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $senin4->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $senin4->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $senin4->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $senin4->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $senin4->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($selasa4 == NULL)
                                <a href="{{ route('jadwal.create', $selasa4ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="selasa-4" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $selasa4->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $selasa4->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $selasa4->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $selasa4->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $selasa4->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($rabu4 == NULL)
                                <a href="{{ route('jadwal.create', $rabu4ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="rabu-4" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $rabu4->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $rabu4->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $rabu4->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $rabu4->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $rabu4->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($kamis4 == NULL)
                                <a href="{{ route('jadwal.create', $kamis4ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="kamis-4" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $kamis4->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $kamis4->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $kamis4->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $kamis4->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $kamis4->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($jumat4 == NULL)
                                <a href="{{ route('jadwal.create', $jumat4ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="jumat-4" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $jumat4->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $jumat4->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $jumat4->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $jumat4->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $jumat4->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td style="vertical-align:middle" align="middle"><h1><b>5</b></h1></td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($senin5 == NULL)
                                <a href="{{ route('jadwal.create', $senin5ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="senin-5" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $senin5->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $senin5->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $senin5->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $senin5->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $senin5->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($selasa5 == NULL)
                                <a href="{{ route('jadwal.create', $selasa5ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="selasa-5" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $selasa5->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $selasa5->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $selasa5->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $selasa5->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $selasa5->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($rabu5 == NULL)
                                <a href="{{ route('jadwal.create', $rabu5ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="rabu-5" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $rabu5->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $rabu5->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $rabu5->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $rabu5->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $rabu5->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($kamis5 == NULL)
                                <a href="{{ route('jadwal.create', $kamis5ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="kamis-5" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $kamis5->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $kamis5->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $kamis5->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $kamis5->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $kamis5->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                            <td style="vertical-align:middle" align="middle" >
                              @if($jumat5 == NULL)
                                <a href="{{ route('jadwal.create', $jumat5ID) }}" class="btn btn-success"><label class="fa fa-plus-circle"></label>  Tambah Jadwal</a>
                              @else
                                <table id="jumat-5" class="table table-striped table-bordered">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" style="overflow:hidden; width:50px;" align="middle" >
                                        {{ $jumat5->makul }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Kelas :</td>
                                      <td align="middle" >{{ $jumat5->kelas }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >Ruangan : </td>
                                      <td style="overflow:hidden; width:80px;" align="middle" >{{ $jumat5->ruangan }}</td>
                                    </tr>
                                    <tr>
                                      <td align="middle" >
                                        <a id="edit-btn" class="btn btn-warning btn-xs" href="{{ route('jadwal.edit', $jumat5->id) }}"><span class="fa fa-pencil-square-o"></span> Edit</a>
                                      </td>
                                      <td align="middle" >
                                        <a id="delete-btn" class="btn btn-danger btn-xs" customParam="{{ route('jadwal.destroy', $jumat5->id) }}" href="#"><span class="fa fa-trash"></span> Hapus</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              @endif
                            </td>
                          </tr>
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
    $('#tabel-jadwal').dataTable();
</script>
<!-- /Datatables Artikel Index -->
@endsection
