<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use DB;
use File;
use Response;

use Auth;
use App\Http\Requests;

use App\User;
use App\Sesi;
use App\Fakultas;
use App\Prodi;
use App\SesiProdi;
use App\Jadwal;

class JadwalController extends Controller
{
  public function indexUjian() {
    return view('front.ujian.index');
  }

  public function indexKuis() {
    return view('front.kuis.index');
  }

  public function indexTugas() {
    return view('front.tugas.index');
  }

  public function index() {
    $userId = Auth::user()->id;
    $user = User::find($userId);

    $semuaJadwal = $user->jadwal;

    $senin1ID = 1;
    $senin2ID = 2;
    $senin3ID = 3;
    $senin4ID = 4;
    $senin5ID = 5;

    $selasa1ID = 6;
    $selasa2ID = 7;
    $selasa3ID = 8;
    $selasa4ID = 9;
    $selasa5ID = 10;

    $rabu1ID = 11;
    $rabu2ID = 12;
    $rabu3ID = 13;
    $rabu4ID = 14;
    $rabu5ID = 15;

    $kamis1ID = 16;
    $kamis2ID = 17;
    $kamis3ID = 18;
    $kamis4ID = 19;
    $kamis5ID = 20;

    $jumat1ID = 21;
    $jumat2ID = 22;
    $jumat3ID = 23;
    $jumat4ID = 24;
    $jumat5ID = 25;

    $senin1 = NULL;
    $senin2 = NULL;
    $senin3 = NULL;
    $senin4 = NULL;
    $senin5 = NULL;

    $selasa1 = NULL;
    $selasa2 = NULL;
    $selasa3 = NULL;
    $selasa4 = NULL;
    $selasa5 = NULL;

    $rabu1 = NULL;
    $rabu2 = NULL;
    $rabu3 = NULL;
    $rabu4 = NULL;
    $rabu5 = NULL;

    $kamis1 = NULL;
    $kamis2 = NULL;
    $kamis3 = NULL;
    $kamis4 = NULL;
    $kamis5 = NULL;

    $jumat1 = NULL;
    $jumat2 = NULL;
    $jumat3 = NULL;
    $jumat4 = NULL;
    $jumat5 = NULL;

    foreach ($semuaJadwal as $jadwal) {
      if($jadwal->sesi->sesi_id == 1) {
        $senin1 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 2) {
        $senin2 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 3) {
        $senin3 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 4) {
        $senin4 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 5) {
        $senin5 = $jadwal;
      }else if($jadwal->sesi->sesi_id == 6) {
        $selasa1 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 7) {
        $selasa2 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 8) {
        $selasa3 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 9) {
        $selasa4 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 10) {
        $selasa5 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 11) {
        $rabu1 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 12) {
        $rabu2 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 13) {
        $rabu3 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 14) {
        $rabu4 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 15) {
        $rabu5 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 16) {
        $kamis1 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 17) {
        $kamis2 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 18) {
        $kamis3 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 19) {
        $kamis4 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 20) {
        $kamis5 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 21) {
        $jumat1 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 22) {
        $jumat2 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 23) {
        $jumat3 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 24) {
        $jumat4 = $jadwal;
      } else if($jadwal->sesi->sesi_id == 25) {
        $jumat5 = $jadwal;
      }
    }

    $semuaSesiProdi = SesiProdi::all();
    $semuaSesi = Sesi::all();
    $sesiMax = Sesi::max('sesi');
    $hariCount = Sesi::distinct('hari')->count('hari');

    return view("front.jadwal.index", compact(
      'semuaJadwal', 'semuaSesi', 'semuaSesiProdi', 'sesiMax', 'hariCount',
      'senin1', 'senin1ID',
      'senin2', 'senin2ID',
      'senin3', 'senin3ID',
      'senin4', 'senin4ID',
      'senin5', 'senin5ID',
      'selasa1', 'selasa1ID',
      'selasa2', 'selasa2ID',
      'selasa3', 'selasa3ID',
      'selasa4', 'selasa4ID',
      'selasa5', 'selasa5ID',
      'rabu1', 'rabu1ID',
      'rabu2', 'rabu2ID',
      'rabu3', 'rabu3ID',
      'rabu4', 'rabu4ID',
      'rabu5', 'rabu5ID',
      'kamis1', 'kamis1ID',
      'kamis2', 'kamis2ID',
      'kamis3', 'kamis3ID',
      'kamis4', 'kamis4ID',
      'kamis5', 'kamis5ID',
      'jumat1', 'jumat1ID',
      'jumat2', 'jumat2ID',
      'jumat3', 'jumat3ID',
      'jumat4', 'jumat4ID',
      'jumat5', 'jumat5ID'
    ));
  }

  public function checkJadwal($sesiID) {
    $userJadwal = User::find(Auth::user()->id)->jadwal;

    foreach ($userJadwal as $jadwal) {
      if($jadwal->sesi->sesi->id == $sesiID) {
        return false;
      }
    }
    return true;
  }

  public function create($id) {
    if($this->checkJadwal($id) == false) {
      alert()->error('Maaf jadwal untuk sesi itu sudah ada, silahkan hapus terlebih dahulu', 'Jadwal Sudah Ada!');
      return redirect()->route('jadwal.index');
    } else if($this->checkJadwal($id) == true) {
      $sesi_id = $id;

      $sesi_data = Sesi::find($id);
      $hari = $sesi_data->hari;
      $sesi = $sesi_data->sesi;

      return view('front.jadwal.create', compact('sesi_id','hari', 'sesi'));
    }
  }

  public function checkSesiProdi($userProdi, $sesiID) {
    $sesiProdiMulai = SesiProdi::select('id')->where([
      ['prodi_id', '=', $userProdi],
      ['sesi_id', '=', $sesiID]
      ])->get();
    $sesiProdiCheck = $sesiProdiMulai->count();

    if($sesiProdiCheck == 0) {
      return false;
    } else if($sesiProdiCheck > 1){
      return false;
    } else {
      $sesiProdiID = SesiProdi::find($sesiProdiMulai)->id;
      return $sesiProdiID;
    }
  }

  public function store(Request $request)
  {
    $jadwal_data = $request->except('_token');

    $this->validate($request, [
      'sesi_id' => 'required',
      'makul' => 'required',
      'keyword' => 'required',
      'kelas' => 'required',
      'ruangan' => 'required',
      'hari' => 'required',
      'sesiMulai' => 'required',
    ]);

    $jadwal_data['user_id'] = Auth::user()->id;
    $jadwal_data['created_by'] = Auth::user()->id;

    $userProdi = User::find(Auth::user()->id)->prodi_id;

    $sesiProdiMulai = $this->checkSesiProdi($userProdi, $jadwal_data['sesi_id']);

    if($sesiProdiMulai == false) {
      alert()->error('Maaf data sesi-prodi anda belum ada, silahkan hubungi administrator', 'Sesi-Prodi Tidak Ada!');
      return redirect()->route('jadwal.index');
    } else {

      if($jadwal_data['sesiSelesai'] != NULL) {
        $hasilSesi = Sesi::select('id')->where([
          ['hari', 'LIKE', $jadwal_data['hari']],
          ['sesi', '>=', $jadwal_data['sesiMulai']],
          ['sesi', '<=', $jadwal_data['sesiSelesai']]
          ])->get();

          $hasilSesiProdi = array();

        foreach ($hasilSesi as $sesi) {
          if($this->checkJadwal($sesi->id) == true) {
            if($this->checkSesiProdi($userProdi, $sesi->id) != false) {
              $hasilSesiProdi[] = $this->checkSesiProdi($userProdi, $sesi->id);
            } else {
              alert()->error('Maaf data sesi-prodi anda belum ada, silahkan hubungi administrator', 'Sesi-Prodi Tidak Ada!');
              return redirect()->route('jadwal.index');
            }
          } else if($this->checkJadwal($sesi->id) == false) {
            alert()->error('Maaf jadwal untuk sesi itu sudah ada, silahkan hapus terlebih dahulu', 'Jadwal Sudah Ada!');
            return redirect()->route('jadwal.index');
          }
        }

        DB::beginTransaction();

        try{
          foreach ($hasilSesiProdi as $value) {
            $jadwal_data['sesi_prodi_id_selesai'] = end($hasilSesiProdi);
            $jadwal_data['sesi_prodi_id'] = $value;
            Jadwal::create($jadwal_data);
          }

          DB::commit();
          alert()->success('Jadwal berhasil di tambahkan', 'Tambah Jadwal Berhasil!');
          return redirect()->route('jadwal.index');
        }catch(\Exception $e){
            DB::rollback();

            throw $e;
        }
      } else {
        $jadwal_data['sesi_prodi_id'] = $sesiProdiMulai;

        DB::beginTransaction();

        try{
          Jadwal::create($jadwal_data);

          DB::commit();
          alert()->success('Jadwal berhasil di tambahkan', 'Tambah Jadwal Berhasil!');
          return redirect()->route('jadwal.index');
        }catch(\Exception $e){
            DB::rollback();

            throw $e;
        }
      }
    }
  }

  public function edit($id) {
    $jadwal = Jadwal::find($id);

    return view('front.jadwal.edit', compact('jadwal'));
  }

  public function update(Request $request, $id) {
    $jadwal_data = $request->except('_token');

    $this->validate($request, [
      'makul' => 'required',
      'keyword' => 'required',
      'kelas' => 'required',
      'ruangan' => 'required',
      'hari' => 'required',
      'sesiMulai' => 'required',
    ]);

    // echo $jadwal_data['sesi_prodi_id'];
    // echo "</br>";
    // echo $jadwal_data['makul'];
    // echo "</br>";
    // echo $jadwal_data['keyword'];
    // echo "</br>";
    // echo $jadwal_data['kelas'];
    // echo "</br>";
    // echo $jadwal_data['ruangan'];
    // echo "</br>";
    // echo $jadwal_data['hari'];
    // echo "</br>";
    // echo $jadwal_data['sesiMulai'];
    // echo "</br>";
    // echo $jadwal_data['sesiSelesai'];
    $sesiSelesai = NULL;

    if(isset($jadwal_data['sesiSelesai'])){
      $sesiSelesai = $jadwal_data['sesiSelesai'];
    }

    $jadwal_data['updated_by'] = Auth::user()->id;

    if($sesiSelesai == NULL) {
      DB::beginTransaction();

      try{
          $jadwal = Jadwal::find($id);
          $jadwal->update($jadwal_data);

          DB::commit();

          alert()->success('Jadwal berhasil di edit', 'Edit Berhasil!');
          return redirect()->route('jadwal.index');
      }catch(\Exception $e){
          DB::rollback();

          throw $e;
      }
    } else {
      $jadwal = Jadwal::find($id);
      $jadwalSesiSelesai = $jadwal->sesiSelesai->sesi->sesi;
      $jadwalSelesai = $jadwal->sesi_prodi_id_selesai;
      $semuaJadwalSelesai = Jadwal::select('id')->where([
        ['sesi_prodi_id_selesai', '=', $jadwalSelesai],
        ['user_id', '=', Auth::user()->id]
        ])->get();

      if($sesiSelesai == $jadwalSesiSelesai)
      {
        DB::beginTransaction();

        try{
            foreach ($semuaJadwalSelesai as $value) {
              $jadwalUpdate = Jadwal::find($value->id);
              $jadwalUpdate->update($jadwal_data);
            }

            DB::commit();

            alert()->success('Jadwal berhasil di edit', 'Edit Berhasil!');
            return redirect()->route('jadwal.index');
        }catch(\Exception $e){
            DB::rollback();

            throw $e;
        }
      } else {
        $hasilSesi = Sesi::select('id')->where([
          ['hari', 'LIKE', $jadwal_data['hari']],
          ['sesi', '>=', $jadwal_data['sesiMulai']],
          ['sesi', '<=', $jadwal_data['sesiSelesai']]
          ])->get();

          $userProdi = User::find(Auth::user()->id)->prodi_id;

          $hasilSesiProdi = array();

          DB::beginTransaction();

          try{
            foreach ($semuaJadwalSelesai as $value) {
              $jadwalUpdate = Jadwal::find($value->id);
              $jadwalUpdate->delete();
            }

            DB::commit();
          }catch(\Exception $e){
              DB::rollback();

              throw $e;
          }

        foreach ($hasilSesi as $sesi) {
          if($this->checkJadwal($sesi->id) == true) {
            if($this->checkSesiProdi($userProdi, $sesi->id) != false) {
              $hasilSesiProdi[] = $this->checkSesiProdi($userProdi, $sesi->id);
            } else {
              alert()->error('Maaf data sesi-prodi anda belum ada, silahkan hubungi administrator', 'Sesi-Prodi Tidak Ada!');
              return redirect()->route('jadwal.index');
            }
          } else if($this->checkJadwal($sesi->id) == false) {
            alert()->error('Maaf jadwal untuk sesi itu sudah ada, silahkan hapus terlebih dahulu', 'Jadwal Sudah Ada!');
            return redirect()->route('jadwal.index');
          }
        }

        $jadwal_data['user_id'] = Auth::user()->id;
        $jadwal_data['created_by'] = Auth::user()->id;

        DB::beginTransaction();

        try{
          foreach ($hasilSesiProdi as $value) {
            $jadwal_data['sesi_prodi_id_selesai'] = end($hasilSesiProdi);
            $jadwal_data['sesi_prodi_id'] = $value;
            Jadwal::create($jadwal_data);
          }

          DB::commit();
          alert()->success('Jadwal berhasil di edit', 'Edit Jadwal Berhasil!');
          return redirect()->route('jadwal.index');
        }catch(\Exception $e){
            DB::rollback();

            throw $e;
        }
      }
    }
  }

  public function destroy($id) {
    $jadwal = Jadwal::find($id);
    $jadwalSelesai = $jadwal->sesi_prodi_id_selesai;

    if($jadwalSelesai == 0) {
      DB::beginTransaction();

      try{
        $jadwal->delete();

        DB::commit();
        alert()->success('Jadwal berhasil di hapus', 'Hapus Jadwal Berhasil!');
        return redirect()->route('jadwal.index');
      }catch(\Exception $e){
          DB::rollback();

          throw $e;
      }
    } else {
      $semuaJadwalSelesai = Jadwal::select('id')->where([
        ['sesi_prodi_id_selesai', '=', $jadwalSelesai],
        ['user_id', '=', Auth::user()->id]
        ])->get();

      DB::beginTransaction();

      try{
        foreach ($semuaJadwalSelesai as $value) {
          $jadwalDelete = Jadwal::find($value->id);
          $jadwalDelete->delete();
        }

        DB::commit();
        alert()->success('Jadwal berhasil di hapus', 'Hapus Jadwal Berhasil!');
        return redirect()->route('jadwal.index');
      }catch(\Exception $e){
          DB::rollback();

          throw $e;
      }
    }
  }

}
