<?php

namespace App\Http\Controllers;

use App\Models\Group;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class GroupController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Group";
        $group = Group::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.group.index',compact('title','group'));
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Group";
        $group = $request->get('search');
        $group = Group::where('group_name', 'LIKE', '%'.$group.'%')
                ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        
        return view('admin.group.index',compact('title','group'));
    }
	
    ## Tampilkan Form Create
    public function create()
    {
        $title = "Group";
		$view=view('admin.group.create',compact('title'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'group_name' => 'required',
        ]);

		$input['group_name'] = $request->group_name;
		$input['user_id'] = Auth::user()->id;
		
        Group::create($input);
        
        activity()->log('Tambah Data Group');
		return redirect('/group')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($group)
    {
        $title = "Group";
        $group = Crypt::decrypt($group);
        $group = Group::where('id',$group)->first();
        $view=view('admin.group.edit', compact('title','group'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $group)
    {
        
        $group = Crypt::decrypt($group);
        $group = Group::where('id',$group)->first();

        $this->validate($request, [
            'group_name' => 'required',
        ]);

        $group->fill($request->all());
        
		$group->user_id = Auth::user()->id;
    	$group->save();
		
        activity()->log('Ubah Data Group dengan ID = '.$group->id);
		return redirect('/group')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($group)
    {
        $group = Crypt::decrypt($group);
        $group = Group::where('id',$group)->first();
    	$group->delete();

        activity()->log('Hapus Data Group dengan ID = '.$group->id);
        return redirect('/group')->with('status', 'Data Berhasil Dihapus');
    }
}
