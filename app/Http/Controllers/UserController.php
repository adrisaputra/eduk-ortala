<?php

namespace App\Http\Controllers;

use App\Models\User;   //nama model
use App\Models\Group;   //nama model
use App\Models\ParentUnit;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "User";
		$user = User::orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $group = Group::get();
		return view('admin.user.index',compact('title','user','group'));
    }
	
	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "User";
        $user = $request->get('search');
		$user = User::
                where(function ($query) use ($user) {
                    $query->where('name', 'LIKE', '%'.$user.'%')
                        ->orWhere('email', 'LIKE', '%'.$user.'%');
                })->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $group = Group::get();

        if($request->input('page')){
            return view('admin.user.index',compact('title','user','group'));
        } else {
            return view('admin.user.search',compact('title','user','group'));
        }
    }
	
    ## Tampilkan Form Create
    public function create()
    {
        $title = "User";
        $group = Group::get();
        $parent_unit = ParentUnit::get();
		$view=view('admin.user.create',compact('title','group','parent_unit'));
        $view=$view->render();
        return $view;
    }

	## Simpan Data
	public function store(Request $request)
    {
		
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'group_id' => 'required',
            'status' => 'required'
        ]);

		if($request->group_id == 2){
            $this->validate($request, [
                'parent_unit_id' => 'required'
            ]);
        }
        
        $input['name'] = $request->name;
        $input['email'] = $request->email;
        $input['email_verified_at'] = date('Y-m-d H:i:s');
        $input['password'] = Hash::make($request->password);
        $input['group_id'] = $request->group_id;
        if($request->group_id == 2){
            $input['parent_unit_id'] = $request->parent_unit_id;
        }
        $input['status'] = $request->status;
        User::create($input);
		
        activity()->log('Tambah Data User');
		return redirect('/user')->with('status','Data Tersimpan');

    }
	
	## Tampilkan Form Edit
    public function edit($user)
    {
        $title = "User";
        $user = Crypt::decrypt($user);
        $user = User::where('id',$user)->first();
        $group = Group::get();
        $parent_unit = ParentUnit::get();
        $view=view('admin.user.edit', compact('title','user','group','parent_unit'));
        $view=$view->render();
		return $view;
    }
	
	## Edit Data
    public function update(Request $request, $user)
    {
        
        $user = Crypt::decrypt($user);
        $user = User::where('id',$user)->first();

        if($request->group_id==2){
            if($request->password){
                $this->validate($request, [
                    'password' => 'required|string|min:8|confirmed'
                ]);
            } 
            $this->validate($request, [
                'parent_unit_id' => 'required'
            ]);
        } else {
            if($request->password){
                $this->validate($request, [
                    'name' => 'required|string|max:255',
                    'password' => 'required|string|min:8|confirmed'
                ]);
            } else {
                $this->validate($request, [
                    'name' => 'required|string|max:255'
                ]);
            }
        }
         
		if($request->password){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->group_id = $request->group_id;
            if ($request->group_id == 2 ) {
                $user->parent_unit_id = $request->parent_unit_id;
            }
            $user->status = $request->status;
		} else {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->group_id = $request->group_id;
            if ($request->group_id == 2 ) {
                $user->parent_unit_id = $request->parent_unit_id;
            }
            $user->status = $request->status;
        }
        $user->save();
        
        activity()->log('Ubah Data User dengan ID = '.$user->id);
		return redirect('/user')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($user)
    {
        $user = User::where('id',$user)->first();
        $user->delete();
        activity()->log('Hapus Data User dengan ID = '.$user->id);
		return redirect('/user')->with('status', 'Data Berhasil Dihapus');
    }

    ## Tampilkan Form Edit
    public function edit_profil($user)
    {
        $title = "Profil";
        $user = Crypt::decrypt($user);
        $user = User::where('id',$user)->first();
        $view=view('admin.user.profil', compact('title','user'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update_profil(Request $request, $user)
    {
        
        $user = Crypt::decrypt($user);
        $user = User::where('id',$user)->first();

        if($request->get('current-password')){
            if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
                $this->validate($request, [
                    'email' => 'required|email',
                    'foto' => 'mimes:jpg,jpeg,png|max:300',
                    'current-password' => 'string|confirmed'
                ]);
            } 
        }
            
        if($request->get('password')){
            if(!(strcmp($request->get('password'), $request->get('password_confirmation'))) == 0){
                if($request->password){
                    $this->validate($request, [
                        'email' => 'required|email',
                        'password' => 'string|min:8|confirmed'
                    ]);
                }
            } 
        }

        if($request->password){
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:8'
            ]);
        } else {
            $this->validate($request, [
                'email' => 'required|email'
            ]);
        }

        $user->fill($request->all());
        if($request->password){
            $user->password = Hash::make($request->password);
        } else {
            $cek_user = User::where('id', Auth::user()->id)->first();
            $user->password = $cek_user->password;
        }
        
        if($request->file('foto') == ""){}
        else
        {	
            $filename = time().'.'.$request->foto->getClientOriginalExtension();
            $request->foto->move(public_path('upload/foto'), $filename);
            $user->foto = $filename;
        }
        
        $user->save();
        
        activity()->log('Ubah Data Profil dengan ID = '.$user->id);
        return redirect('/user/edit_profil/'.Crypt::encrypt($user->id))->with('status', 'Data Berhasil Diubah');
    }
}
