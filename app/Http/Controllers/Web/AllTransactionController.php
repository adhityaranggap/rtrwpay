<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use DataTables, Auth;
use App\Notifications\InvoicePaid;
use Illuminate\Notifications\Notifiable;
use App\User, App\Router, App\UserHasSubscription, App\Role, App\Subscription, App\Transaction, App\TransactionHasModified;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use \RouterOS\Client;
use \RouterOS\Query;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
 
class AllTransactionController extends Controller
{
    use Notifiable;
    use \Illuminate\Notifications\Notifiable;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cms.transactions.alltransaction.index');
    }


    public function datatables()
    {       
        // $modified = DB::table('transaction_has_modified')
        // ->join('transactions', 'transaction_has_modified.transaction_id', 'transactions.id')
        // ->get();
        // return $modified;

            $arrSelect = [
                'users.username as name',
                'transactions.expired_date as expired_date',
                'subscriptions.name as subscription_name',
                'transactions.price as price',
                'transactions.id as id',
                'transactions.status as status',
                'users.role_id',
                // 'trasanction_has_modified.transaction_id as transaction_modified'
            ];
            // $data = transaction::all();
            if (Auth::check() && auth()->user()->role_id == ROLE::ROLE_WARGA){
            $data = DB::table('users')
            ->join('user_has_subscription', 'users.id', '=', 'user_has_subscription.user_id')
            ->join('subscriptions', 'user_has_subscription.subscription_id', '=', 'subscriptions.id')
            ->join('transactions', 'user_has_subscription.id', '=', 'transactions.user_has_subscription_id')
            // ->join('transaction_has_modified', 'transactions.id', 'transaction_has_modified.transaction_id')
            ->where('user_has_subscription.user_id', auth()->user()->id)
            ->orderBy('transactions.expired_date','desc')
            ->select($arrSelect)
            ->get();
 
            }else{
            $data = DB::table('users')
            ->join('user_has_subscription', 'users.id', '=', 'user_has_subscription.user_id')
            ->join('subscriptions', 'user_has_subscription.subscription_id', '=', 'subscriptions.id')
            ->join('transactions', 'user_has_subscription.id', '=', 'transactions.user_has_subscription_id')
            // ->join('transaction_has_modified', 'transactions.id', 'transaction_has_modified.transaction_id')
       
            ->orderBy('transactions.expired_date','desc')
            ->select($arrSelect)
            ->get();
 
            }
            
        return Datatables::of($data)  

        ->editColumn('id',
            function ($data){
                return $data->id;
        })     
        ->editColumn('name',
            function ($data){
                return $data->name;
        })     
        // ->editColumn('month_date',
        //     function ($data){
        //         return date('M Y', strtotime($data->expired_date));
        // })                
        ->editColumn('subscription_name',
            function ($data){
                return $data->subscription_name;
        })   
        // ->editColumn('price',
        //     function ($data){
        //         return $data->price;
        // })   
        ->editColumn('expired_date',
            function ($data){
                return Carbon::parse($data->expired_date)->format('M Y');
        })              
        ->editColumn('status',
            function ($data){
                return \EnumTransaksi::status($data->status);
        })              
              
        ->editColumn('action',
            function ($data){                                
            
                    return
                    \Component::btnRead(route('all-transaction-detail', $data->id), 'Detail Transaction '. $data->name).
                    \Component::btnUpdate(route('all-transaction-edit', $data->id), 'Ubah Transaction '. $data->name).
                    \Component::btnDelete(route('all-transaction-destroy', $data->id), 'Hapus Transaction '. $data->name . ' '. Carbon::parse($data->expired_date)->format('M Y'));
                    
        })
        ->addIndexColumn()
        ->rawColumns(['status', 'action']) 
        ->make(true);          
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subscriptions = Subscription::all();
        return view('cms.transactions.alltransaction.create', compact('subscriptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subscription_id = $request['subscription'];
        $data = Subscription::select('price')->where('id', $subscription_id)->first();
        $maxPaid = $data->price;
        $sisa    = $data->price - $request->paid;

        $this->validate($request,[
            'user_has_subscription_id'       => 'required|max:50',
            'expired_date'                   => 'required|max:100',
            'paid'                           => 'required|numeric|max:'.$maxPaid,
        ]);


    //payment_proof
        if($request->type_payment === "Transfer"){
            $this->validate($request, [
                'payment_proof' =>  'mimes:jpeg,jpg,png,gif|required|max:8000'
            ]);
        }

        // $request['updated_at'] = now();        
        // $request['transaction_has_modified'] = now();        
        // $request['created_at'] = now();        
        $request['notes']      = '-';        
        $request['price']      = $data->price;
        if($sisa == 0){
            $request['status'] = \EnumTransaksi::STATUS_LUNAS;
        }else{
            $request['status'] = \EnumTransaksi::STATUS_BELUM_LUNAS;
        }
        
            //  Transaction::create($request->except('_token'));


            if($request->type_payment === "Transfer"){
                //payment_proof
                    if($request->file('payment_proof')){
                        $dir = 'payment_proof/';
                        $size = '360';
                        $format = 'file';
                        $image = $request->file('payment_proof');         
                        // $request['file'] = Storage::disk('minio')->put($image);
                        $request['file'] = \ImageUploadHelper::pushStorage($dir, $size, $format, $image);
                        
                    }
                    // TransactionHasModified::create([
                    //     'user_id'               => Auth::user()->id,
                    //     'transaction_id'        => $id,
                    //     'action'                => \EnumTransaksiHasModified::UPDATE
                    // ]);
                    // $request['transaction_has_modified_id'] = DB::getPDO()->lastInsertId();

                    Transaction::create($request->except('_token'));
                    // TransactionHasModified::create([
                    //     'user_id'               => Auth::user()->id,
                    //     'transaction_id'        => $id,
                    //     'action'                => \EnumTransaksiHasModified::UPDATE
                    // ]);
                    // // $transaction->notify(new InvoicePaid($invoice));

                }else{
                   
                    // TransactionHasModified::create([
                    //     'user_id'               => Auth::user()->id,
                    //     'transaction_id'        => $id,
                    //     'action'                => \EnumTransaksiHasModified::UPDATE
                    // ]);
                    // $request['transaction_has_modified_id'] = DB::getPDO()->lastInsertId();
                    Transaction::create($request->except('_token','file'));
                    // $transaction->notify(new InvoicePaid($invoice));
                    // $transaction->notify(new InvoicePaid("Payment Received!"));


                    
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
        $arrResponse = [
            'transactions.id as id',
            'users.name',
            'users.contact_person',
            'transactions.paid',
            'subscriptions.name as subscription_name',
            'transactions.price as payment_billing', 
            'expired_date',
            'transactions.updated_at'
        ];

        $data = DB::table('transactions')
        ->join('user_has_subscription','transactions.user_has_subscription_id','user_has_subscription.id')
        ->join('subscriptions','user_has_subscription.subscription_id','subscriptions.id')
        ->join('users','user_has_subscription.user_id','users.id')
        ->select($arrResponse)
        ->where('transactions.id', $id)->first();
        
        
        return view('cms.transactions.alltransaction.edit', compact ('data'));    }

    /**
     * Detail the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $arrResponse = [
            'transactions.id as id',
            'transactions.updated_at',
            'transactions.type_payment',
            'transactions.file',
            'transactions.paid',
            'transactions.price as payment_billing', 
            'subscriptions.name as subscription_name',         
            'users.name',
            'users.contact_person',                        
            'transactions.expired_date',
            'transaction_has_modified.user_id as modified_by',
            'transaction_has_modified.action as action'
        ];
        

        $data = DB::table('transactions')
      
        ->join('user_has_subscription','transactions.user_has_subscription_id','user_has_subscription.id')
        ->join('subscriptions','user_has_subscription.subscription_id','subscriptions.id')
        ->join('users','user_has_subscription.user_id','users.id')
        ->leftjoin('transaction_has_modified','transactions.id','transaction_has_modified.transaction_id')
        ->select($arrResponse)
        ->where('transactions.id', $id)->first();
        
        // return response()->json($data);
        return view('cms.transactions.alltransaction.detail', compact ('data'));
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
        $transaction = Transaction::where('id', $id)->first();
        $maxPaid = $transaction->price - $transaction->paid;
        $UserPay = $request->paid+$transaction->paid;
        
        $this->validate($request, [
            'paid' =>  'required|numeric|max:'.$maxPaid,

        ]);
    //payment_proof
        if($request->type_payment === "Transfer"){
            $this->validate($request, [
                'payment_proof' =>  'mimes:jpeg,jpg,png,gif|required|max:8000'
            ]);
        }
        // $request['transaction_has_modified_id'] = 1;

        $request['updated_at'] = now();
        $request['paid'] = $UserPay;

        $arrResponse = [
            'user_has_subscription.id as id',
            'transactions.expired_date',
            'transactions.status',
            'subscriptions.price',
            'users.email',
        ];

       
        $transaction = DB::table('transactions')
        ->join('user_has_subscription','transactions.user_has_subscription_id','user_has_subscription.id')
        ->join('users','user_has_subscription.user_id','users.id')
        ->join('subscriptions','user_has_subscription.subscription_id','subscriptions.id')
        ->select($arrResponse)
        ->where('transactions.id', $id)->first();

        $sisa = $transaction->price - $request->paid;

        if($sisa == 0){
            $request['status'] = \EnumTransaksi::STATUS_LUNAS;
        }else{
            $request['status'] = \EnumTransaksi::STATUS_BELUM_LUNAS;
        }
        
        if($request->status === \EnumTransaksi::STATUS_LUNAS){
           
            Transaction::create([
                'user_has_subscription_id'         => $transaction->id,
                'transaction_has_modified_id'   => 1,
                'notes'                         => '-',
                'expired_date'                  => Carbon::parse($transaction->expired_date)->addMonths(1),
                'status'                        => \EnumTransaksi::STATUS_BELUM_BAYAR,
                'price'                         => $transaction->price,
                'paid'                          => 0,
                'created_at'                    => now(),                   
            ]);
            TransactionHasModified::create([
                'user_id'               => Auth::user()->id,
                'transaction_id'        => DB::getPdo()->lastInsertId(),
                'action'                => \EnumTransaksiHasModified::CREATE
            ]);
        }

        if($transaction){

            if($transaction->status != \EnumTransaksi::STATUS_LUNAS){
                
                if($request->type_payment === "Transfer"){
                //payment_proof
                    if($request->file('payment_proof')){
                        $dir = 'payment_proof/';
                        $size = '360';
                        $format = 'file';
                        $image = $request->file('payment_proof');         
                        // $request['file'] = Storage::disk('minio')->put($image);
                        $request['file'] = \ImageUploadHelper::pushStorage($dir, $size, $format, $image);
                        
                    }
                    TransactionHasModified::create([
                        'user_id'               => Auth::user()->id,
                        'transaction_id'        => $id,
                        'action'                => \EnumTransaksiHasModified::UPDATE
                    ]);
                    $request['transaction_has_modified_id'] = DB::getPDO()->lastInsertId();

                    Transaction::where('id', $id)->update($request->only('updated_at','expired_date','transaction_has_modified_id','type_payment','notes', 'file', 'status', 'paid'));
                    TransactionHasModified::create([
                        'user_id'               => Auth::user()->id,
                        'transaction_id'        => $id,
                        'action'                => \EnumTransaksiHasModified::UPDATE
                    ]);
                    // $transaction->notify(new InvoicePaid($invoice));

                }else{
                   
                    TransactionHasModified::create([
                        'user_id'               => Auth::user()->id,
                        'transaction_id'        => $id,
                        'action'                => \EnumTransaksiHasModified::UPDATE
                    ]);
                    $request['transaction_has_modified_id'] = DB::getPDO()->lastInsertId();
                    Transaction::where('id', $id)->update($request->only('updated_at','expired_date','transaction_has_modified_id','notes','type_payment', 'status', 'paid'));
                    // $transaction->notify(new InvoicePaid($invoice));
                    // $transaction->notify(new InvoicePaid("Payment Received!"));


                    
                }    
                
            }
          
        }
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sync()
    {
        
       
        // $arrSelect = [
        //     'transactions.id as id',
        //     'users.username as name',
        //     'transactions.expired_date as expired_date',
        //     'subscriptions.name as subscription_name',
        //     'transactions.price as price',
        //     'transactions.status as status',
        //     'users.role_id'
        // ];
        // $users = DB::table('users')
        // ->join('user_has_subscription', 'users.id', '=', 'user_has_subscription.user_id')
        // ->join('subscriptions', 'user_has_subscription.subscription_id', '=', 'subscriptions.id')
        // ->join('transactions', 'user_has_subscription.id', '=', 'transactions.user_has_subscription_id')
        // ->orderBy('transactions.expired_date','desc')
        // ->select($arrSelect)
        // ->get();

        // $results = array();
        // $routers = Router::all();
        
        // foreach($routers as $key => $router){
        //     $encryptedValue = $router->password;
        //     $decrypted = Crypt::decryptString($encryptedValue);
           
        //     $client = new Client([
        //         'host' => $router->host,
        //         'port' => $router->port,
        //         'user' => $router->user,
        //         'pass' => $decrypted
        //     ]);
        //     foreach ($users as $key => $user)
        //     {
    
        //         if($user->status == \EnumTransaksi::STATUS_TENGGANG )
        //         {
        //             // Get list of all available profiles with name Block
        //             $query = new Query('/ppp/secret/print');
        //             $query->where('name', $user->name);
        //             $secrets = $client->query($query)->read();
    
        //             // Parse secrets and set password
        //             foreach ($secrets as $secret) {
    
        //                 // Change profile
        //                 $query = (new Query('/ppp/secret/set'))
        //                     ->equal('.id', $secret['.id'])
        //                     ->equal('profile', 'Block');
    
        //                 // Update query ordinary have no return
        //                 $client->query($query)->read();
        //             }
        //         } else {
        //             $query = new Query('/ppp/secret/print');
        //             $query->where('name', $user->name);
        //             $secrets = $client->query($query)->read();
    
        //             // Parse secrets and set password
        //             foreach ($secrets as $secret) {
    
        //                 // Change password
        //                 $query = (new Query('/ppp/secret/set'))
        //                     ->equal('.id', $secret['.id'])
        //                     ->equal('profile', $user->subscription_name);
    
        //                 // Update query ordinary have no return
        //                 $client->query($query)->read();
        //              };
        //          }
        //         // TransactionHasModified::create([
        //         //     'user_id'               => Auth::user()->id,
        //         //     'transaction_id'        => $id,
        //         //     'action'                => \EnumTransaksiHasModified::SYNC_DATA
        //         // ]);
        //     }    
        // }
       
        // return back();
    }
    public function destroy($id)
    {
          // menghapus data trx berdasarkan id yang dipilih
    $trx = Transaction::where('id', $id)->first();

    if (is_null($trx)){
        return 'tidak ditemukan';
    }
    //check status payment
    elseif($trx->status == \EnumTransaksi::STATUS_LUNAS){
        $dt = Carbon::now()->toDateString();
        //if date more than now set to terminated
            if($trx->expired_date < $dt){
                Transaction::where('id', $id)->update([
                    'status' => \EnumTransaksi::STATUS_TENGGANG,
                    'paid' => 0
                    ]);
                }
             
            elseif($trx->expired_date >= $dt){
                Transaction::where('id', $id)->update([
                    'status' => \EnumTransaksi::STATUS_BELUM_LUNAS,
                    'paid' => 0
                    ]);
                }
        // TransactionHasModified::create([
        //     'user_id'               => Auth::user()->id,
        //     'transaction_id'        => $id,
        //     'action'                => \EnumTransaksiHasModified::SYNC_DATA
        // ]);

    }else{
        $trx->delete();
       
    }

    }
}
