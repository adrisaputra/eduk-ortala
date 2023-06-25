<?php

namespace App\Http\Controllers;

use App\Models\Education;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class EducationController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Pendidikan";
        $education = Education::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.education.index',compact('title','education'));
    }

     ## Tampilkan Data Search
     public function search(Request $request)
     {
        $title = "Pendidikan";
        $education = $request->get('search');
        $education = Education::where('name', 'LIKE', '%'.$education.'%')
                ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        if($request->input('page')){
            return view('admin.education.index',compact('title','education'));
        } else {
            return view('admin.education.search',compact('title','education'));
        }
     }
     

	## Tampilkan Form Create
    public function sync()
    {
       // Tarik data dari API
       $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_all_pendidikan');

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

                   $education = Education::where('code',$item['KodePend'])->first();
                   if($education){
                       $education->code =  $item['KodePend'];
                       $education->name =  $item['Pendidikan'];
                       $education->level_code =  $item['KdTingkat'];
                       $education->save();
                   } else {
                       $education = New Education();
                       $education->code =  $item['KodePend'];
                       $education->name =  $item['Pendidikan'];
                       $education->level_code =  $item['KdTingkat'];
                       $education->save();
                   }
               }
           }

           activity()->log('Sinkronisasi Data Education');
           return redirect('/education')->with('status', 'Data Berhasil Disinkronisasi');
       } else {
           // return redirect()->back()->with('error', 'Failed to pull data from API.');
       }

       // echo $response;
    }

    // Fetch records
    public function get_education(Request $request){
        $search = $request->search;

        if($search == ''){
            $education = Education::limit(25)->get();
        }else{
            $education = Education::where('name', 'like', '%' .$search . '%')->limit(25)->get();
        }

        $response = array();
            foreach($education as $v){
            $response[] = array(
                    "id"=>$v->id,
                    "text"=>$v->name
            );
        }
        return response()->json($response); 
    } 

    
}
