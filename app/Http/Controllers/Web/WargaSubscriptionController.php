<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use DataTables; 
use App\User, App\UserHasSubscription, App\subscription, App\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WargaSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cms.subscription.wargasubscription.index');
    }
    public function datatables()
    {       
    
        $arrSelect = [
            'users.username as username',
            'user_has_subscription.id as id',
            'subscriptions.name as subscription_name',
            'subscriptions.price as price',
           
        ];
        // $data = transaction::all();
        $data = DB::table('users')
        ->join('user_has_subscription', 'users.id', '=', 'user_has_subscription.user_id')
        ->join('subscriptions', 'user_has_subscription.subscription_id', '=', 'subscriptions.id')
        ->orderBy('user_has_subscription.created_at','desc')
        ->select($arrSelect)
        ->get();
        return Datatables::of($data)  
        ->editColumn('username',
            function ($data){
                return $data->username;
        })     
        ->editColumn('subscription_name',
            function ($data){
                return $data->subscription_name;
        })         
        
        ->editColumn('price',
            function ($data){
                return $data->price;
        })               
              
        ->editColumn('action',
            function ($data){                                
            
                    return
                    //\Component::btnRead('#', 'Detail Customer').
                    \Component::btnUpdate(route('warga-subscription-edit', $data->id), 'Ubah subscription '. $data->username).
                    \Component::btnDelete(route('warga-subscription-destroy', $data->id), 'Hapus subscription '. $data->subscription_name);
                    
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

    public function loadData(Request $request)
    {
        if ($request->has('q')) {
            $cari = $request->q;
            $data = DB::table('users')
            ->select('id', 'username')->where('users.username', 'like', '%' . $cari . '%')->get();
            
            return response()->json($data);
        }
    }

    public function create()
    {
        $subscriptions = Subscription::all('name', 'id');

        return view('cms.subscription.wargasubscription.create', compact ('subscriptions'));
        // $arrSelect = [
        //     'users.username as username',
        //     'user_has_subscription.id as id',
        //     'subscriptions.name as subscription_name',
        //     'subscriptions.id as subscription_id',
        //    
        // ];
        // $subscription = subscription::all('name', 'id');
        // $data = DB::table('users')
        // ->join('user_has_subscription', 'users.id', '=', 'user_has_subscription.user_id')
        // ->join('subscriptions', 'user_has_subscription.subscription_id', '=', 'subscriptions.id')
        // ->select($arrSelect)
        // // ->where('user_has_subscription.id',$id)
        // ->first();
        // // $data = UserHasSubscription::where('id', $id)->first();
        // return view('cms.subscription.wargasubscription.edit', compact ('data','subscriptions'));
    
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
   	        'user_id' => 'required|integer',
            'subscription_id' => 'required|integer|max:15',
        ]);
        // simpan di user has subscription
        $userHasSubscription = UserHasSubscription::create($request->except('_token'));
       
        // buat transaksi baru dari paket yang diambil
        // $id = DB::getPdo()->lastInsertId();
        $arrSelect = [
            'subscriptions.price',
            'subscriptions.plan_period as plan'
        ];
        $data = DB::table('user_has_subscription')
        ->join('subscriptions','user_has_subscription.subscription_id','subscriptions.id')
        ->select($arrSelect)
        ->where('user_has_subscription.id', $userHasSubscription->id)->first();
        // return response()->json($data->plan);
        if($data->plan == \EnumSubscription::PLAN_DAILY){
            $expired = Carbon::now()->addDay();
        }elseif($data->plan == \EnumSubscription::PLAN_WEEKLY){
            $expired = Carbon::now()->addWeeks();
        }elseif($data->plan == \EnumSubscription::PLAN_MONTHLY){
            $expired = Carbon::now()->addMonth();
        }elseif($data->plan == \EnumSubscription::PLAN_YEARLY){
            $expired = Carbon::now()->addYears();
        }
        Transaction::create([
            'user_has_subscription_id'   =>  $userHasSubscription->id,
            'transaction_has_modified_id'   => 1,
            'notes'                 => '-',
            'expired_date'          =>  $expired,
            'status'                => \EnumTransaksi::STATUS_BELUM_BAYAR,
            'price'                 =>  $data->price,
            'paid'                   =>  0,
            'created_at'            =>  now(),                   
        ]);
        

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
        $arrSelect = [
            'users.username as username',
            'user_has_subscription.id as id',
            'subscriptions.name as subscription_name',
            'subscriptions.id as subscription_id',
           
        ];
        $subscriptions = Subscription::all('name', 'id');
        $data = DB::table('users')
        ->join('user_has_subscription', 'users.id', '=', 'user_has_subscription.user_id')
        ->join('subscriptions', 'user_has_subscription.subscription_id', '=', 'subscriptions.id')
        ->select($arrSelect)
        ->where('user_has_subscription.id',$id)
        ->first();
        // $data = UserHasSubscription::where('id', $id)->first();
        return view('cms.subscription.wargasubscription.edit', compact ('data','subscriptions'));
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
        $data = UserHasSubscription::where('id', $id)->first();
        $this->validate($request,[
            'subscription_id'  =>  'required|max:10|integer'

        ]);

        
        if($data){
        UserHasSubscription::where('id', $id)->update($request->only('subscription_id'));
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
     // menghapus data pegawai berdasarkan id yang dipilih
	$data= UserHasSubscription::where('id', $id)->first();
        
    if (is_null($data)){
        return 'tidak ditemukan';
    }else{
        $data->delete();
       
    }
    }
}