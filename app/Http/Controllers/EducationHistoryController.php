<?php

namespace App\Http\Controllers;

use App\Models\Employee;   //nama model
use App\Models\EducationHistory;   //nama model
use App\Models\Education;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class EducationHistoryController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index(Employee $employee)
    {
        $title = "Riwayat Pendidikan";
        $education_history = EducationHistory::where('NIP',$employee->nip)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.education_history.index',compact('title','employee','education_history'));
    }

     ## Tampilkan Data Search
     public function search(Request $request)
     {
        $title = "Riwayat Pendidikan";
        $education_history = $request->get('search');
        $education_history = EducationHistory::where('name', 'LIKE', '%'.$education_history.'%')
                ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        if($request->input('page')){
            return view('admin.education_history.index',compact('title','education_history'));
        } else {
            return view('admin.education_history.search',compact('title','education_history'));
        }
     }
     
    ## Tampilkan Form Create
    public function sync_all()
    {
        $education_history = EducationHistory::truncate();
        $employee = Employee::select('id','nip')->get();

        foreach($employee as $v){


            // Tarik data dari API
            $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_pendidikan_by_nip?nip='.$v->nip);

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
                        $education_history = New EducationHistory();
                        $education_history->employee_id =  $v->id;
                        $education_history->nip =  $item['NIP'];
    
                        $education = Education::where('code',$item['KodePend'])->first();
                        $education_history->education_id =  $education ? $education->id : null;
                        
                        $education_history->official_name =  $item['PEND_NAMAPEJABAT'];
                        $education_history->diploma_number =  $item['PEND_NOIJAZAH'];
                        $education_history->diploma_date =  $item['PEND_TGLIJAZAH'];
                        $education_history->school_name =  $item['nama_sekolah'];
                        $education_history->current_education =  $item['pend_saat_ini'];
                        $education_history->save();
                    }
                }

                    activity()->log('Sinkronisasi Data Class History with NIP = '.$v->nip);
                    
                } else {
                    // return redirect('/education_history/'.$v->id)->with('status2', 'Data Gagal Disinkronisasi');
            }
        }
        

        return redirect('/education_employee')->with('status', 'Data Berhasil Disinkronisasi');
    }

	## Tampilkan Form Create
    public function sync(Employee $employee)
    {
        EducationHistory::where('nip',$employee->nip)->forceDelete();

        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_pendidikan_by_nip?nip='.$employee->nip);

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

                       $education_history = New EducationHistory();
                       $education_history->employee_id =  $employee->id;
                       $education_history->nip =  $item['NIP'];

                       $education = Education::where('code',$item['KodePend'])->first();
                       $education_history->education_id =  $education ? $education->id : null;
                       
                       $education_history->official_name =  $item['PEND_NAMAPEJABAT'];
                       $education_history->diploma_number =  $item['PEND_NOIJAZAH'];
                       $education_history->diploma_date =  $item['PEND_TGLIJAZAH'];
                       $education_history->school_name =  $item['nama_sekolah'];
                       $education_history->current_education =  $item['pend_saat_ini'];
                       $education_history->save();
               }
           }

           activity()->log('Sinkronisasi Data Education History');
           return redirect('/education_history/'.$employee->id)->with('status', 'Data Berhasil Disinkronisasi');
       } else {
            return redirect('/education_history/'.$employee->id)->with('status2', 'Data Gagal Disinkronisasi');
       }

    }
}
