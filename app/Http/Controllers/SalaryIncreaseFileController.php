<?php

namespace App\Http\Controllers;

use App\Models\SalaryIncreaseFile;   //salary_increase model
use App\Models\SalaryIncrease;   //salary_increase model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SalaryIncreaseFileController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($salary_increase)
    {
        $title = "File Pendukung";
        $salary_increase = Crypt::decrypt($salary_increase);
        $salary_increase = SalaryIncrease::where('id',$salary_increase)->first();
        $salary_increase_file = SalaryIncreaseFile::SalaryIncrease($salary_increase->id)->Sorting()->Pagination();
        return view('admin.salary_increase_file.index',compact('title','salary_increase','salary_increase_file'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $salary_increase)
    {
        $title = "File Pendukung";
        $salary_increase = Crypt::decrypt($salary_increase);
        $salary_increase_file = $request->get('search');
        $salary_increase_file = SalaryIncreaseFile::SalaryIncrease($salary_increase)->Keyword($salary_increase_file)->Sorting()->Pagination();
        
        if($request->input('page')){
            return view('admin.salary_increase_file.index',compact('title','salary_increase_file'));
        } else {
            return view('admin.salary_increase_file.search',compact('title','salary_increase_file'));
        }
    }
    
    ## Tampilkan Form Create
    public function create($salary_increase)
    {
        $title = "File Pendukung";
        $salary_increase = Crypt::decrypt($salary_increase);
        $salary_increase = SalaryIncrease::where('id',$salary_increase)->first();
        $view=view('admin.salary_increase_file.create',compact('title','salary_increase'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request, $salary_increase)
    {
        $this->validate($request, [
            'name' => 'required',
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:10000'
        ]);

        $salary_increase_file = new SalaryIncreaseFile();
        $salary_increase_file->fill($request->all());
        $salary_increase_file->salary_increase_id = Crypt::decrypt($salary_increase);
        
		if($request->file){
			$salary_increase_file->file = time().'.'.$request->file->getClientOriginalExtension();
			$request->file->move(public_path('upload/salary_increase_file'), $salary_increase_file->file);
		}

        $salary_increase_file->save();

        activity()->log('Create Salary Increase File');
        return redirect('/salary_increase_file/'.$salary_increase)->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($salary_increase, $salary_increase_file)
    {
        $title = "File Pendukung";
        
        $salary_increase = Crypt::decrypt($salary_increase);
        $salary_increase = SalaryIncrease::where('id',$salary_increase)->first();

        $salary_increase_file = Crypt::decrypt($salary_increase_file);
        $salary_increase_file = SalaryIncreaseFile::where('id',$salary_increase_file)->first();
        $view=view('admin.salary_increase_file.edit', compact('title','salary_increase','salary_increase_file'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $salary_increase, $salary_increase_file)
    {
        
        $salary_increase_file = Crypt::decrypt($salary_increase_file);
        $salary_increase_file = SalaryIncreaseFile::where('id',$salary_increase_file)->first();

        $this->validate($request, [
            'name' => 'required',
            'file' => 'mimes:jpg,jpeg,png,pdf|max:10000'
        ]);

        if ($salary_increase_file->file && $request->file('file') != "") {
			$file_path = public_path() . '/upload/salary_increase_file/' . $salary_increase_file->file;
			unlink($file_path);
		}
   
        $salary_increase_file->fill($request->all());

		if($request->file('file')){	
			$filename = time().'.'.$request->file->getClientOriginalExtension();
			$request->file->move(public_path('upload/salary_increase_file'), $filename);
			$salary_increase_file->file = $filename;
		}
		
        $salary_increase_file->save();
        
        activity()->log('Update SalaryIncreaseFile with ID = '.$salary_increase_file->id);
        return redirect('/salary_increase_file/'.$salary_increase)->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(SalaryIncreaseFile $salary_increase_file)
    {
        
        if($salary_increase_file->file){
			$pathToYourFile = public_path('upload/salary_increase_file/'.$salary_increase_file->file);
			if(file_exists($pathToYourFile))
			{
				unlink($pathToYourFile);
			}
		}

    	$salary_increase_file->delete();

        activity()->log('Hapus Data Constitution dengan ID = '.$salary_increase_file->id);
        return redirect('/salary_increase_file/'.Crypt::encrypt($salary_increase_file->salary_increase_id))->with('status', 'Data Berhasil Diubah');
    }

}
