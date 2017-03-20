@extends('front.template')

@section('content')

        <div class="right_col" role="main">
          <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
              <a href="#">
              <div class="icon"><i class="fa fa-users"></i>
              </div>
              <div class="count">{{ $totalUser }}</div>

              <h3>Mahasiswa</h3>
              <p>Total mahasiswa aktif terdaftar.</p>
              </a>
            </div>
          </div>

          <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
              <a href="{{ route('fakultas.index') }}">
              <div class="icon"><i class="fa fa-university"></i>
              </div>
              <div class="count">{{ $totalFakultas }}</div>

              <h3>Fakultas</h3>
              <p>Total fakultas terdaftar.</p>
              </a>
            </div>
          </div>

          <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
              <a href="{{ route('prodi.index') }}">
              <div class="icon"><i class="fa fa-home"></i>
              </div>
              <div class="count">{{ $totalProdi }}</div>

              <h3>Program Studi</h3>
              <p>Total program studi terdaftar.</p>
              </a>
            </div>
          </div>

          <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
              <a href="{{ route('sesi.index') }}">
              <div class="icon"><i class="fa fa-exchange"></i>
              </div>
              <div class="count">{{ $totalSesi }}</div>

              <h3>Sesi</h3>
              <p>Total sesi terdaftar.</p>
              </a>
            </div>
          </div>

        </div>
@endsection
