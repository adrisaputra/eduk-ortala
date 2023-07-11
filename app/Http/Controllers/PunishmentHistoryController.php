<?php

namespace App\Http\Controllers;

use App\Models\Employee;   //nama model
use App\Models\PunishmentHistory;   //nama model
use App\Models\Synchronization;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class PunishmentHistoryController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index(Employee $employee)
    {
        $title = "Riwayat Hukuman";
        $punishment_history = PunishmentHistory::where('NIP',$employee->nip)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.punishment_history.index',compact('title','employee','punishment_history'));
    }

     ## Tampilkan Data Search
     public function search(Request $request)
     {
        $title = "Riwayat Hukuman";
        $punishment_history = $request->get('search');
        $punishment_history = PunishmentHistory::where('name', 'LIKE', '%'.$punishment_history.'%')
                ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        if($request->input('page')){
            return view('admin.punishment_history.index',compact('title','punishment_history'));
        } else {
            return view('admin.punishment_history.search',compact('title','punishment_history'));
        }
     }
     
    ## Tampilkan Form Create
    public function sync_all()
    {
        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_count_all_riwayat_hukuman_by_nip');
        $data = json_decode($response, true);
        $count_all_data = $data['data'];

        $synchronization = Synchronization::where('category','punishment_history')->first();
        $synchronization->status =  'Process';
        $synchronization->count_all_data =  $count_all_data;
        $synchronization->save();

        $punishment_history = PunishmentHistory::truncate();
        $employee = Employee::select('id','nip')->get();

        foreach($employee as $v){

            // Tarik data dari API
            $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_hukuman_by_nip?nip='.$v->nip);

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
                        $punishment_history = New PunishmentHistory();
                        $punishment_history->employee_id =  $v->id;
                        $punishment_history->nip =  $item['NIP'];
                        $punishment_history->sk_number =  $item['NoSkHukuman'];
                        $punishment_history->sk_date =  $item['TglSKHukum'];
                        $punishment_history->official_name =  $item['Pejabat'];
                        $punishment_history->punishment =  $item['Hukuman'];
                        $punishment_history->desc =  $item['UraianKesalahan'];
                        $punishment_history->save();
                    }
                }

                    activity()->log('Sinkronisasi Data Class History with NIP = '.$v->nip);
                    
                } else {
                    // return redirect('/punishment_history/'.$v->id)->with('status2', 'Data Gagal Disinkronisasi');
            }
        }
        
        $synchronization = Synchronization::where('category','punishment_history')->first();
        $synchronization->status =  'Done';
        $synchronization->save();
        
        return redirect('/punishment_employee')->with('status', 'Data Berhasil Disinkronisasi');
    }

	## Tampilkan Form Create
    public function sync(Employee $employee)
    {
        PunishmentHistory::where('nip',$employee->nip)->forceDelete();

        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_hukuman_by_nip?nip='.$employee->nip);

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

                       $punishment_history = New PunishmentHistory();
                       $punishment_history->employee_id =  $employee->id;
                       $punishment_history->nip =  $item['NIP'];
                       $punishment_history->sk_number =  $item['NoSkHukuman'];
                       $punishment_history->sk_date =  $item['TglSKHukum'];
                       $punishment_history->official_name =  $item['Pejabat'];
                       $punishment_history->punishment =  $item['Hukuman'];
                       $punishment_history->desc =  $item['UraianKesalahan'];
                       $punishment_history->save();
               }
           }

           activity()->log('Sinkronisasi Data Punishment History');
           return redirect('/punishment_history/'.$employee->id)->with('status', 'Data Berhasil Disinkronisasi');
       } else {
            return redirect('/punishment_history/'.$employee->id)->with('status2', 'Data Tidak Ada');
       }

    }
}
