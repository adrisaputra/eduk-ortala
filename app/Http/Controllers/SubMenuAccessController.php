<?php

namespace App\Http\Controllers;

use App\Models\SubMenuAccess;   //nama model
use App\Models\Group;   //nama model
use App\Models\Menu;   //nama model
use App\Models\SubMenu;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class SubMenuAccessController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($group_id,$menu_id)
    {
        $title = "Sub Menu Akses";

        $group_id = Crypt::decrypt($group_id);
        $menu_id = Crypt::decrypt($menu_id);

        $group = Group::where('id',$group_id)->first();
        $menu = Menu::where('id',$menu_id)->first();

        $sub_menu_access = SubMenuAccess::select('sub_menu_accesses.*','sub_menu_name')
                        ->leftJoin('sub_menus', 'sub_menus.id', '=', 'sub_menu_accesses.sub_menu_id')                
                        ->where('group_id',$group_id)
                        ->where('sub_menu_accesses.menu_id',$menu_id)
                        ->orderBy('position','ASC')->paginate(25)->onEachSide(1);
        return view('admin.sub_menu_access.index',compact('title','group','menu','sub_menu_access'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $group_id,$menu_id)
    {
        $title = "Sub Menu Akses";

        $group_id = Crypt::decrypt($group_id);
        $menu_id = Crypt::decrypt($menu_id);

        $group = Group::where('id',$group_id)->first();
        $menu = Menu::where('id',$menu_id)->first();

        $sub_menu_access = $request->get('search');
        $sub_menu_access = SubMenuAccess::select('sub_menu_accesses.*','sub_menu_name')
                            ->leftJoin('sub_menus', 'sub_menus.id', '=', 'sub_menu_accesses.sub_menu_id')                
                            ->where('group_id',$group_id)
                            ->where('sub_menu_accesses.menu_id',$menu_id)
                            ->where('sub_menu_name', 'LIKE', '%'.$sub_menu_access.'%')
                            ->orderBy('position','ASC')->paginate(25)->onEachSide(1);
        
        return view('admin.sub_menu_access.index',compact('title','group','menu','sub_menu_access'));
    }
    
    ## Tampilkan Form Create
    public function create($group_id,$menu_id)
    {
        $title = "Sub Menu Akses";
        
        $group_id = Crypt::decrypt($group_id);
        $menu_id = Crypt::decrypt($menu_id);

        $group = Group::where('id',$group_id)->first();
        $menu = Menu::where('id',$menu_id)->first();
        
        $sub_menu = SubMenu::where('menu_id',$menu_id)->get();
        $view=view('admin.sub_menu_access.create',compact('title','group','menu','sub_menu'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store($group_id, $menu_id, Request $request)
    {
        
        $group_id = Crypt::decrypt($group_id);
        $menu_id = Crypt::decrypt($menu_id);
        
        $this->validate($request, [
            'sub_menu_id' => 'required',
            'create' => 'required',
            'read' => 'required',
            'update' => 'required',
            'delete' => 'required',
            'print' => 'required',
        ]);

        $input['group_id'] = $group_id;
        $input['menu_id'] = $menu_id;
        $input['sub_menu_id'] = $request->sub_menu_id;
        $input['create'] = $request->create;
        $input['read'] = $request->read;
        $input['update'] = $request->update;
        $input['delete'] = $request->delete;
        $input['print'] = $request->print;
        $input['user_id'] = Auth::user()->id;
        
        SubMenuAccess::create($input);
        
        activity()->log('Tambah Data Sub Menu Akses');
        return redirect('/sub_menu_akses/'.Crypt::encrypt($group_id).'/'. Crypt::encrypt($menu_id))->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($group_id, $menu_id, $sub_menu_access)
    {
        $title = "Sub Menu Akses";
        
        $group_id = Crypt::decrypt($group_id);
        $menu_id = Crypt::decrypt($menu_id);
        $sub_menu_access = Crypt::decrypt($sub_menu_access);
        
        $group = Group::where('id',$group_id)->first();
        $menu = Menu::where('id',$menu_id)->first();
        $sub_menu_access = SubMenuAccess::where('id',$sub_menu_access)->first();

        $sub_menu = SubMenu::where('menu_id',$menu_id)->get();
        $view=view('admin.sub_menu_access.edit', compact('title','group','menu','sub_menu','sub_menu_access'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $group_id, $menu_id, $sub_menu_access)
    {
        $sub_menu_access = Crypt::decrypt($sub_menu_access);
        $sub_menu_access = SubMenuAccess::where('id',$sub_menu_access)->first();

        $this->validate($request, [
            'sub_menu_id' => 'required',
            'create' => 'required',
            'read' => 'required',
            'update' => 'required',
            'delete' => 'required',
            'print' => 'required',
        ]);

        $sub_menu_access->fill($request->all());
        
        $sub_menu_access->user_id = Auth::user()->id;
        $sub_menu_access->save();
        
        activity()->log('Ubah Data Sub Menu Akses dengan ID = '.$sub_menu_access->id);
        return redirect('/sub_menu_akses/'.$group_id.'/'. $menu_id)->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($group_id, $menu_id, $sub_menu_access)
    {
        $sub_menu_access = Crypt::decrypt($sub_menu_access);
        $sub_menu_access = SubMenuAccess::where('id',$sub_menu_access)->first();

        $sub_menu_access->delete();

        activity()->log('Hapus Data Sub Menu Akses dengan ID = '.$sub_menu_access->id);
        return redirect('/sub_menu_akses/'.$group_id.'/'.$menu_id)->with('status', 'Data Berhasil Dihapus');
    }
}
