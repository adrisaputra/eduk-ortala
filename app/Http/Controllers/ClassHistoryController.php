<?php

namespace App\Http\Controllers;

use App\Models\Employee;   //nama model
use App\Models\ClassHistory;   //nama model
use App\Models\Classes;   //nama model
use App\Models\Synchronization;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class ClassHistoryController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index($employee)
    {
        $title = "Riwayat Golongan";
        $employee = Crypt::decrypt($employee);
        $employee = Employee::where('id',$employee)->first();
        $class_history = ClassHistory::where('NIP',$employee->nip)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.class_history.index',compact('title','employee','class_history'));
    }

     ## Tampilkan Data Search
     public function search($employee, Request $request)
     {
        $title = "Riwayat Golongan";
        $employee = Crypt::decrypt($employee);
        $employee = Employee::where('id',$employee)->first();
        $class_history = $request->get('search');
        $class_history = ClassHistory::where('NIP',$employee->nip)
                        ->where(function ($query) use ($class_history) {
                            $query->where('rank', 'LIKE', '%'.$class_history.'%')
                                ->orWhere('class', 'LIKE', '%'.$class_history.'%');
                        })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        if($request->input('page')){
            return view('admin.class_history.index',compact('title','class_history'));
        } else {
            return view('admin.class_history.search',compact('title','class_history'));
        }
     }
     
    ## Tampilkan Form Create
    public function sync_all()
    {
        
        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_count_all_riwayat_golongan_by_nip');
        $data = json_decode($response, true);
        $count_all_data = $data['data'];

        $synchronization = Synchronization::where('category','class_history')->first();
        $synchronization->status =  'Process';
        $synchronization->count_all_data =  $count_all_data;
        $synchronization->save();

        ClassHistory::truncate();
        $employee = Employee::select('id','nip')->get();

        foreach($employee as $v){

            // Tarik data dari API
            $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_golongan_by_nip?nip='.$v->nip);

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
                        $class_history = New ClassHistory();
                        $class_history->employee_id =  $v->id;
                        $class_history->nip =  $item['NIP'];

                        $class = Classes::where('code',$item['KdGol'])->first();
                        $class_history->classes_id =  $class ? $class->id : null;
                        
                        $class_history->rank =  $item['Pangkat'];
                        $class_history->class =  $item['Golongan'];
                        $class_history->tmt =  $item['TMT_Pangkat'];
                        $class_history->sk_official =  $item['SK_Pejabat'];
                        $class_history->sk_number =  $item['SK_Nomor'];
                        $class_history->sk_date =  $item['SK_Tanggal'];
                        $class_history->mk_year =  $item['MKerja_Thn'];
                        $class_history->mk_month =  $item['MKerja_bln'];
                        $class_history->current_rank =  $item['PktSaatIni'];
                        $class_history->no_bkn =  $item['no_bkn'];
                        $class_history->date_bkn =  $item['tgl_bkn'];
                        $class_history->kp_type =  $item['jenis_kp'];
                        $class_history->save();
                    }
                }

                    activity()->log('Sinkronisasi Data Class History with NIP = '.$v->nip);
                    
                } else {
                    // return redirect('/class_history/'.$v->id)->with('status2', 'Data Gagal Disinkronisasi');
            }
        }
        
        $synchronization = Synchronization::where('category','class_history')->first();
        $synchronization->status =  'Done';
        $synchronization->save();
        
        return redirect('/class_employee')->with('status', 'Data Berhasil Disinkronisasi');
    }

	## Tampilkan Form Create
    public function sync($employee)
    {
        
        $employee = Crypt::decrypt($employee);
        $employee = Employee::where('id',$employee)->first();

        ClassHistory::where('nip',$employee->nip)->forceDelete();

       // Tarik data dari API
       $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_golongan_by_nip?nip='.$employee->nip);

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
                    $class_history = New ClassHistory();
                    $class_history->employee_id =  $employee->id;
                    $class_history->nip =  $item['NIP'];

                    $class = Classes::where('code',$item['KdGol'])->first();
                    $class_history->classes_id =  $class ? $class->id : null;
                    
                    $class_history->rank =  $item['Pangkat'];
                    $class_history->class =  $item['Golongan'];
                    $class_history->tmt =  $item['TMT_Pangkat'];
                    $class_history->sk_official =  $item['SK_Pejabat'];
                    $class_history->sk_number =  $item['SK_Nomor'];
                    $class_history->sk_date =  $item['SK_Tanggal'];
                    $class_history->mk_year =  $item['MKerja_Thn'];
                    $class_history->mk_month =  $item['MKerja_bln'];
                    $class_history->current_rank =  $item['PktSaatIni'];
                    $class_history->no_bkn =  $item['no_bkn'];
                    $class_history->date_bkn =  $item['tgl_bkn'];
                    $class_history->kp_type =  $item['jenis_kp'];
                    $class_history->save();
               }
           }

           activity()->log('Sinkronisasi Data ClassHistory');
           return redirect('/class_history/'.Crypt::encrypt($employee->id))->with('status', 'Data Berhasil Disinkronisasi');
       } else {
            return redirect('/class_history/'.Crypt::encrypt($employee->id))->with('status2', 'Data Gagal Disinkronisasi');
       }

    }
}
