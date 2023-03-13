<?php

namespace App\Http\Controllers;

use App\Models\Menu;   //nama model
use App\Models\SubMenu;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class SubMenuController extends Controller
{
     ## Cek Login
     public function __construct()
     {
         $this->middleware('auth');
     }
     
     ## Tampikan Data
     public function index($id)
     {
        $title = "Sub Menu";
        $id = Crypt::decrypt($id);
        $menu = Menu::where('id',$id)->first();
        $sub_menu = SubMenu::where('menu_id',$id)->orderBy('position','ASC')->paginate(25)->onEachSide(1);
        return view('admin.sub_menu.index',compact('title','menu','sub_menu'));
     }
 
     ## Tampilkan Data Search
     public function search(Request $request, $id)
     {
        $title = "Sub Menu";
        $id = Crypt::decrypt($id);
        $menu = Menu::where('id',$id)->first();
        $sub_menu = $request->get('search');
        $sub_menu = SubMenu::where('menu_id',$id)
                ->where('sub_menu_name', 'LIKE', '%'.$sub_menu.'%')
                ->orderBy('position','ASC')->paginate(25)->onEachSide(1);
        
        return view('admin.sub_menu.index',compact('title','menu','sub_menu'));
     }
     
     ## Tampilkan Form Create
     public function create($id)
     {
        $title = "Sub Menu";
        $id = Crypt::decrypt($id);
        $menu = Menu::where('id',$id)->first();
        $view=view('admin.sub_menu.create',compact('title','menu'));
        $view=$view->render();
        return $view;
     }
 
     ## Simpan Data
     public function store($id, Request $request)
     {
         
        $id = Crypt::decrypt($id);

        $this->validate($request, [
            'sub_menu_name' => 'required',
            'link' => 'required',
            'position' => 'numeric|required',
            'status' => 'required',
        ]);

        $input['menu_id'] = $id;
        $input['sub_menu_name'] = $request->sub_menu_name;
        $input['link'] = $request->link;
        $input['attribute'] = $request->attribute;
        $input['position'] = $request->position;
        $input['desc'] = $request->desc;
        $input['status'] = $request->status;
        $input['user_id'] = Auth::user()->id;
        
        SubMenu::create($input);
        
        activity()->log('Tambah Data Sub Menu');
        return redirect('/sub_menu/'.Crypt::encrypt($id))->with('status','Data Tersimpan');
     }
 
     ## Tampilkan Form Edit
     public function edit($id, $sub_menu)
     {
         $title = "Sub Menu";

         $id = Crypt::decrypt($id);
         $sub_menu = Crypt::decrypt($sub_menu);

         $menu = Menu::where('id',$id)->first();
         $sub_menu = SubMenu::findorFail($sub_menu);

         $view=view('admin.sub_menu.edit', compact('title','menu','sub_menu'));
         $view=$view->render();
         return $view;
     }
 
     ## Edit Data
     public function update(Request $request, $id, $sub_menu)
     {
      
        $sub_menu = Crypt::decrypt($sub_menu);
        $sub_menu = SubMenu::where('id',$sub_menu)->first();

        $this->validate($request, [
            'sub_menu_name' => 'required',
            'link' => 'required',
            'position' => 'numeric|required',
            'status' => 'required',
        ]);
 
        $sub_menu->fill($request->all());
        
        $sub_menu->user_id = Auth::user()->id;
        $sub_menu->save();
        
        activity()->log('Ubah Data Sub Menu dengan ID = '.$sub_menu->id);
        return redirect('/sub_menu/'.$id)->with('status', 'Data Berhasil Diubah');
     }
 
     ## Hapus Data
     public function delete($id, $sub_menu)
     {
      
        $sub_menu = Crypt::decrypt($sub_menu);
        $sub_menu = SubMenu::where('id',$sub_menu)->first();

        $sub_menu->delete();

        activity()->log('Hapus Data Sub Menu dengan ID = '.$sub_menu->id);
        return redirect('/sub_menu/'.$id)->with('status', 'Data Berhasil Dihapus');
     }
}
