<?php


use Illuminate\Database\Seeder;
use App\UserHasSubscription;

class UserHasSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        //faker
        $faker = Faker\Factory::create();                      
        for($i=0 ; $i<=100; $i++){   
            // $user_id = $i;

            UserHasSubscription::create([
                'user_id'          =>  $i,
                'subscription_id'  =>  1,
                'status'           =>  'Active',
                'notes'            =>  '.',
            ]);

        }    
    }
}
