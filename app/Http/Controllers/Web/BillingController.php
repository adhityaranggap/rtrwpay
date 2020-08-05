<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\User, App\Role;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cms.users.billing.index');
    }

    public function datatables()
    {       
    
        $data = User::where('role_id', Role::ROLE_BILLING)->get();
        return Datatables::of($data)  
        ->editColumn('name',
            function ($data){
                return $data->name;
        })     
        ->editColumn('username',
            function ($data){
                return $data->username;
        })         
        ->editColumn('action',
            function ($data){                                
            
                    return
                    //\Component::btnRead('#', 'Detail Customer').
                    \Component::btnUpdate(route('billing-edit', $data->id), 'Ubah Billing User '. $data->name).
                    \Component::btnDelete(route('billing-destroy', $data->id), 'Hapus Billing User '. $data->name);
                    
        })
        ->addIndexColumn()
        // ->rawColumns(['action']) 
        ->make(true);          
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.users.billing.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
   	'username' => 'required',
   	'name' => 'required',
        ]);
        $request['role_id'] = Role::ROLE_BILLING;
        $request['password'] = bcrypt(request('password'));
        // return $request->all();
        User::create($request->except('_token'));
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::where('id', $id)->first();
        return view('cms.users.billing.edit', compact ('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $this->validate($request,[
            'name'      =>  'required|max:255|string',
            'username'  =>  'required|max:255|string|unique:users,username,'.$user->id,
        ]);

        
        if($user){
            User::where('id', $id)->update($request->except('_token'));
        }
        
        return false;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user= User::where('id', $id)->first();
        
    if (is_null($user)){
        return 'tidak ditemukan';
    }else{
        $user->delete();
        return 'sucess delete';
    }
    }
}
