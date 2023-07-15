<?php

namespace App\Http\Controllers;

use App\Models\Employee;   //nama model
use App\Models\ParentUnit;   //nama model
use App\Models\Classes;   //nama model
use App\Models\Synchronization;   //nama model
use App\Models\Education;   //nama model
use App\Models\Unit;   //nama model
use App\Models\EducationHistory;
use App\Models\ClassHistory;
use App\Models\PositionHistory;
use App\Models\PunishmentHistory;
use App\Models\AbsenceHistory;
use App\Models\LeaveHistory;
use App\Models\ParentHistory;
use App\Models\ChildHistory;
use App\Models\TrainingHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class EmployeeController extends Controller
{
      ## Cek Login
      public function __construct()
      {
            $this->middleware('auth');
      }
      
      ## Tampikan Data
      public function index()
      {
         $title = "Pegawai";
         $parent_unit = ParentUnit::get();

         if(Auth::user()->group_id==1){
               $employee = Employee::select('employees.*')
               ->leftJoin('classes', 'employees.class_id', '=', 'classes.id')
               ->leftJoin('class_histories', 'class_histories.classes_id', '=', 'classes.id')
               ->Grouping()->Sorting()->Pagination();
         } else {
            $employee = Employee::select('employees.*')
               ->leftJoin('classes', 'employees.class_id', '=', 'classes.id')
               ->leftJoin('class_histories', 'class_histories.classes_id', '=', 'classes.id')
               ->where('parent_unit_id', Auth::user()->parent_unit_id)
               ->Grouping()->Sorting()->Pagination();
         }

         switch(request()->segment(1)){
            case "employee"            : $synchronization = Synchronization::where('category','employee')->first();break;
            case "class_employee"      : $synchronization = Synchronization::where('category','class_history')->first();break;
            case "education_employee"  : $synchronization = Synchronization::where('category','education_history')->first();break; 
            case "position_employee"   : $synchronization = Synchronization::where('category','position_history')->first();break; 
            case "punishment_employee" : $synchronization = Synchronization::where('category','punishment_history')->first();break; 
            case "absence_employee"    : $synchronization = Synchronization::where('category','absence_history')->first();break; 
            case "leave_employee"      : $synchronization = Synchronization::where('category','leave_history')->first();break; 
            case "family_employee"     : $synchronization = Synchronization::where('category','family_history')->first();break; 
            case "training_employee"   : $synchronization = Synchronization::where('category','training_history')->first();break; 
         }

         return view('admin.employee.index',compact('title','employee','parent_unit','synchronization'));
      }
 
      ## Tampilkan Data Search
      public function search(Request $request)
      {
         $title = "Pegawai";
         $parent_unit = ParentUnit::get();
         $employee = $request->get('search');
         $parent_unit_id = $request->get('parent_unit_id');

         if(Auth::user()->group_id==1){
            $employee = Employee::select('employees.*')
                     ->leftJoin('classes', 'employees.class_id', '=', 'classes.id')
                     ->leftJoin('class_histories', 'class_histories.classes_id', '=', 'classes.id')
                     ->Keyword($employee,$parent_unit_id)
                     ->Grouping()->Sorting()->Pagination();
         } else {
            $employee = Employee::select('employees.*')
                     ->leftJoin('classes', 'employees.class_id', '=', 'classes.id')
                     ->leftJoin('class_histories', 'class_histories.classes_id', '=', 'classes.id')
                     ->Keyword($employee,$parent_unit_id)
                     ->where('parent_unit_id', Auth::user()->parent_unit_id)
                     ->Grouping()->Sorting()->Pagination();
         }

         switch(request()->segment(1)){
            case "employee"            : $synchronization = Synchronization::where('category','employee')->first();break;
            case "class_employee"      : $synchronization = Synchronization::where('category','class_history')->first();break;
            case "education_employee"  : $synchronization = Synchronization::where('category','education_history')->first();break; 
            case "position_employee"   : $synchronization = Synchronization::where('category','position_history')->first();break; 
            case "punishment_employee" : $synchronization = Synchronization::where('category','punishment_history')->first();break; 
            case "absence_employee"    : $synchronization = Synchronization::where('category','absence_history')->first();break; 
            case "leave_employee"      : $synchronization = Synchronization::where('category','leave_history')->first();break; 
            case "family_employee"     : $synchronization = Synchronization::where('category','family_history')->first();break; 
            case "training_employee"   : $synchronization = Synchronization::where('category','training_history')->first();break; 
         }

         if($request->input('page')){
               return view('admin.employee.index',compact('title','parent_unit','employee','synchronization'));
         } else {
               return view('admin.employee.search',compact('title','parent_unit','employee','synchronization'));
         }
     }
     
     ## Tampilkan Form Create
     public function sync()
     {
        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_count_pegawai');
        $data = json_decode($response, true);
        $count_all_data = $data['data'];

        $synchronization = Synchronization::where('category','employee')->first();
        $synchronization->status =  'Process';
        $synchronization->count_all_data =  $count_all_data;
        $synchronization->save();

        // Tarik data dari API
        $response2 = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_pegawai');

        // Menguraikan JSON menjadi array asosiatif
        $responseArray = json_decode($response2, true);

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

                    $employee = Employee::where('nip',$item['NIP'])->first();
                    if($employee){
                        $employee->nip =  $item['NIP'];
                        $employee->name =  $item['Nama'];
                        $employee->front_title =  $item['GelarDepan'];
                        $employee->back_title =  $item['GelarBlkng'];
                        $employee->birthplace =  $item['TmpLahir'];
                        $employee->date_of_birth =  $item['TglLahir'];
                        $employee->gender =  $item['Kelamin'];
                        $employee->status =  $item['StatusPeg'];
                        $employee->employee_type =  $item['KdJenis'];
                        $employee->religion =  $item['Agama'];
                        $employee->address =  $item['AlamatTinggal'];
                        $employee->no_karpeg =  $item['NoKarpeg'];
                        $employee->no_askes =  $item['NoAskes'];
                        $employee->no_taspen =  $item['NoTaspen'];
                        $employee->no_karis_karsu =  $item['NoKaris'];
                        $employee->no_npwp =  $item['NPWP'];
                        $employee->mk_month =  $item['MK_Bulan'];
                        $employee->mk_year =  $item['MK_Tahun'];
                        
                        $class = Classes::where('code',$item['KdGol'])->first();
                        $employee->class_id =  $class ? $class->id : null;

                        $education = Education::where('code',$item['KodePend'])->first();
                        $employee->education_id =  $education ? $education->id : null;

                        $employee->position =  $item['JABATAN'];
                        
                        $unit = Unit::where('code',$item['KdUnor'])->first();
                        $employee->unit_id =  $unit ? $unit->id : null;

                        if($unit){
                           $unit2 = Unit::where('id', $unit->id)->first();
                           $employee->parent_unit_id = $unit2->parent_unit_id;
                        }

                        $employee->save();
                    } else {
                        $employee = New Employee();
                        $employee->nip =  $item['NIP'];
                        $employee->name =  $item['Nama'];
                        $employee->front_title =  $item['GelarDepan'];
                        $employee->back_title =  $item['GelarBlkng'];
                        $employee->birthplace =  $item['TmpLahir'];
                        $employee->date_of_birth =  $item['TglLahir'];
                        $employee->gender =  $item['Kelamin'];
                        $employee->status =  $item['StatusPeg'];
                        $employee->employee_type =  $item['KdJenis'];
                        $employee->religion =  $item['Agama'];
                        $employee->address =  $item['AlamatTinggal'];
                        $employee->no_karpeg =  $item['NoKarpeg'];
                        $employee->no_askes =  $item['NoAskes'];
                        $employee->no_taspen =  $item['NoTaspen'];
                        $employee->no_karis_karsu =  $item['NoKaris'];
                        $employee->no_npwp =  $item['NPWP'];
                        $employee->mk_month =  $item['MK_Bulan'];
                        $employee->mk_year =  $item['MK_Tahun'];
                        
                        $class = Classes::where('code',$item['KdGol'])->first();
                        $employee->class_id =  $class ? $class->id : null;
                        
                        $education = Education::where('code',$item['KodePend'])->first();
                        $employee->education_id =  $education ? $education->id : null;

                        $employee->position =  $item['JABATAN'];
                        
                        $unit = Unit::where('code',$item['KdUnor'])->first();
                        $employee->unit_id =  $unit ? $unit->id : null;

                        if($unit){
                           $unit2 = Unit::where('code',$item['KdUnor'])->first();
                           $employee->parent_unit_id = $unit2->parent_unit_id;
                        }

                        $employee->save();
                    }
                }
            }

            activity()->log('Sinkronisasi Data Employee');
            
            $synchronization = Synchronization::where('category','employee')->first();
            $synchronization->status =  'Done';
            $synchronization->save();

            return redirect('/employee')->with('status', 'Data Berhasil Disinkronisasi');
        } else {
            // return redirect()->back()->with('error', 'Failed to pull data from API.');
        }

     }
 
 
    ## Tampilkan Form Edit
    public function edit($employee)
    {
        $title = "Pegawai";
        $employee = Crypt::decrypt($employee);
        $employee = Employee::where('id',$employee)->first();
        $class = Classes::limit(10)->get();
        $education = Education::limit(10)->get();
        $unit = Unit::get();
        $view=view('admin.employee.edit', compact('title','employee','class','education','unit'));
        $view=$view->render();
        return $view;
    }
 
     ## Edit Data
     public function update(Request $request, $employee)
     {
         
        $employee = Crypt::decrypt($employee);
        $employee = Employee::where('id',$employee)->first();

        $this->validate($request, [
            'nip' => 'required|numeric|digits:18',
            'name' => 'required|string'
        ]);

        $employee->fill($request->all());
        $employee->save();
        
        activity()->log('Ubah Data Pegawai dengan ID = '.$employee->id);
        return redirect('/employee')->with('status', 'Data Berhasil Diubah');

     }
 
     ## Hapus Data
     public function delete($employee)
     {
         $employee = Crypt::decrypt($employee);
         $employee = Employee::where('id',$employee)->first();
         $employee->delete();
 
         activity()->log('Hapus Data Pegawai dengan ID = '.$employee->id);
         return redirect('/employee')->with('status', 'Data Berhasil Dihapus');
     }

     ## Tampikan Data
    public function refresh()
    {
         switch(request()->segment(1)){
            case "employee"            :$nilai = Employee::count(); 
                                       $synchronization = Synchronization::where('category','employee')->first();break;
            case "class_employee"      :$nilai = ClassHistory::count(); 
                                       $synchronization = Synchronization::where('category','class_history')->first();break;
            case "education_employee"  :$nilai = EducationHistory::count(); 
                                       $synchronization = Synchronization::where('category','education_history')->first();break;
            case "position_employee"   :$nilai = PositionHistory::count(); 
                                       $synchronization = Synchronization::where('category','position_history')->first();break;
            case "punishment_employee" :$nilai = PunishmentHistory::count(); 
                                       $synchronization = Synchronization::where('category','punishment_history')->first();break; 
            case "absence_employee"    :$nilai = AbsenceHistory::count(); 
                                       $synchronization = Synchronization::where('category','absence_history')->first();break; 
            case "leave_employee"      :$nilai = LeaveHistory::count(); 
                                       $synchronization = Synchronization::where('category','leave_history')->first();break;  
            case "family_employee"     :$nilai1 = ParentHistory::count(); 
                                       $nilai2 = ChildHistory::count(); 
                                       $nilai = $nilai1 + $nilai2; 
                                       $synchronization = Synchronization::where('category','family_history')->first();break; 
            case "training_employee"   :$nilai = TrainingHistory::count(); 
                                       $synchronization = Synchronization::where('category','training_history')->first();break; 
         }

         $persentase = ($nilai / $synchronization->count_all_data) * 100; 
         return view('admin.employee.refresh',compact('synchronization','persentase'));
    }

    function get_class(Employee $employee)
    {
         $res = array();
         $class_history = ClassHistory::where('employee_id',$employee->id)->orderBy('classes_id','DESC')->limit(1)->first();
         $next_class = Classes::where('id','>',$class_history->classes_id)->orderBy('id','ASC')->limit(1)->first();
         
         $res['last_promotion'] = $class_history->class;
         $res['new_promotion'] = $next_class->class;

         return $res;
    }
}
