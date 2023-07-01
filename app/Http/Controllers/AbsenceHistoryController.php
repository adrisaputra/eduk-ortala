<?php

namespace App\Http\Controllers;

use App\Models\Employee;   //nama model
use App\Models\AbsenceHistory;   //nama model
use App\Models\Absence;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class AbsenceHistoryController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index(Employee $employee)
    {
        $title = "Riwayat Absensi";
        $absence_history = AbsenceHistory::where('NIP',$employee->nip)->orderBy('date','ASC')->paginate(25)->onEachSide(1);
        return view('admin.absence_history.index',compact('title','employee','absence_history'));
    }

     ## Tampilkan Data Search
     public function search(Request $request)
     {
        $title = "Riwayat Absensi";
        $absence_history = $request->get('search');
        $absence_history = AbsenceHistory::where('date', 'LIKE', '%'.$absence_history.'%')
                ->orderBy('date','ASC')->paginate(25)->onEachSide(1);
        
        if($request->input('page')){
            return view('admin.absence_history.index',compact('title','absence_history'));
        } else {
            return view('admin.absence_history.search',compact('title','absence_history'));
        }
     }
     
    ## Tampilkan Form Create
    public function sync_all(Request $request)
    {
        $absence_history = AbsenceHistory::whereMonth('date', $request->month)->whereYear('date', $request->year)->forceDelete();
        $employee = Employee::select('id','nip')->get();

        foreach($employee as $v){

            // Tarik data dari API
            $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_absensi_by_nip?nip='.$v->nip.'&month='.$request->month.'&year='.$request->year);

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
                        $absence_history = New AbsenceHistory();
                        $absence_history->employee_id =  $v->id;
                        $absence_history->nip =  $item['NIP'];
                        $absence_history->date =  $item['date'];
                        $absence_history->in_type =  $item['in_type'];
                        $absence_history->in =  $item['in'];
                        $absence_history->out =  $item['out'];
                        $absence_history->time_zone =  $item['time_zone'];
                        $absence_history->save();
                    }
                }

                    activity()->log('Sinkronisasi Data Class History with NIP = '.$v->nip);
                    
                } else {
                    // return redirect('/absence_history/'.$v->id)->with('status2', 'Data Gagal Disinkronisasi');
            }
        }
        

        return redirect('/absence_employee')->with('status', 'Data Berhasil Disinkronisasi');
    }

	## Tampilkan Form Create
    public function sync(Employee $employee, Request $request)
    {
        AbsenceHistory::where('nip',$employee->nip)->whereMonth('date', $request->month)->whereYear('date', $request->year)->forceDelete();

        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_absensi_by_nip?nip='.$employee->nip.'&month='.$request->month.'&year='.$request->year);

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
                       $absence_history = New AbsenceHistory();
                       $absence_history->employee_id =  $employee->id;
                       $absence_history->nip =  $item['NIP'];
                       $absence_history->date =  $item['date'];
                       $absence_history->in_type =  $item['in_type'];
                       $absence_history->in =  $item['in'];
                       $absence_history->out =  $item['out'];
                       $absence_history->time_zone =  $item['time_zone'];
                       $absence_history->save();
               }
           }

           activity()->log('Sinkronisasi Data Absence History');
           return redirect('/absence_history/'.$employee->id)->with('status', 'Data Berhasil Disinkronisasi');
       } else {
            return redirect('/absence_history/'.$employee->id)->with('status2', 'Data Gagal Disinkronisasi');
       }

    }
}
