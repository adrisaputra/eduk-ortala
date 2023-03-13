<?php

namespace App\Http\Controllers;

use App\Models\Menu;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class MenuController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = " Menu";
        $menu = Menu::orderBy('position','ASC')->paginate(25)->onEachSide(1);
        return view('admin.menu.index',compact('title','menu'));
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = " Menu";
        $menu = $request->get('search');
        $menu = Menu::
                where(function ($query) use ($menu) {
                    $query->where('menu_name', 'LIKE', '%'.$menu.'%')
                        ->orWhere('link', 'LIKE', '%'.$menu.'%')
                        ->orWhere('attribute', 'LIKE', '%'.$menu.'%');
                })
                ->orderBy('position','ASC')->paginate(25)->onEachSide(1);
        
        return view('admin.menu.index',compact('title','menu'));
    }
	
    ## Tampilkan Form Create
    public function create()
    {
        $title = " Menu";
		$view=view('admin.menu.create',compact('title'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'menu_name' => 'required',
            'link' => 'required',
            'position' => 'numeric|unique:menus|required',
            'status' => 'required',
        ]);

		$input['menu_name'] = $request->menu_name;
		$input['link'] = $request->link;
		$input['attribute'] = $request->attribute;
		$input['position'] = $request->position;
		$input['desc'] = $request->desc;
		$input['category'] = 2;
		$input['status'] = $request->status;
		$input['user_id'] = Auth::user()->id;
		
        Menu::create($input);
        
        activity()->log('Tambah Data Menu');
		return redirect('/menu')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($menu)
    {
        $title = " Menu";
        $menu = Crypt::decrypt($menu);
        $menu = Menu::where('id',$menu)->first();
        $view=view('admin.menu.edit', compact('title','menu'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $menu)
    {
        $menu = Crypt::decrypt($menu);
        $menu = Menu::where('id',$menu)->first();

        if($menu->position==$request->position){
            $this->validate($request, [
                'menu_name' => 'required',
                'link' => 'required',
                'position' => 'numeric|required',
                'status' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'menu_name' => 'required',
                'link' => 'required',
                'position' => 'numeric|unique:menus|required',
                'status' => 'required',
            ]);
        }

        $menu->fill($request->all());
        
		$menu->user_id = Auth::user()->id;
    	$menu->save();
		
        activity()->log('Ubah Data Menu dengan ID = '.$menu->id);
		return redirect('/menu')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($menu)
    {
        $menu = Crypt::decrypt($menu);
        $menu = Menu::where('id',$menu)->first();
    	$menu->delete();

        activity()->log('Hapus Data Menu dengan ID = '.$menu->id);
        return redirect('/menu')->with('status', 'Data Berhasil Dihapus');
    }
}
