<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use DB;
use File;
use Response;

use Auth;
use App\Http\Requests;
use App\Fakultas;
use App\Prodi;
use App\User;

class ProdiController extends Controller
{
    public function index() {
      $semuaProdi = Prodi::all();

      return view("front.prodi.index", compact("semuaProdi"));
    }

    public function create()
    {
      $semuaFakultas = Fakultas::all();
        return view('front.prodi.create', compact('semuaFakultas'));
    }

    public function store(Request $request)
    {
      $prodi_data = $request->except('_token');

      $this->validate($request, [
          'nama' => 'required',
          'fakultas_id' => 'required',
      ]);

      $prodi_data['created_by'] = Auth::user()->id;

      DB::beginTransaction();

      try{
        Prodi::create($prodi_data);

        DB::commit();

        alert()->success('Data berhasil di tambahkan', 'Tambah Data Berhasil!');
        return redirect()->route('prodi.index');
      }catch(\Exception $e){
          DB::rollback();

          throw $e;
      }
    }

    public function edit($id)
    {
        $prodi = Prodi::find($id);
        $semuaFakultas = Fakultas::all();

        return view('front.prodi.edit', compact('prodi', 'semuaFakultas'));
    }

    public function update(Request $request, $id)
    {
      $prodi_data = $request->except('_token');

      $this->validate($request, [
          'nama' => 'required',
          'fakultas_id' => 'required',
      ]);

      if($prodi_data['fakultas_id'] == -1) {
        alert()->error('Fakultas yang anda pilih sudah dihapus, silahkan kontak admin', 'Edit Gagal!');
        return redirect()->route('prodi.index');
      }
      else {
        $prodi_data['updated_by'] = Auth::user()->id;

        DB::beginTransaction();

        try{
            $prodi = Prodi::find($id);
            $prodi->update($prodi_data);

            DB::commit();

            alert()->success('Data berhasil di edit', 'Edit Berhasil!');
            return redirect()->route('prodi.index');
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
          $prodi = Prodi::find($id);

          $prodi->deleted_by = Auth::user()->id;
          $prodi->deleted_at = Carbon::now();

          $prodi->save();

          DB::commit();

          alert()->success('Data berhasil di hapus', 'Hapus Berhasil!');
          return redirect()->route('prodi.index');
        } catch (\Exception $e) {
          DB::rollback();

          throw $e;
        }
    }

    public function terhapusRestore($id)
    {
      DB::beginTransaction();

      try{
          $prodi = Prodi::find($id);
          $prodi->deleted_at = NULL;
          $prodi->deleted_by = NULL;
          $prodi->updated_by = Auth::user()->id;
          $prodi->save();

          DB::commit();

          alert()->success('Data berhasil di kembalikan', 'Pemulihan Berhasil!');
          return redirect()->route('prodi.index');
      }catch(\Exception $e){
          DB::rollback();

          throw $e;
      }
    }
}
