<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

use DB;
use File;
use Response;

use Auth;
use App\Http\Requests;
use App\Fakultas;
use App\User;

class FakultasController extends Controller
{
  public function index()
  {
    echo env('TELEGRAM_BOT_TOKEN');
    // $semuaFakultas = Fakultas::all();
    //
    // return view('front.fakultas.index', compact('semuaFakultas'));
  }

  public function store($input)
  {
    DB::beginTransaction();

    try{
        $fakultas_data['nama'] = $input;
        $fakultas_data['created_by'] = Auth::user()->id;

        Fakultas::create($fakultas_data);

        DB::commit();

        alert()->success('Data berhasil di tambahkan', 'Tambah Data Berhasil!');
        return redirect()->route('fakultas.index');
    }catch(\Exception $e){
        DB::rollback();

        throw $e;
    }
  }

  public function update($id, $input)
  {
    DB::beginTransaction();

    try{
        $fakultas_dataBaru['nama'] = $input;
        $fakultas_dataBaru['updated_by'] = Auth::user()->id;

        $fakultas = Fakultas::find($id);

        $fakultas->update($fakultas_dataBaru);

        DB::commit();

        alert()->success('Data berhasil di edit', 'Edit Berhasil!');
        return redirect()->route('fakultas.index');
    }catch(\Exception $e){
        DB::rollback();

        throw $e;
    }
  }

  public function destroy($id)
  {
    DB::beginTransaction();

    try{
        $fakultas = Fakultas::find($id);
        $fakultas->deleted_at = date("Y-m-d H:i:s");
        $fakultas->deleted_by = Auth::user()->id;
        $fakultas->save();

        DB::commit();

        alert()->success('Data berhasil di hapus', 'Hapus Berhasil!');
        return redirect()->route('fakultas.index');

    }catch(\Exception $e){
        DB::rollback();

        throw $e;
    }
  }

  public function terhapusRestore($id)
  {
    DB::beginTransaction();

    try{
        $fakultas = Fakultas::find($id);
        $fakultas->deleted_at = NULL;
        $fakultas->deleted_by = NULL;
        $fakultas->updated_by = Auth::user()->id;
        $fakultas->save();

        DB::commit();

        alert()->success('Data berhasil di kembalikan', 'Pemulihan Berhasil!');
        return redirect()->route('fakultas.index');
    }catch(\Exception $e){
        DB::rollback();

        throw $e;
    }
  }

  public function terhapusDestroy($id)
  {
    DB::beginTransaction();

    try{
        $fakultas = Fakultas::find($id);
        $fakultas->delete();

        DB::commit();

        alert()->success('Data berhasil di hapus permanen', 'Hapus Permanen!');
        return redirect()->route('fakultas.index');
    }catch(\Exception $e){
        DB::rollback();

        throw $e;
    }
  }
}
