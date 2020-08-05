<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\User, App\Role, App\Router, App\Transaction, App\Package;
use \RouterOS\Client;
use \RouterOS\Query;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;



class ActiveUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
       return view ('cms.users.activeuser.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function datatables()
    {    
        $routers = Router::all()
        ->where('router_name', 'VPN-Server');
        foreach($routers as $key => $router){
            $encryptedValue = $router->password;
            $decrypted = Crypt::decryptString($encryptedValue);
           
            $client = new Client([
                'host' => $router->host,
                'port' => $router->port,
                'user' => $router->user,
                'pass' => $decrypted
            ]);
            $query = new Query('/ppp/active/print');
       
            $response = $client->query($query)->read();
        }
        // ===========================
        return Datatables::of($response) 
        ->editColumn('name',
            function ($response){
                return $response['name'];
        })     
        ->editColumn('address',
            function ($response){
                return $response['address'];
        })         
             
        ->editColumn('uptime',
            function ($response){
                return $response['uptime'];
        })   
              
        // ->editColumn('action',
        //     function ($response){                                
            
        //             // \Component::btnDetailPaket(route('warga-detail'), 'Detail Customer').
        //             // \Component::btnUpdate(route('warga-edit', $data->id), 'Ubah Customer '. $data->name).
        //             // \Component::btnDelete(route('warga-destroy', $data->id), 'Hapus Customer '. $data->name);
                    
        // })
        ->addIndexColumn()
        // ->rawColumns(['action']) 
        ->make(true);     
        // }else{
        //     return 'kosong';
        // }     ;
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
       //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
