<?php

namespace App\Http\Controllers;

use App\Models\Employee;   //nama model
use App\Models\TrainingHistory;   //nama model
use App\Models\Synchronization;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class TrainingHistoryController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index(Employee $employee)
    {
        $title = "Riwayat Diklat";
        $training_history = TrainingHistory::where('nip',$employee->nip)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.training_history.index',compact('title','employee','training_history'));
    }

    ## Tampilkan Data Search
    public function search(Employee $employee, Request $request)
    {
        $title = "Riwayat Diklat";
        $training_history = $request->get('search');
        $training_history = TrainingHistory::where('NIP',$employee->nip)
                            ->where(function ($query) use ($training_history) {
                                $query->where('name', 'LIKE', '%'.$training_history.'%')
                                        ->orWhere('place', 'LIKE', '%'.$training_history.'%')
                                        ->orWhere('organizer', 'LIKE', '%'.$training_history.'%')
                                        ->orWhere('generation', 'LIKE', '%'.$training_history.'%');
                            })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        if($request->input('page')){
            return view('admin.training_history.index',compact('title','training_history'));
        } else {
            return view('admin.training_history.search',compact('title','training_history'));
        }
    }
    
     
    ## Tampilkan Form Create
    public function sync_all()
    {
        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_count_all_riwayat_diklat_by_nip');
        $data = json_decode($response, true);
        $count_all_data = $data['data'];

        $synchronization = Synchronization::where('category','training_history')->first();
        $synchronization->status =  'Process';
        $synchronization->count_all_data =  $count_all_data;
        $synchronization->save();

        $training_history = TrainingHistory::truncate();
        $employee = Employee::select('id','nip')->get();

        foreach($employee as $v){

            // Tarik data dari API
            $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_diklat_by_nip?nip='.$v->nip);

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
                        $training_history = New TrainingHistory();
                        $training_history->employee_id =  $v->id;
                        $training_history->nip =  $item['NIP'];
                        $training_history->name =  $item['PEND_NAMA'];
                        $training_history->place =  $item['PEND_TEMPAT'];
                        $training_history->organizer =  $item['PEND_PENYELENGGARA'];
                        $training_history->generation =  $item['PEND_ANGKATAN'];
                        $training_history->start =  $item['PEND_MULAI'];
                        $training_history->finish =  $item['PEND_SELESAI'];
                        $training_history->hours =  $item['PEND_JMLJAM'];
                        $training_history->diploma_number =  $item['PEND_NOIJAZAH'];
                        $training_history->diploma_date =  $item['PEND_TGLIJAZAH'];
                        $training_history->status =  $item['Status_Kursus'];
                        $training_history->save();
                    }
                }

                    activity()->log('Sinkronisasi Data Class History with NIP = '.$v->nip);
                    
                } else {
                    // return redirect('/training_history/'.$v->id)->with('status2', $responseArray['message']);
            }
        }
        
        $synchronization = Synchronization::where('category','training_history')->first();
        $synchronization->status =  'Done';
        $synchronization->save();
        
        return redirect('/training_employee')->with('status', 'Data Berhasil Disinkronisasi');
    }

    ## Tampilkan Form Create
    public function sync(Employee $employee)
    {
        TrainingHistory::where('nip',$employee->nip)->forceDelete();

        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_diklat_by_nip?nip='.$employee->nip);

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

                       $training_history = New TrainingHistory();
                       $training_history->employee_id =  $employee->id;
                       $training_history->nip =  $item['NIP'];
                       $training_history->name =  $item['PEND_NAMA'];
                       $training_history->place =  $item['PEND_TEMPAT'];
                       $training_history->organizer =  $item['PEND_PENYELENGGARA'];
                       $training_history->generation =  $item['PEND_ANGKATAN'];
                       $training_history->start =  $item['PEND_MULAI'];
                       $training_history->finish =  $item['PEND_SELESAI'];
                       $training_history->hours =  $item['PEND_JMLJAM'];
                       $training_history->diploma_number =  $item['PEND_NOIJAZAH'];
                       $training_history->diploma_date =  $item['PEND_TGLIJAZAH'];
                       $training_history->status =  $item['Status_Kursus'];
                       $training_history->save();
               }
           }

           activity()->log('Sinkronisasi Data Training History');
           return redirect('/training_history/'.$employee->id)->with('status', 'Data Berhasil Disinkronisasi');
       } else {
            return redirect('/training_history/'.$employee->id)->with('status2', $responseArray['message']);
       }

    }
}
