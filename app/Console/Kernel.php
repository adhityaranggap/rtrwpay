<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use \RouterOS\Client;
use App\Router, App\Transaction;
use \RouterOS\Query;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function() {

       
            $arrSelect = [
                'transactions.id as id',
                'users.username as name',
                'transactions.expired_date as expired_date',
                'subscription.name as subscription_name',
                'transactions.price as price',
                'transactions.status as status',
                'users.role_id'
            ];
            $users = DB::table('users')
            ->join('user_has_subscription', 'users.id', '=', 'user_has_subscription.user_id')
            ->join('subscription', 'user_has_subscription.subscription_id', '=', 'subscription.id')
            ->join('transactions', 'user_has_subscription.id', '=', 'transactions.users_has_packages_id')
            ->orderBy('transactions.expired_date','desc')
            ->select($arrSelect)
            ->get();
            $results = array();
            $router = Router::all()
            ->where('router_name', 'VPN-Server')
            ->first();
            
            $encryptedValue = $router->password;
            $decrypted = Crypt::decryptString($encryptedValue);
           
            $client = new Client([
                'host' => $router->host,
                'port' => $router->port,
                'user' => $router->user,
                'pass' => $decrypted
            ]);
            foreach ($users as $key => $user)
            {
  
                if($user->status == \EnumTransaksi::STATUS_TENGGANG )
                {
                    // Get list of all available profiles with name Block
                    $query = new Query('/ppp/secret/print');
                    $query->where('name', $user->name);
                    $secrets = $client->query($query)->read();
    
                    // Parse secrets and set password
                    foreach ($secrets as $secret) {
    
                        // Change password
                        $query = (new Query('/ppp/secret/set'))
                            ->equal('.id', $secret['.id'])
                            ->equal('profile', 'Block');
    
                        // Update query ordinary have no return
                        $client->query($query)->read();
                    }
                } else {
                    $query = new Query('/ppp/secret/print');
                    $query->where('name', $user->name);
                    $secrets = $client->query($query)->read();
    
                    // Parse secrets and set password
                    foreach ($secrets as $secret) {
    
                        // Change password
                        $query = (new Query('/ppp/secret/set'))
                            ->equal('.id', $secret['.id'])
                            ->equal('profile', 'default');
    
                        // Update query ordinary have no return
                        $client->query($query)->read();
                     };
                 }
            }    
        })->everyYear();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
