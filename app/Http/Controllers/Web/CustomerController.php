<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\User, App\Role, App\UserHasPackage, App\Transaction, App\subscription, App\EnumUserPackage;
use \RouterOS\Client;
use \RouterOS\Query;
use Carbon\Carbon;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
       return view('cms.users.customer.index');

    }

    public function datatables()
    {       
    
        $data = User::where('role_id', ROLE::ROLE_WARGA);
        
        return Datatables::of($data)  
        // ->editColumn('name',
        //     function ($data){
        //         return $data->name;
        // })     
        ->editColumn('username',
            function ($data){
                return $data->username;
        })         
        ->editColumn('contact_person',
            function ($data){
                return $data->contact_person;
        })               
        ->editColumn('Address',
            function ($data){
                return $data->address;
        })   
              
        ->editColumn('action',
            function ($data){                                
            
                    return
                    // \Component::btnDetailPaket(route('warga-detail'), 'Detail Customer').
                    \Component::btnUpdate(route('warga-edit', $data->id), 'Ubah Customer '. $data->name).
                    \Component::btnDelete(route('warga-destroy', $data->id), 'Hapus Customer '. $data->name);
                    
        })
        ->addIndexColumn()
        // ->rawColumns(['action']) 
        ->make(true);          
    }

    /**x
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.users.customer.create');
    }
    public function import()
    {
        $subscription = subscription::all('name', 'id');
        return view('cms.users.customer.import', compact('subscription'));
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
   	        'username'       => 'required|max:50',
            'address'        => 'required|max:100',
            'name'           => 'required|max:50', 
            'password'       => 'required|min:8', 
            'email'          => 'required|email', 
            'contact_person' => 'required', 
        ]);
        $request['role_id'] = ROLE::ROLE_WARGA;
        $request['password'] = bcrypt(request('password'));
        $request['password_router'] = encrypt($request['username']);

        User::create($request->except('_token'));
 
        
    }
    public function storeImport(Request $request)
    {
        // return 'sukses';

        // validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
        ]);
        

        if($request->hasFile('file')){
            $path = $request->file('file')->getRealPath();
            $users = Excel::toArray(new UsersImport, $request->file('file'));
            // $users[0][0]; //heder
            if(count($users[0]) > 1)
            {               
                foreach ($users[0] as $key => $user) {            
                  $users[0] > [$key+1];
                    if($key > $key+1 ){  
                        $data = $users[0][$key+1];
                    }else{
                        $data = $users[0][$key]; 
                    }
                    $userCheckUsername = User::where('username', $data[1])->first();
                    $subscription = $request['subscription_id'];
                    $password = bcrypt($data[3]);
                    $password_router = encrypt($data[1]);

                    if($userCheckUsername != null){
                        User::where('username', $data[1])->update([
                            'name' =>$data[2] ,
                            'password'=>$password,
                            'password_router'=>$password_router,
                            'email'=>$data[4],
                            'contact_person'=>$data[5],
                            'address'=>$data[6],
                            'role_id'=> ROLE::ROLE_WARGA
                        ]);
                        $userCheckPackage = UserHasPackage::where('user_id', $userCheckUsername->id)->first();
                            if($userCheckPackage != null){
                                UserHasPackage::where('user_id', $userCheckUsername->id)->update([
                                    'subscription_id'    => $subscription,
                                    'verification'  => 'First Month',
                                    'status'        => 'active',
                                    'notes'         => '-'
                                ]);
                            }else{
                                $id = DB::getPdo()->lastInsertId();
                            UserHasPackage::create([
                                'user_id'       => $id,
                                'subscription_id'    => $subscription,
                                'verification'  => 'First Month',
                                'status'        => 'active',
                                'notes'         => '-'
                            ]);
                            $id = DB::getPdo()->lastInsertId();
                            $data = DB::table('user_has_subscription')
                            ->join('subscription','user_has_subscription.subscription_id','subscription.id')
                            ->select('subscription.price')
                            ->where('user_has_subscription.id', $id)->first();

                            Transaction::create([
                                'users_has_packages_id'         =>  $id,
                                'transaction_has_modified_id'   => 1,
                                'notes'                         => '-',
                                'expired_date'                  => Carbon::now()->addMonths(1),
                                'status'                        => \EnumTransaksi::STATUS_BELUM_BAYAR,
                                'price'                         =>  $data->price,
                                'fee'                           =>  0,
                                'paid'                          =>  0,
                                'created_at'                    =>  now(),                   
                            ]);
                            };
                    }else{
                            User::create([
                                'username'=>$data[1],
                                'name' =>$data[2] ,
                                'password'=>$data[3],
                                'password_router'=>$data[1],
                                'email'=>$data[4],
                                'contact_person'=>$data[5],
                                'address'=>$data[6],
                                'role_id'=> ROLE::ROLE_WARGA
                            ]);
                            $id = DB::getPdo()->lastInsertId();;
                            UserHasPackage::create([
                                'user_id'       => $id,
                                'subscription_id'    => $subscription,
                                'verification'  => 'First Month',
                                'status'        => 'active',
                                'notes'         => '-'
                            ]);
                            $id = DB::getPdo()->lastInsertId();;
                            $data = DB::table('user_has_subscription')
                            ->join('subscription','user_has_subscription.subscription_id','subscription.id')
                            ->select('subscription.price')
                            ->where('user_has_subscription.id', $id)->first();
                            
                                Transaction::create([
                                    'users_has_packages_id'         =>  $id,
                                    'transaction_has_modified_id'   => 1,
                                    'notes'                         => '-',
                                    'expired_date'                  => Carbon::now()->addMonths(1),
                                    'status'                        => \EnumTransaksi::STATUS_BELUM_BAYAR,
                                    'price'                         =>  $data->price,
                                    'fee'                           =>  0,
                                    'paid'                          =>  0,
                                    'created_at'                    =>  now(),
                            ]);       
                            };
                   
                  }
            }
        };
        
    }

    public function loadData(Request $request)
    {
        if ($request->has('q')) {
            $cari = $request->q;
            $data = DB::table('user_has_subscription')
            ->join('users','user_has_subscription.user_id','users.id')
            ->join('subscription','user_has_subscription.subscription_id','subscription.id')
            ->select(
                'user_has_subscription.id as id', 
                'users.username', 'subscription.name', 
                'users.email', 'subscription.price')
            ->where('users.username', 'like', '%' . $cari . '%'
            )->get();

            return response()->json($data);
        }
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
        $data = array();
        $data['user'] = User::where('id', $id)->first();
        
        $data['subscription'] = DB::table('user_has_subscription')
            ->join('subscription','user_has_subscription.subscription_id','subscription.id')
            ->select('subscription.name as subscription_name','subscription.speed', 'subscription.price')
            ->where('user_has_subscription.user_id', $data['user']->id)
            ->get();

            
        return view('cms.users.customer.edit', compact ('data'));
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

        $data = User::where('id', $id)->first();
        $this->validate($request,[
            'username'      =>  'required|max:255|string|unique:users,username,'.$data->id,
            'name'          =>  'required|max:255|string',
            'address'       =>  'required|max:255|string'
        ]);

        
        $request['password'] = bcrypt(request('password'));
        
        if($data)
        {
            User::where('id', $id)->update($request->only('username','password','name','address'));
            return "Data Berhasil di Update";

        }else{
            return false;
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // menghapus data pegawai berdasarkan id yang dipilih
	$user= User::where('id', $id)->first();
        
    if (is_null($user)){
        return 'tidak ditemukan';
    }else{
        $user->delete();
       
    }

    }
    
}
