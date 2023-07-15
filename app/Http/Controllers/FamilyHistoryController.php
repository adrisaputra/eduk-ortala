<?php

namespace App\Http\Controllers;

use App\Models\Employee;   //nama model
use App\Models\ParentHistory;   //nama model
use App\Models\ChildHistory;   //nama model
use App\Models\Synchronization;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class FamilyHistoryController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index($employee)
    {
        $title = "Riwayat Keluarga";
        $employee = Crypt::decrypt($employee);
        $employee = Employee::where('id',$employee)->first();
        $parent_history = ParentHistory::where('nip',$employee->nip)->first();
        $child_history = ChildHistory::where('nip',$employee->nip)->orderBy('id','DESC')->get();
        return view('admin.family_history.index',compact('title','employee','parent_history','child_history'));
    }
     
    ## Tampilkan Form Create
    public function sync_all()
    {
        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_count_all_riwayat_orang_tua_by_nip');
        $data = json_decode($response, true);
        $count_all_data1 = $data['data'];

        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_count_all_riwayat_anak_by_nip');
        $data = json_decode($response, true);
        $count_all_data2 = $data['data'];

        $synchronization = Synchronization::where('category','family_history')->first();
        $synchronization->status =  'Process';
        $synchronization->count_all_data =  $count_all_data1 + $count_all_data2;
        $synchronization->save();

        $parent_history = ParentHistory::truncate();
        $employee = Employee::select('id','nip')->get();

        foreach($employee as $v){

            // Tarik data dari API
            $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_orang_tua_by_nip?nip='.$v->nip);

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
                        $parent_history = New ParentHistory();
                        $parent_history->employee_id =  $v->id;
                        $parent_history->nip =  $item['NIP'];
                        $parent_history->father_name =  $item['Ayah_Nama'];
                        $parent_history->father_birthplace =  $item['Ayah_tmpLahir'];
                        $parent_history->father_birthdate =  $item['Ayah_TglLahir'];
                        $parent_history->father_work =  $item['Ayah_Pekerjaan'];
                        $parent_history->father_address =  $item['Ayah_Alamat'];
                        $parent_history->father_rt =  $item['Ayah_RT'];
                        $parent_history->father_rw =  $item['Ayah_RW'];
                        $parent_history->father_phone =  $item['Ayah_Phone'];
                        $parent_history->father_codepos =  $item['Ayah_KodePos'];
                        $parent_history->father_village =  $item['Ayah_Desa'];
                        $parent_history->father_district =  $item['Ayah_Kec'];
                        $parent_history->father_regency =  $item['Ayah_Kab'];
                        $parent_history->father_province =  $item['Ayah_Prov'];
                        $parent_history->mother_name =  $item['Ibu_Nama'];
                        $parent_history->mother_birthplace =  $item['Ibu_tmpLahir'];
                        $parent_history->mother_birthdate =  $item['Ibu_TglLahir'];
                        $parent_history->mother_work =  $item['Ibu_Pekerjaan'];
                        $parent_history->mother_address =  $item['Ibu_Alamat'];
                        $parent_history->mother_rt =  $item['Ibu_RT'];
                        $parent_history->mother_rw =  $item['Ibu_RW'];
                        $parent_history->mother_phone =  $item['Ibu_Phone'];
                        $parent_history->mother_codepos =  $item['Ibu_KodePos'];
                        $parent_history->mother_village =  $item['Ibu_Desa'];
                        $parent_history->mother_district =  $item['Ibu_Kec'];
                        $parent_history->mother_regency =  $item['Ibu_Kab'];
                        $parent_history->mother_province =  $item['Ibu_Prov'];
                        $parent_history->save();
                    }
                }

                    activity()->log('Sinkronisasi Data Class History with NIP = '.$v->nip);
                    
                } else {
                    // return redirect('/family_history/'.$v->id)->with('status2', $responseArray['message']);
            }
        }
        
        $this->sync_all_child();

        $synchronization = Synchronization::where('category','family_history')->first();
        $synchronization->status =  'Done';
        $synchronization->save();
        
        return redirect('/family_employee')->with('status', 'Data Berhasil Disinkronisasi');
    }

    ## Tampilkan Form Create
    public function sync_all_child()
    {
        $child_history = ChildHistory::truncate();
        $employee = Employee::select('id','nip')->get();

        foreach($employee as $v){

            // Tarik data dari API
            $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_anak_by_nip?nip='.$v->nip);

            // Menguraikan JSON menjadi array asosiatif
            $responseArray = json_decode($response, true);

            // Memeriksa apakah status bernilai true
            if ($responseArray['status']) {
                $data = $responseArray['data'];
                $perPage = 25;
                $pages = array_chunk($data, $perPage);

                foreach ($pages as $page) {
                    foreach ($page as $item) {
                        $child_history = New ChildHistory();
                        $child_history->employee_id =  $v->id;
                        $child_history->nip =  $item['NIP'];
                        $child_history->child_name =  $item['ANAK_NAMA'];
                        $child_history->child_birthplace =  $item['ANAK_TMPLAHIR'];
                        $child_history->child_birthdate =  $item['ANAK_TGLLAHIR'];
                        $child_history->child_gender =  $item['ANAK_KELAMIN'];
                        $child_history->child_status =  $item['ANAK_STATUS'];
                        $child_history->child_allowance =  $item['ANAK_TUNJANGAN'];
                        $child_history->child_education =  $item['ANAK_PENDIDIKAN'];
                        $child_history->child_work =  $item['ANAK_PEKERJAAN'];
                        $child_history->save();
                    }
                }

                    activity()->log('Sinkronisasi Data Child History with NIP = '.$v->nip);
                    
                } else {
                    // return redirect('/child_history/'.$v->id)->with('status2', $responseArray['message']);
            }
        }
    }

    ## Tampilkan Form Create
    public function sync($employee)
    {
        $employee = Crypt::decrypt($employee);
        $employee = Employee::where('id',$employee)->first();

        ParentHistory::where('nip',$employee->nip)->forceDelete();

        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_orang_tua_by_nip?nip='.$employee->nip);

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

                       $parent_history = New ParentHistory();
                       $parent_history->employee_id =  $employee->id;
                       $parent_history->nip =  $item['NIP'];
                       $parent_history->father_name =  $item['Ayah_Nama'];
                       $parent_history->father_birthplace =  $item['Ayah_tmpLahir'];
                       $parent_history->father_birthdate =  $item['Ayah_TglLahir'];
                       $parent_history->father_work =  $item['Ayah_Pekerjaan'];
                       $parent_history->father_address =  $item['Ayah_Alamat'];
                       $parent_history->father_rt =  $item['Ayah_RT'];
                       $parent_history->father_rw =  $item['Ayah_RW'];
                       $parent_history->father_phone =  $item['Ayah_Phone'];
                       $parent_history->father_codepos =  $item['Ayah_KodePos'];
                       $parent_history->father_village =  $item['Ayah_Desa'];
                       $parent_history->father_district =  $item['Ayah_Kec'];
                       $parent_history->father_regency =  $item['Ayah_Kab'];
                       $parent_history->father_province =  $item['Ayah_Prov'];
                       $parent_history->mother_name =  $item['Ibu_Nama'];
                       $parent_history->mother_birthplace =  $item['Ibu_tmpLahir'];
                       $parent_history->mother_birthdate =  $item['Ibu_TglLahir'];
                       $parent_history->mother_work =  $item['Ibu_Pekerjaan'];
                       $parent_history->mother_address =  $item['Ibu_Alamat'];
                       $parent_history->mother_rt =  $item['Ibu_RT'];
                       $parent_history->mother_rw =  $item['Ibu_RW'];
                       $parent_history->mother_phone =  $item['Ibu_Phone'];
                       $parent_history->mother_codepos =  $item['Ibu_KodePos'];
                       $parent_history->mother_village =  $item['Ibu_Desa'];
                       $parent_history->mother_district =  $item['Ibu_Kec'];
                       $parent_history->save();
               }
           }

           activity()->log('Sinkronisasi Data Parent History');

           $this->sync_child($employee);
           return redirect('/family_history/'.Crypt::encrypt($employee->id))->with('status', 'Data Berhasil Disinkronisasi');
       } else {
            return redirect('/family_history/'.Crypt::encrypt($employee->id))->with('status2', $responseArray['message']);
       }

    }

    ## Tampilkan Form Create
    public function sync_child(Employee $employee)
    {
        ChildHistory::where('nip',$employee->nip)->forceDelete();

        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_riwayat_anak_by_nip?nip='.$employee->nip);

        // Menguraikan JSON menjadi array asosiatif
        $responseArray = json_decode($response, true);

        // Memeriksa apakah status bernilai true
        if ($responseArray['status']) {
            $data = $responseArray['data'];
            $perPage = 25;
            $pages = array_chunk($data, $perPage);

            foreach ($pages as $page) {
                foreach ($page as $item) {
                    $child_history = New ChildHistory();
                    $child_history->employee_id =  $employee->id;
                    $child_history->nip =  $item['NIP'];
                    $child_history->child_name =  $item['ANAK_NAMA'];
                    $child_history->child_birthplace =  $item['ANAK_TMPLAHIR'];
                    $child_history->child_birthdate =  $item['ANAK_TGLLAHIR'];
                    $child_history->child_gender =  $item['ANAK_KELAMIN'];
                    $child_history->child_status =  $item['ANAK_STATUS'];
                    $child_history->child_allowance =  $item['ANAK_TUNJANGAN'];
                    $child_history->child_education =  $item['ANAK_PENDIDIKAN'];
                    $child_history->child_work =  $item['ANAK_PEKERJAAN'];
                    $child_history->save();
                }
            }

                activity()->log('Sinkronisasi Data Child History with NIP = '.$employee->nip);
                
            } else {
                // return redirect('/child_history/'.$v->id)->with('status2', $responseArray['message']);
        }
    }
}
