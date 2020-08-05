<?php

use Illuminate\Database\Seeder;
use App\Subscription;
class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           $arrSubsc =[
          [
            'name'      =>  'IPL',
            'price'     =>  100000
          ]        
        ];

        foreach($arrSubsc as $subsc){
            Subscription::create($subsc);
        }
    }
}
