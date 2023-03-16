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
         $employee = Employee::orderBy('id','DESC')->paginate(25)->onEachSide(1);
         return view('admin.employee.index',compact('title','employee'));
     }
 
     ## Tampilkan Data Search
     public function search(Request $request)
     {
         $title = "Pegawai";
         $employee = $request->get('search');
         $employee = Employee::where('name', 'LIKE', '%'.$employee.'%')
                 ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
         
         return view('admin.employee.index',compact('title','employee'));
     }
     
     ## Tampilkan Form Create
     public function create()
     {
         $title = "Pegawai";
         $class = Classes::get();
         $position = Position::get();
         $education = Education::get();
         $unit = Unit::get();
         $view=view('admin.employee.create',compact('title','class','position','education','unit'));
         $view=$view->render();
         return $view;
     }
 
     ## Simpan Data
     public function store(Request $request)
     {
         $this->validate($request, [
             'nip' => 'required|numeric|digits:18',
             'name' => 'required|string'
         ]);
 
         $employee = New Employee();
         $employee->fill($request->all());
         
         $employee->save();
         
         activity()->log('Tambah Data Pegawai');
         return redirect('/employee')->with('status','Data Tersimpan');
     }
 
     ## Tampilkan Form Edit
     public function edit($employee)
     {
         $title = "Pegawai";
         $employee = Crypt::decrypt($employee);
         $employee = Employee::where('id',$employee)->first();
         $class = Classes::get();
         $position = Position::get();
         $education = Education::get();
         $unit = Unit::get();
         $view=view('admin.employee.edit', compact('title','employee','class','position','education','unit'));
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
         
         $d = substr($request->date_of_birth,3,2);
         $m = substr($request->date_of_birth,0,2);
         $y = substr($request->date_of_birth,6,4);
         $employee->date_of_birth = $y.'-'.$m.'-'.$d;

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
