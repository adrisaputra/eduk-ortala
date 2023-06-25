<?php

namespace App\Http\Controllers;

use App\Models\Classes;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB; //untuk membuat query di controller
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class ClassController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Jabatan";
        $classes = Classes::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.classes.index',compact('title','classes'));
    }

    ## Tampilkan Data Search
    public function search(Request $request)
    {
        $title = "Jabatan";
        $classes = $request->get('search');
        $classes = Classes::
                where(function ($query) use ($classes) {
                    $query->where('code', 'LIKE', '%'.$classes.'%')
                        ->orWhere('class', 'LIKE', '%'.$classes.'%')
                        ->orWhere('rank', 'LIKE', '%'.$classes.'%');
                })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        if($request->input('page')){
            return view('admin.classes.index',compact('title','classes'));
        } else {
            return view('admin.classes.search',compact('title','classes'));
        }
    }
     

	## Tampilkan Form Create
    public function sync()
    {
       // Tarik data dari API
       $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_all_golongan');

       // Menguraikan JSON menjadi array asosiatif
       $responseArray = json_decode($response, true);

       // Memeriksa apakah status bernilai true
       if ($responseArray['status']) {
           $data = $responseArray['data'];

           // Mengambil nilai NIP dari setiap objek dalam array data
           // $nips = array_column($data, 'NIP');

           // Menentukan ukuran setiap halaman (misalnya, 50 data per halaman)
           $perPage = 25;

           // Memecah data menjadi halaman-halaman yang lebih kecil
           $pages = array_chunk($data, $perPage);

           // Menampilkan nilai NIP dan Nama per halaman
           foreach ($pages as $page) {
               foreach ($page as $item) {

                   $classes = Classes::where('code',$item['KdGol'])->first();
                   if($classes){
                       $classes->code =  $item['KdGol'];
                       $classes->class =  $item['Golongan'];
                       $classes->rank =  $item['Pangkat'];
                       $classes->save();
                   } else {
                       $classes = New Classes();
                       $classes->code =  $item['KdGol'];
                       $classes->class =  $item['Golongan'];
                       $classes->rank =  $item['Pangkat'];
                       $classes->save();
                   }
               }
           }

           activity()->log('Sinkronisasi Data Class');
           return redirect('/class')->with('status', 'Data Berhasil Disinkronisasi');
       } else {
           // return redirect()->back()->with('error', 'Failed to pull data from API.');
       }

       // echo $response;
    }
    
}
