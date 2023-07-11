<?php

namespace App\Http\Controllers;

use App\Models\Employee;   //nama model
use App\Models\PositionHistory;   //nama model
use App\Models\Synchronization;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class PositionHistoryController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index(Employee $employee)
    {
        $title = "Riwayat Jabatan";
        $position_history = PositionHistory::where('NIP',$employee->nip)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.position_history.index',compact('title','employee','position_history'));
    }

     ## Tampilkan Data Search
     public function search(Employee $employee, Request $request)
     {
        $title = "Riwayat Jabatan";
        $position_history = $request->get('search');
        $position_history = PositionHistory::where('NIP',$employee->nip)
                            ->where(function ($query) use ($position_history) {
                                $query->where('unit', 'LIKE', '%'.$position_history.'%')
                                ->orWhere('position_type', 'LIKE', '%'.$position_history.'%')
                                ->orWhere('position', 'LIKE', '%'.$position_history.'%')
                                ->orWhere('eselon', 'LIKE', '%'.$position_history.'%');
                            })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        if($request->input('page')){
            return view('admin.position_history.index',compact('title','position_history'));
        } else {
            return view('admin.position_history.search',compact('title','position_history'));
        }
     }
     
    ## Tampilkan Form Create
    public function sync_all()
    {
        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_count_all_riwayat_jabatan_by_nip');
        $data = json_decode($response, true);
        $count_all_data = $data['data'];

        $synchronization = Synchronization::where('category','position_history')->first();
        $synchronization->status =  'Process';
        $synchronization->count_all_data =  $count_all_data;
        $synchronization->save();

        $position_history = PositionHistory::truncate();
        $employee = Employee::select('id','nip')->get();

        foreach($employee as $v){


            // Tarik data dari API
            $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_jabatan_by_nip?nip='.$v->nip);

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
                        $position_history = New PositionHistory();
                        $position_history->employee_id =  $v->id;
                        $position_history->nip =  $item['NIP'];
                        $position_history->unit =  $item['UNIT_KERJA'];
                        $position_history->position_type =  $item['JNS_JABATAN'];
                        $position_history->position =  $item['JABATAN'];
                        $position_history->eselon =  $item['ESELON'];
                        $position_history->tmt =  $item['TMT_JABATAN'];
                        $position_history->sk_number =  $item['No_SK'];
                        $position_history->sk =  $item['SK_LANTIK'];
                        $position_history->sk_date =  $item['TGL_SK'];
                        $position_history->official_name =  $item['PEJABAT_MENETAPKAN'];
                        $position_history->sworn_status =  $item['StatusSumpah'];
                        $position_history->current_position =  $item['JbtSaatIni'];
                        $position_history->save();
                    }
                }

                    activity()->log('Sinkronisasi Data Class History with NIP = '.$v->nip);
                    
                } else {
                    // return redirect('/position_history/'.$v->id)->with('status2', 'Data Gagal Disinkronisasi');
            }
        }
        
        $synchronization = Synchronization::where('category','position_history')->first();
        $synchronization->status =  'Done';
        $synchronization->save();
        
        return redirect('/position_employee')->with('status', 'Data Berhasil Disinkronisasi');
    }

	## Tampilkan Form Create
    public function sync(Employee $employee)
    {
        PositionHistory::where('nip',$employee->nip)->forceDelete();

        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_jabatan_by_nip?nip='.$employee->nip);

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

                       $position_history = New PositionHistory();
                       $position_history->employee_id =  $employee->id;
                       $position_history->nip =  $item['NIP'];
                       $position_history->unit =  $item['UNIT_KERJA'];
                       $position_history->position_type =  $item['JNS_JABATAN'];
                       $position_history->position =  $item['JABATAN'];
                       $position_history->eselon =  $item['ESELON'];
                       $position_history->tmt =  $item['TMT_JABATAN'];
                       $position_history->sk_number =  $item['No_SK'];
                       $position_history->sk =  $item['SK_LANTIK'];
                       $position_history->sk_date =  $item['TGL_SK'];
                       $position_history->official_name =  $item['PEJABAT_MENETAPKAN'];
                       $position_history->sworn_status =  $item['StatusSumpah'];
                       $position_history->current_position =  $item['JbtSaatIni'];
                       $position_history->save();
               }
           }

           activity()->log('Sinkronisasi Data Position History');
           return redirect('/position_history/'.$employee->id)->with('status', 'Data Berhasil Disinkronisasi');
       } else {
            return redirect('/position_history/'.$employee->id)->with('status2', 'Data Gagal Disinkronisasi');
       }

    }
}
