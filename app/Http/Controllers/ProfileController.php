<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Hash;

use DB;
use File;
use Response;

use Auth;
use App\Http\Requests;
use App\User;
use App\Prodi;
use App\Fakultas;

class ProfileController extends Controller
{
  public function index()
  {
    $id = Auth::user()->id;
    $pengguna = User::find($id);

    $semuaProdi = Prodi::all();
    $semuaFakultas = Fakultas::all();

    $prodiId = $pengguna->prodi_id;
    $fakultasId = $pengguna->fakultas_id;

    return view('front.profile.index', compact('pengguna', 'semuaProdi', 'semuaFakultas', 'prodiId', 'fakultasId'));
  }

  public function editProfilePic($id)
  {
    $pengguna = User::find($id);
  }

  public function checkEmailDuplicate($email, $id) {
    $userCheck = User::select('id')->where([
        ['email', $email],
        ['id', '!=', $id]
      ])->get()->count();

    if($userCheck == 0) {
      return true;
    } else {
      return false;
    }
  }

  public function update(Request $request, $id)
  {
    $pengguna_data = $request->except('_token');

    $this->validate($request, [
        'fullname' => 'required',
        'email' => 'required',
        'npm' => 'required',
        'prodi_id' => 'required',
    ]);

    if(!isset($request['telegram_username']) ) {
      $pengguna_data['telegram_username'] = "";
    }

    if($this->checkEmailDuplicate($pengguna_data['email'], $id) == true ) {
      $pengguna = User::find($id);

      if(!isset($request['telegram_username']) ) {
        $pengguna_data['telegram_username'] = "";
      }

      $fakultasId = Prodi::find($pengguna_data['prodi_id'])->fakultas->id;
      $pengguna_data['fakultas_id'] = $fakultasId;

      $filename = (string)($pengguna_data['fullname'] . '_' . date('Y-m-d') . '.jpg');

      if($request->hasFile('image')) {
          //$request->file('gambar_pengguna')->move('uploads/penggunaImage', $request->file('gambar_pengguna')->getClientOriginalName());
          $request->file('image')->move('uploads/ProfilePicture', $filename);
          $image = Image::make(sprintf('uploads/ProfilePicture/%s', $filename))->resize(256, 256)->save();
          //$pengguna_data['gambar_pengguna'] = $request->file('gambar_pengguna')->getClientOriginalName();
          $pengguna_data['image'] = $filename;

          if($pengguna->image != NULL)
          {
            File::delete('uploads/ProfilePicture'.$pengguna->image);
          }
        }
        else {
          unset($pengguna_data['image']);
        }

      DB::beginTransaction();

      try {

        $pengguna->update($pengguna_data);

        DB::commit();

        alert()->success('Data berhasil di perbaharui', 'Pembaharuan Berhasil!');
        return redirect()->route('Profile.index');
      } catch (\Exception $e) {
        DB::rollback();

        throw $e;
      }
    } else {
      alert()->error('Maaf email tersebut sudah terdaftar', 'Gagal Ganti Email!');
      return redirect()->route('Profile.index');
    }

  }

  public function updateFoto(Request $request, $id)
  {
    $pengguna_data = $request->except('_token');

    $this->validate($request, [
        'image' => 'image',
    ]);

    $pengguna = User::find($id);

    $filename = (string)($pengguna->fullname . '_' . date('Y-m-d') . '.jpg');

    if($request->hasFile('image')) {
        //$request->file('gambar_pengguna')->move('uploads/penggunaImage', $request->file('gambar_pengguna')->getClientOriginalName());
        $request->file('image')->move('uploads/ProfilePicture', $filename);
        $image = Image::make(sprintf('uploads/ProfilePicture/%s', $filename))->resize(256, 256)->save();
        //$pengguna_data['gambar_pengguna'] = $request->file('gambar_pengguna')->getClientOriginalName();
        $pengguna_data['image'] = $filename;

        if($pengguna->image != NULL)
        {
          File::delete('uploads/ProfilePicture'.$pengguna->image);
        }
      }
      else {
        unset($pengguna_data['image']);
      }

      DB::beginTransaction();

      try {

        $pengguna->update($pengguna_data);

        DB::commit();

        alert()->success('Data berhasil di perbaharui', 'Pembaharuan Berhasil!');
        return redirect()->route('Profile.index');
      } catch (\Exception $e) {
        DB::rollback();

        throw $e;
      }
  }

  public function updatePass(Request $request, $id)
  {
    $pengguna_data = $request->except('_token');

    $this->validate($request, [
        'password_lama' => 'required',
        'password' => 'required|confirmed',
        'password_confirmation' => 'required',
    ]);

    $pengguna = User::find($id);

    if (Hash::check($pengguna_data['password_lama'], $pengguna->password) ) {

      $pengguna_data['password'] = bcrypt($pengguna_data['password']);

      DB::beginTransaction();

      try {

        $pengguna->update($pengguna_data);

        DB::commit();

        alert()->success('Data berhasil di perbaharui', 'Pembaharuan Berhasil!');
        return redirect()->route('Profile.index');
      } catch (\Exception $e) {
        DB::rollback();

        throw $e;
      }
    }
    else {
      alert()->error('Password lama anda salah', 'Password Salah!');
      return redirect()->route('Profile.index');
    }
  }
}
