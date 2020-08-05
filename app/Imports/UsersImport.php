<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'username' => $row [1], 
            'name'=> $row [2], 
            'password' => $row [3], 
            'email'=> $row [4], 
            'contact_person'=> $row [5],
            'address'=> $row [6], 
            'role_id' => 1 
        ]);
    }
}
