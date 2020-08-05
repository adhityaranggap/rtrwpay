<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrRole =[
            [
              'role'  =>  'Warga',                           
            ],
            [
              'role'  =>  'Billing',                           
            ],
            [
              'role'  =>  'Admin',                           
            ]
          ];
    
          foreach($arrRole as $role){
              Role::create($role);
          }
    }
}
