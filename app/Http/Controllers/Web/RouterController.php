<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Router, App\Package;
use DataTables;
use \RouterOS\Client;
use \RouterOS\Query;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;


class RouterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('cms.router.allrouter.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatables()
    {
        $data = Router::all();

        return Datatables::of($data)  
        ->editColumn('router_name',
            function ($data){
                return $data->router_name;
        })     
        ->editColumn('host',
            function ($data){
                return $data->host;
        })         
        ->editColumn('port',
            function ($data){
                return $data->port;
        })               
        ->editColumn('address',
            function ($data){
                return $data->address;
        })   
              
        ->editColumn('action',
            function ($data){                                
            
                    return
                    \Component::btnRead(route('all-router-detail', $data->id), 'Detail Router '. $data->name).
                    \Component::btnUpdate(route('all-router-edit', $data->id), 'Ubah router '. $data->router_name).
                    \Component::btnDelete(route('all-router-destroy', $data->id), 'Hapus router '. $data->router_name);
                    
        })
        ->addIndexColumn()
        // ->rawColumns(['action']) 
        ->make(true);      
    }


    public function create()
    {
        return view('cms.router.allrouter.create');
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
   	'router_name'       => 'required|max:50',
            'host'              => 'required|max:100',
            'port'              => 'required|integer', 
            'user'              => 'required|max:50', 
            'password'          => 'required', 
            'address'           => 'required|max:100', 
            'coordinate'        => 'max:100', 
        ]);
        $request['password'] = Crypt::encryptString(request('password'));
        Router::create($request->except('_token'));
        
        $arrSelect = [
            'users.id as id',
            'users.username as name',
            'subscription.name as subscription_name',
            'transactions.status as status',
           
        ];
        $users = DB::table('users')
        ->join('user_has_subscription', 'users.id', '=', 'user_has_subscription.user_id')
        ->join('subscription', 'user_has_subscription.subscription_id', '=', 'subscription.id')
        ->join('transactions', 'user_has_subscription.id', '=', 'transactions.users_has_packages_id')
        ->select($arrSelect)
        ->get();

        $router = Router::all()
        ->where('router_name', $request['router_name'])
        ->first();
        $subscription = Package::all();
        $encryptedValue = $router->password;
        $decrypted = Crypt::decryptString($encryptedValue);
        $client = new Client([
            'host' => $router->host,
            'port' => $router->port,
            'user' => $router->user,
            'pass' => $decrypted
        ]);       
        foreach ($subscription as $key => $package)
        {
            $query = (new Query('/ppp/profile/add'))
            ->equal('name', $package->name);

            // Update query ordinary have no return
            $client->query($query)->read();
        }
       
        foreach ($users as $key => $user)
        {
            if($user->status == \EnumTransaksi::STATUS_TENGGANG )
            {
                $query = (new Query('/ppp/secret/add'))
                ->equal('name', $user->name)
                ->equal('password', $user->name)
                ->equal('profile', 'Block');
    
                // Update query ordinary have no return
                $client->query($query)->read();
            }else{
                $query = (new Query('/ppp/secret/add'))
                ->equal('name', $user->name)
                ->equal('password', $user->name)
                ->equal('profile', $user->subscription_name);
    
                // Update query ordinary have no return
                $client->query($query)->read();
            }
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
        $data = Router::where('id', $id)->first();

        return view ('cms.router.allrouter.edit', compact ('data'));
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
        $this->validate($request,[
   	'router_name'       => 'required|max:50',
            'host'              => 'required|max:100',
            'port'              => 'required|integer', 
            'user'              => 'required|max:50', 
            'password'          => 'required|min:8', 
            'address'           => 'required|max:100', 
            'coordinate'        => 'max:100', 
        ]);
        // $request['role_id'] = ROLE::ROLE_WARGA;
        $request['password'] = Crypt::encryptString(request('password'));
        Router::where('id', $id)->update($request->except('_token'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function detail($id)
    {
        $data = Router::all()->where('id', $id)->first();

        $client = new Client([
            'host' => '',
            'port' => 8721,
            'user' => '',
            'pass' => ''
        ]);

    
        
        // Create "where" Query object for RouterOS
        $query = new Query('/ppp/active/print');
        $query->where('name', $data->router_name);
        // $client->query('/ppp/secret/add',[
        //     ['name', 'name' ],
        //     ['password', 'pass' ]

        // ]);    

        $response = $client->query($query)->read();
        return view ('cms.router.allrouter.detail', compact ('data','response'));

    }

    
    public function destroy($id)
    {
        $data= Router::where('id', $id)->first();
        
        if (is_null($data)){
            return 'tidak ditemukan';
        }else{
            $data->delete();
           
        }
    }
}
