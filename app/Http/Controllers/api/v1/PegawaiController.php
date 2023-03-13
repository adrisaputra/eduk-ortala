<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Pegawai;   //nama model
use App\Models\User;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    
    public function index()
    {
        $pegawai = Pegawai::where('status_hapus', 0)->orderBy('id', 'DESC')->paginate(25)->onEachSide(1);
        return response([
            'success' => true,
            'message' => 'List Semua data Pegawai',
            'data' => $pegawai
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            // 'nip' => 'required|unique:pegawai_tbl|numeric|digits:18',
            'nama_pegawai' => 'required',
            // 'tempat_lahir' => 'required',
            // 'tanggal_lahir' => 'required',
            // 'jenis_kelamin' => 'required',
            // 'alamat' => 'required',
            // 'agama' => 'required',
            // 'foto_formal' => 'mimes:jpg,jpeg,png|max:500',
            // 'foto_kedinasan' => 'mimes:jpg,jpeg,png|max:500',
            // 'status' => 'required',
            // 'keterangan' => 'required',
        ]);

        // $input['nip'] = $request->nip;
        $input['nama_pegawai'] = $request->nama_pegawai;
        // $input['tempat_lahir'] = $request->tempat_lahir;
        // $input['tanggal_lahir'] = $request->tanggal_lahir;
        // $input['jenis_kelamin'] = $request->jenis_kelamin;
        // $input['alamat'] = $request->alamat;
        // $input['agama'] = $request->agama;
        // $input['gol_darah'] = $request->gol_darah;
        // $input['email'] = $request->email;
        // $input['status'] = $request->status;
        // $input['keterangan'] = $request->keterangan;

        // if ($request->file('foto_formal')) {
        //     $input['foto_formal'] = time() . '.' . $request->file('foto_formal')->getClientOriginalExtension();

        //     $request->file('foto_formal')->storeAs('public/upload/foto_formal_pegawai', $input['foto_formal']);
        //     $request->file('foto_formal')->storeAs('public/upload/foto_formal_pegawai/thumbnail', $input['foto_formal']);

        //     $thumbnailpath = public_path('storage/upload/foto_formal_pegawai/thumbnail/' . $input['foto_formal']);
        //     $img = Image::make($thumbnailpath)->resize(400, 150, function ($constraint) {
        //         $constraint->aspectRatio();
        //     });
        //     $img->save($thumbnailpath);
        // }

        // if ($request->file('foto_kedinasan')) {
        //     $input['foto_kedinasan'] = time() . '.' . $request->file('foto_kedinasan')->getClientOriginalExtension();

        //     $request->file('foto_kedinasan')->storeAs('public/upload/foto_kedinasan_pegawai', $input['foto_kedinasan']);
        //     $request->file('foto_kedinasan')->storeAs('public/upload/foto_kedinasan_pegawai/thumbnail', $input['foto_kedinasan']);

        //     $thumbnailpath = public_path('storage/upload/foto_kedinasan_pegawai/thumbnail/' . $input['foto_kedinasan']);
        //     $img = Image::make($thumbnailpath)->resize(400, 150, function ($constraint) {
        //         $constraint->aspectRatio();
        //     });
        //     $img->save($thumbnailpath);
        // }

        $pegawai = Pegawai::create($input);

        if ($pegawai) {
            return response()->json([
                'success' => true,
                'message' => 'Data Tersimpan',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Gagal Disimpan!',
            ], 401);
        }
    }
}
