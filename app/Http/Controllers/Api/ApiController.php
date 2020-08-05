<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class ApiController extends Controller
{
    public function fetchAllUnpaid(){
        // return -data array transaction unpaid
    }

    public function fetchAllCustomers(){
        // return -data All Array Role Customer
        $users = User::all();

        return response()->json([
            'message'   =>  $users->count(). ' Data user ditemukan',
            'code'      =>  200,
            'data'      =>  $users
        ], 200);
    }

    public function destroyReview($review_id)
    {
    
    }
}
