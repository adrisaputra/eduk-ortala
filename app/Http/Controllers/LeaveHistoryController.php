<?php

namespace App\Http\Controllers;

use App\Models\Employee;   //nama model
use App\Models\LeaveHistory;   //nama model
use App\Models\Synchronization;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class LeaveHistoryController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index(Employee $employee)
    {
        $title = "Riwayat Cuti";
        $leave_history = LeaveHistory::where('NIP',$employee->nip)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.leave_history.index',compact('title','employee','leave_history'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, Employee $employee)
    {
        $title = "Riwayat Cuti";
        $leave_history = $request->get('search');
        $leave_history = LeaveHistory::where('NIP',$employee->nip)
                            ->where(function ($query) use ($leave_history) {
                                $query->where('type', 'LIKE', '%'.$leave_history.'%')
                                        ->orWhere('info', 'LIKE', '%'.$leave_history.'%')
                                        ->orWhere('status', 'LIKE', '%'.$leave_history.'%');
                            })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        if($request->input('page')){
            return view('admin.leave_history.index',compact('title','leave_history'));
        } else {
            return view('admin.leave_history.search',compact('title','leave_history'));
        }
    }
    
     
    ## Tampilkan Form Create
    public function sync_all()
    {
        
        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_count_all_riwayat_cuti_by_nip');
        $data = json_decode($response, true);
        $count_all_data = $data['data'];

        $synchronization = Synchronization::where('category','leave_history')->first();
        $synchronization->status =  'Process';
        $synchronization->count_all_data =  $count_all_data;
        $synchronization->save();

        $leave_history = LeaveHistory::truncate();
        $employee = Employee::select('id','nip')->get();

        foreach($employee as $v){

            // Tarik data dari API
            $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_cuti_by_nip?nip='.$v->nip);

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
                        $leave_history = New LeaveHistory();
                        $leave_history->employee_id =  $v->id;
                        $leave_history->nip =  $item['NIP'];
                        $leave_history->type =  $item['cuti_type'];
                        $leave_history->hp =  $item['cuti_hp'];
                        $leave_history->info =  $item['cuti_info'];
                        $leave_history->status =  $item['cuti_status'];
                        $leave_history->final =  $item['cuti_final'];
                        $leave_history->duration =  $item['cuti_duration'];
                        $leave_history->note =  $item['cuti_note'];
                        $leave_history->file =  $item['cuti_file'];
                        $leave_history->date_start =  $item['date_start'];
                        $leave_history->date_finish =  $item['date_finish'];
                        $leave_history->letter_no =  $item['letter_no'];
                        $leave_history->letter_date =  $item['letter_date'];
                        $leave_history->save();
                    }
                }

                    activity()->log('Sinkronisasi Data Class History with NIP = '.$v->nip);
                    
                } else {
                    // return redirect('/leave_history/'.$v->id)->with('status2', 'Data Gagal Disinkronisasi');
            }
        }
        
        $synchronization = Synchronization::where('category','leave_history')->first();
        $synchronization->status =  'Done';
        $synchronization->save();
        
        return redirect('/leave_employee')->with('status', 'Data Berhasil Disinkronisasi');
    }

    ## Tampilkan Form Create
    public function sync(Employee $employee)
    {
        LeaveHistory::where('nip',$employee->nip)->forceDelete();

        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_cuti_by_nip?nip='.$employee->nip);

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

                       $leave_history = New LeaveHistory();
                       $leave_history->employee_id =  $employee->id;
                       $leave_history->nip =  $item['NIP'];
                       $leave_history->type =  $item['cuti_type'];
                       $leave_history->hp =  $item['cuti_hp'];
                       $leave_history->info =  $item['cuti_info'];
                       $leave_history->status =  $item['cuti_status'];
                       $leave_history->final =  $item['cuti_final'];
                       $leave_history->duration =  $item['cuti_duration'];
                       $leave_history->note =  $item['cuti_note'];
                       $leave_history->file =  $item['cuti_file'];
                       $leave_history->date_start =  $item['date_start'];
                       $leave_history->date_finish =  $item['date_finish'];
                       $leave_history->letter_no =  $item['letter_no'];
                       $leave_history->letter_date =  $item['letter_date'];
                       $leave_history->save();
               }
           }

           activity()->log('Sinkronisasi Data Leave History');
           return redirect('/leave_history/'.$employee->id)->with('status', 'Data Berhasil Disinkronisasi');
       } else {
            return redirect('/leave_history/'.$employee->id)->with('status2', 'Data Gagal Disinkronisasi');
       }

    }
}
