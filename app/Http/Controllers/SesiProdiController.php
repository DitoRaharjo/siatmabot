<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Hash;
use DB;
use File;
use Response;

use Auth;
use App\Http\Requests;
use App\Sesi;
use App\Fakultas;
use App\Prodi;
use App\SesiProdi;
use App\Jadwal;
use App\User;
use App\ChatLogLine;
use App\ChatLog;

class SesiProdiController extends Controller
{
    public function index() {
      // $registerUrl = "http://www.ditoraharjo.co/siatmabot/register";
      // $textReceived = "Halo";
      // $userId = 1334082683305106;
      // $hasil = app('App\Http\Controllers\FbBotController')->checkLogin($userId);
      //
      // if($hasil == true) {
      //   echo "sip";
      // } else {
      //   if (($check = strpos($textReceived, "-")) !== FALSE) {
      //     $email = strtok($textReceived, '-');
      //     $password = substr($textReceived, strpos($textReceived, "-") +1);
      //
      //     if(app('App\Http\Controllers\FbBotController')->checkEmail($email) == true) {
      //       if(app('App\Http\Controllers\FbBotController')->checkPassword($userId, $email, $password)== true ) {
      //         $textSend = "Selamat anda berhasil login, sekarang anda sudah bisa menggunakan fitur kuliah SIATMA Bot";
      //       } else {
      //         $textSend = "Maaf email atau password anda salah". PHP_EOL .
      //         "atau anda belum terdaftar". PHP_EOL .
      //         "jika anda belum mendaftar, silahkan daftarkan diri anda di : ". PHP_EOL .$registerUrl;
      //       }
      //     } else {
      //       $textSend = "Maaf email atau password anda salah". PHP_EOL .
      //       "atau anda belum terdaftar". PHP_EOL .
      //       "jika anda belum mendaftar, silahkan daftarkan diri anda di : ". PHP_EOL .$registerUrl;
      //     }
      //   } else {
      //     $textSend = "Maaf anda perlu login terlebih dahulu".PHP_EOL.
      //     "silahkan kirimkan chat email dan password yang sudah anda daftarkan di ". PHP_EOL .$registerUrl. PHP_EOL .
      //     "dengan format : email-password". PHP_EOL .
      //     "contoh: asdf@gmail.com-1234 ";
      //   }
      //   echo $textSend;
      // }
      //

      $semuaSesiProdi = SesiProdi::all();

      return view('front.sesiprodi.index', compact('semuaSesiProdi'));
    }

    public function create()
    {
      $semuaSesi = Sesi::all();
      $semuaFakultas = Fakultas::all();
      $semuaProdi = Prodi::all();

      return view('front.sesiProdi.create', compact('semuaSesi', 'semuaFakultas', 'semuaProdi'));
    }

    public function checkDuplicate($sesi_id, $prodi_id) {
      $sesiProdi = SesiProdi::select('id')->where([
        ['sesi_id', '=', $sesi_id],
        ['prodi_id', '=', $prodi_id]
        ])->get();
      $checkCount = $sesiProdi->count();
      if($checkCount == 0) {
        return true;
      } else {
        return false;
      }
    }

    public function store(Request $request)
    {
      $sesiProdi_data = $request->except('_token');

      $this->validate($request, [
        'sesi_id' => 'required',
        'prodi_id' => 'required',
        'jam' => 'required',
        'menit' => 'required',
      ]);

      if($this->checkDuplicate($sesiProdi_data['sesi_id'], $sesiProdi_data['prodi_id']) == false) {
        alert()->error('Maaf Jadwal Sudah Ada', 'Gagal Menambah Data!');
        return redirect()->route('sesiProdi.create');
      } else {
        $waktu = $sesiProdi_data['jam'].":".$sesiProdi_data['menit'].":00";
        $sesiProdi_data['waktu'] = $waktu;
        $sesiProdi_data['created_by'] = Auth::user()->id;

        // echo $sesiProdi_data['waktu'];

        DB::beginTransaction();

        try{
          SesiProdi::create($sesiProdi_data);

          DB::commit();

          alert()->success('Data berhasil di tambahkan', 'Tambah Data Berhasil!');
          return redirect()->route('sesiProdi.index');
        }catch(\Exception $e){
            DB::rollback();

            throw $e;
        }
      }
    }

    public function edit($id)
    {
      $semuaSesi = Sesi::all();
      $semuaFakultas = Fakultas::all();
      $semuaProdi = Prodi::all();

      $sesiProdi = SesiProdi::find($id);
      $jamBaru = substr($sesiProdi->waktu,0,2);
      $menitBaru = substr($sesiProdi->waktu,3,2);

      if(substr($jamBaru,0,1) == 0) {
        $jam = substr($jamBaru,1,1);
      } else {
        $jam = $jamBaru;
      }

      if(substr($menitBaru,0,1) == 0) {
        $menit = substr($jamBaru,1,1);
      } else {
        $menit = $menitBaru;
      }

      foreach ($semuaProdi as $prodi) {
        if($prodi->id == $sesiProdi->prodi_id) {
          $fakultasId = $prodi->fakultas->id;
          break;
        }
      }


      return view('front.sesiProdi.edit', compact('semuaSesi', 'semuaFakultas', 'semuaProdi', 'sesiProdi', 'jam', 'menit', 'fakultasId'));
    }

    public function update(Request $request, $id)
    {
      $sesiProdi_data = $request->except('_token');

      $this->validate($request, [
        'sesi_id' => 'required',
        'prodi_id' => 'required',
        'jam' => 'required',
        'menit' => 'required',
      ]);

      if($this->checkDuplicate($sesiProdi_data['sesi_id'], $sesiProdi_data['prodi_id']) == false) {
        alert()->error('Maaf Jadwal Sudah Ada', 'Gagal Menambah Data!');
        return redirect()->route('sesiProdi.edit', $id);
      } else {
        $waktu = $sesiProdi_data['jam'].":".$sesiProdi_data['menit'].":00";
        $sesiProdi_data['waktu'] = $waktu;
        $sesiProdi_data['updated_by'] = Auth::user()->id;

        DB::beginTransaction();

        try{
            $sesiProdi = SesiProdi::find($id);
            $sesiProdi->update($sesiProdi_data);

            DB::commit();

            alert()->success('Data berhasil di edit', 'Edit Berhasil!');
            return redirect()->route('sesiProdi.index');
        }catch(\Exception $e){
            DB::rollback();

            throw $e;
        }
      }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
          $sesiProdi = SesiProdi::find($id);

          $sesiProdi->deleted_by = Auth::user()->id;
          $sesiProdi->deleted_at = Carbon::now();

          $sesiProdi->save();

          DB::commit();

          alert()->success('Data berhasil di hapus', 'Hapus Berhasil!');
          return redirect()->route('sesiProdi.index');
        } catch (\Exception $e) {
          DB::rollback();

          throw $e;
        }
    }

    public function terhapusRestore($id)
    {
      DB::beginTransaction();

      try{
          $sesiProdi = SesiProdi::find($id);
          $sesiProdi->deleted_at = NULL;
          $sesiProdi->deleted_by = NULL;
          $sesiProdi->updated_by = Auth::user()->id;
          $sesiProdi->save();

          DB::commit();

          alert()->success('Data berhasil di kembalikan', 'Pemulihan Berhasil!');
          return redirect()->route('sesiProdi.index');
      }catch(\Exception $e){
          DB::rollback();

          throw $e;
      }
    }
}
