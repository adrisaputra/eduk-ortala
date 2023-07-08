<?php

namespace App\Http\Controllers;

use App\Models\Employee;   //nama model
use App\Models\Classes;   //nama model
use App\Models\Position;   //nama model
use App\Models\Education;   //nama model
use App\Models\Unit;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
         $employee = Employee::select('employees.*')
                    ->leftJoin('classes', 'employees.class_id', '=', 'classes.id')
                    ->leftJoin('class_histories', 'class_histories.classes_id', '=', 'classes.id')
                    ->groupBy('employees.nip')
                    ->orderBy('class_id','DESC')
                    ->orderBy('class_histories.tmt','DESC')
                    ->orderBy('unit_id','ASC')
                    ->orderBy('class_histories.mk_month','DESC')
                    ->orderBy('date_of_birth','ASC')
                    ->paginate(25)->onEachSide(1);
         return view('admin.employee.index',compact('title','employee'));
     }
 
     ## Tampilkan Data Search
     public function search(Request $request)
     {
        $title = "Pegawai";
        $employee = $request->get('search');
        $employee = Employee::select('employees.*')
                    ->leftJoin('classes', 'employees.class_id', '=', 'classes.id')
                    ->leftJoin('class_histories', 'class_histories.classes_id', '=', 'classes.id')
                    ->where(function ($query) use ($employee) {
                        $query->where('nip', 'LIKE', '%'.$employee.'%')
                        ->orWhere('name', 'LIKE', '%'.$employee.'%')
                        ->orWhere('status', 'LIKE', '%'.$employee.'%');
                    })->groupBy('employees.nip')
                    ->orderBy('class_id','DESC')
                    ->orderBy('class_histories.tmt','DESC')
                    ->orderBy('unit_id','ASC')
                    ->orderBy('class_histories.mk_month','DESC')
                    ->orderBy('date_of_birth','ASC')
                    ->paginate(25)->onEachSide(1);
        
        if($request->input('page')){
            return view('admin.employee.index',compact('title','employee'));
        } else {
            return view('admin.employee.search',compact('title','employee'));
        }
     }
     
     ## Tampilkan Form Create
     public function sync()
     {
        // Tarik data dari API
        $response = Http::get('https://simponi.sultraprov.go.id/api/eduk/get_pegawai');

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

                        $employee->save();
                    }
                }
            }

            activity()->log('Sinkronisasi Data Employee');
            return redirect('/employee')->with('status', 'Data Berhasil Disinkronisasi');
        } else {
            // return redirect()->back()->with('error', 'Failed to pull data from API.');
        }

        // echo $response;
     }
 
 
     ## Tampilkan Form Edit
     public function edit(Employee $employee)
     {
         $title = "Pegawai";
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
}
