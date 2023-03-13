<?php

namespace App\Http\Controllers;

use App\Models\MenuAccess;   //nama model
use App\Models\Group;   //nama model
use App\Models\Menu;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class MenuAccessController extends Controller
{
     ## Cek Login
     public function __construct()
     {
         $this->middleware('auth');
     }
     
     ## Tampikan Data
     public function index($group_id)
     {
        $title = "Menu Akses";
         
        $group_id = Crypt::decrypt($group_id);
        $group = Group::where('id',$group_id)->first();

        $menu_access = MenuAccess::select('menu_accesses.*','menu_name')
                    ->leftJoin('menus', 'menu_accesses.menu_id', '=', 'menus.id')
                    ->where('group_id',$group_id)
                    ->orderBy('position','ASC')
                    ->paginate(25)->onEachSide(1);
        return view('admin.menu_access.index',compact('title','group','menu_access'));
     }
 
     ## Tampilkan Data Search
     public function search(Request $request, $group_id)
     {
         $title = "Menu Akses";

         $group_id = Crypt::decrypt($group_id);
         $group = Group::where('id',$group_id)->first();

         $menu_access = $request->get('search');
         $menu_access = MenuAccess::select('menu_accesses.*','menu_name')
                        ->leftJoin('menus', 'menu_accesses.menu_id', '=', 'menus.id')
                        ->where('group_id',$group_id)
                        ->where('menu_name', 'LIKE', '%'.$menu_access.'%')
                        ->orderBy('position','ASC')
                        ->paginate(25)->onEachSide(1);
         
         return view('admin.menu_access.index',compact('title','group','menu_access'));
     }
     
     ## Tampilkan Form Create
     public function create($group_id)
     {
         $title = "Menu Akses";
         
         $group_id = Crypt::decrypt($group_id);
         $group = Group::where('id',$group_id)->first();

         $menu = Menu::get();
         $view=view('admin.menu_access.create',compact('title','group','menu'));
         $view=$view->render();
         return $view;
     }
 
     ## Simpan Data
     public function store($group_id, Request $request)
     {
         
        $group_id = Crypt::decrypt($group_id);

         $this->validate($request, [
             'menu_id' => 'required',
             'create' => 'required',
             'read' => 'required',
             'update' => 'required',
             'delete' => 'required',
             'print' => 'required',
         ]);
 
         $input['group_id'] = $group_id;
         $input['menu_id'] = $request->menu_id;
         $input['create'] = $request->create;
         $input['read'] = $request->read;
         $input['update'] = $request->update;
         $input['delete'] = $request->delete;
         $input['print'] = $request->print;
         $input['user_id'] = Auth::user()->id;
         
         MenuAccess::create($input);
         
         activity()->log('Tambah Data Menu Akses');
         return redirect('/menu_akses/'.Crypt::encrypt($group_id))->with('status','Data Tersimpan');
     }
 
     ## Tampilkan Form Edit
     public function edit($group_id, $menu_access)
     {
        $title = "Menu Akses";
        
        $group_id = Crypt::decrypt($group_id);
        $group = Group::where('id',$group_id)->first();
        $menu_access = Crypt::decrypt($menu_access);
        $menu_access = MenuAccess::where('id',$menu_access)->first();

        $menu = Menu::get();
        $view=view('admin.menu_access.edit', compact('title','group','menu','menu_access'));
        $view=$view->render();
        return $view;
     }
 
     ## Edit Data
     public function update(Request $request, $group_id, $menu_access)
     {
         
        $menu_access = Crypt::decrypt($menu_access);
        $menu_access = MenuAccess::where('id',$menu_access)->first();

        $this->validate($request, [
            'menu_id' => 'required',
            'create' => 'required',
            'read' => 'required',
            'update' => 'required',
            'delete' => 'required',
            'print' => 'required',
        ]);
 
        $menu_access->fill($request->all());
        
        $menu_access->user_id = Auth::user()->id;
        $menu_access->save();
        
        activity()->log('Ubah Data Menu Akses dengan ID = '.$menu_access->id);
        return redirect('/menu_akses/'.$group_id)->with('status', 'Data Berhasil Diubah');
     }
 
     ## Hapus Data
     public function delete($group_id, $menu_access)
     {
        $menu_access = Crypt::decrypt($menu_access);
        $menu_access = MenuAccess::where('id',$menu_access)->first();
        $menu_access->delete();
 
        activity()->log('Hapus Data Menu Akses dengan ID = '.$menu_access->id);
        return redirect('/menu_akses/'.$group_id)->with('status', 'Data Berhasil Dihapus');
     }
}
