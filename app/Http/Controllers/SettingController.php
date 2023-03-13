<?php

namespace App\Http\Controllers;

use App\Models\Setting;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = 'Pengaturan';
        $setting = Setting::find(1);
        $view=view('admin.setting.edit', compact('title','setting'));
        $view=$view->render();
        return $view;
    }

    
    ## Edit Data
    public function update(Request $request, Setting $setting)
    {
        $this->validate($request, [
            'small_icon' => 'mimes:jpg,jpeg,png|max:500',
            'large_icon' => 'mimes:jpg,jpeg,png|max:500',
            'background_login' => 'mimes:jpg,jpeg,png|max:500',
            'background_sidebar' => 'mimes:jpg,jpeg,png|max:500',
        ]);
        
        if($request->file('small_icon') && $setting->small_icon){
            $pathToYourFile = public_path('upload/setting/'.$setting->small_icon);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        if($request->file('large_icon') && $setting->large_icon){
            $pathToYourFile = public_path('upload/setting/'.$setting->large_icon);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        if($request->file('background_login') && $setting->background_login){
            $pathToYourFile = public_path('upload/setting/'.$setting->background_login);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

		$setting->fill($request->all());
		
		if($request->file('small_icon') == ""){}
    	else
    	{	
            $filename = time().'1.'.$request->small_icon->getClientOriginalExtension();
            $request->small_icon->move(public_path('upload/setting'), $filename);
            $setting->small_icon = $filename;
		}
		
		if($request->file('large_icon') == ""){}
    	else
    	{	
            $filename = time().'2.'.$request->large_icon->getClientOriginalExtension();
            $request->large_icon->move(public_path('upload/setting'), $filename);
            $setting->large_icon = $filename;
		}
		
		if($request->file('background_login') == ""){}
    	else
    	{	
            $filename = time().'3.'.$request->background_login->getClientOriginalExtension();
            $request->background_login->move(public_path('upload/setting'), $filename);
            $setting->background_login = $filename;
		}
		
		$setting->user_id = Auth::user()->id;
    	$setting->save();
		
        activity()->log('Ubah Data Pengaturan');
		return redirect('/setting')->with('status', 'Data Berhasil Diubah');
    }
}
