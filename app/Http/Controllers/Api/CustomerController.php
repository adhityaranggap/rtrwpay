<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //validate
use App\User;


class CustomerController extends Controller
{
    public function fetchAllCustomers(){
        // return -data All Array Role Customer
        $users = User::paginate(25);


        return response()->json([
            'message'   =>  $users->count(). ' Data user ditemukan pada halaman ini',
            'code'      =>  \HttpStatus::OK,
            'data'      =>  $users
        ], \HttpStatus::OK);
    }
    public function create (Request $request)
    {
           //start validate
           $rules = [
            'username'       => 'required|max:50',
            'address'        => 'required|max:100',
            'name'           => 'required|max:50', 
            'password'       => 'required|min:8', 
            'email'          => 'required|email', 
            'contact_person' => 'required',
            'role_id'        => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return  \MessageHelper::unprocessableEntity($validator->messages());
        }
        //end validate
        $data = User::create($request->all());

        return response()->json([
            'message'   =>  $request->username. ' Data berhasil masuk',
            'code'      =>  \HttpStatus::OK,
            'data'      =>  $data
        ], \HttpStatus::OK);   
    }
    public function update (Request $request, $username)
    {        
                //start validate
                   $rules = [
                    'username'       => 'required|max:50',
                    'address'        => 'required|max:100',
                    'name'           => 'required|max:50', 
                    'password'       => 'required|min:8', 
                    'email'          => 'required|email', 
                    'contact_person' => 'required',
                    'role_id'        => 'required|integer'
                ];
        
                $validator = Validator::make($request->all(), $rules);
        
                if ($validator->fails()) {
                    return  \MessageHelper::unprocessableEntity($validator->messages());
                }
                //end validate

        $data = User::where('username', $username)->first();
        
        if($data)
        {
            User::where('username', $username)->update($request->except('username'));
            return response()->json([
                'message'   =>  $request->username. ' Data berhasil update',
                'code'      =>  \HttpStatus::OK,
                'data'      => $data
            ], 200); 
        }else{
            return response()->json([
                'message'   =>  $request->username. ' Data tidak ditemukan',
                'code'      =>  \HttpStatus::NOT_FOUND
            ], 404); 
        }

    }
    public function delete ($username)
    {
        $data = User::where('username', $username)->first();
        if($data){
            $data->delete();
            return response()->json([
                'message'   =>  $username. ' Data berhasil dihapus',
                'code'      =>  \HttpStatus::OK,
                'data'      => $data       
            ], 200); 
        }else{
            return response()->json([
                'message'   =>  $username. ' Data tidak ditemukan',
                'code'      =>  \HttpStatus::NOT_FOUND
            ], 404); 
        }
    }
}
