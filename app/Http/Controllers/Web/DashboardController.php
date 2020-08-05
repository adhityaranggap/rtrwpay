<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User, App\Role, App\Transaction, App\Ticket, App\Package;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        $customercount = User::all()->where('role_id', ROLE::ROLE_WARGA)->count();
        $lunascount = Transaction::all()->where('status', \EnumTransaksi::STATUS_LUNAS)->count();
        $ticketcount = Ticket::all()->where('status', \EnumTicket::STATUS_OPEN)->count();
        // $telatcount = Transaction::all()->where('status', \EnumTransaksi::STATUS_LUNAS)->count();
        $telatcount = Transaction::all()->where('status', \EnumTransaksi::STATUS_TENGGANG)->count();
        
        // $data = Transaction::where('type_payment', '!=', '')->orderBy('created_at','desc')->take(5)->get();
        $arrSelect = [
            'users.username as name',
            'transactions.expired_date as expired_date',
            'subscription.name as subscription_name',
            'transactions.paid as paid',
            'transactions.id as id',
            'transactions.status as status',
            'transactions.updated_at as updated_at',
            'users.role_id'
        ];
        // $data = transaction::all();
        $trxrecent = DB::table('users')
        ->join('user_has_subscription', 'users.id', '=', 'user_has_subscription.user_id')
        ->join('subscription', 'user_has_subscription.subscription_id', '=', 'subscription.id')
        ->join('transactions', 'user_has_subscription.id', '=', 'transactions.users_has_packages_id')
        ->where('transactions.type_payment', '!=', '')
        ->orderBy('transactions.updated_at','desc')
        ->select($arrSelect)
        ->take(5)
        ->get();
        // Count Package Usage
        $subscription= Package::all();
        $allpackageorders = DB::table('user_has_subscription')->get();

        $total = $allpackageorders->count();
        foreach($subscription as $key => $package){
            $countThisPackage = 0;

            foreach($allpackageorders as $keyChild => $packageOrder){

                if($packageOrder->subscription_id == $package->id){
                    $countThisPackage +=1;
                }
            }

            $results[$package->id] = [
                'name'  =>  $package->name,
                'percent'  =>  round($countThisPackage/$total * 100,2),
                'total'  =>  ($countThisPackage)
            ];
        }
        $arrSelect = [
            'users.username as name',
            'subscription.name as subscription_name',
            'user_has_subscription.updated_at as updated_at'
          

        ];
        $packagerecent = DB::table('users')
        ->join('user_has_subscription', 'users.id', '=', 'user_has_subscription.user_id')
        ->join('subscription', 'user_has_subscription.subscription_id', '=', 'subscription.id')
        ->join('transactions', 'user_has_subscription.id', '=', 'transactions.users_has_packages_id')
        ->orderBy('user_has_subscription.updated_at','desc')
        ->select($arrSelect)
        ->take(3)
        ->get();
        // return $trxrecent;
        // return $results;
        return view('cms.dashboard.index', compact ('packagerecent','results','trxrecent','customercount','lunascount','ticketcount','telatcount'));
    }
    public function chart()
    {
        // return phpinfo();
        // $result = Transaction::all();
        // return response()->json($result);
    }
}
