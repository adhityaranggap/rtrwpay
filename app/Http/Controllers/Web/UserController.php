<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Auth;

use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('for') && $request->for === 'password'){
            return 'ini view password';
        }
        $id = auth()->user()->id;
        $user = User::where('id', $id)->first();
        return view('cms.profile.index', compact ('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        $user = Auth::user();
        $this->validate($request,[
   	'username'       => 'required|max:50',
            'address'        => 'required|max:100',
            'name'           => 'required|max:50', 
            'oldPassword'    => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!\Hash::check($value, $user->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'password'       => 'min:6|same:passwordConfirmation|different:oldpassword',

            'passwordConfirmation' => 'min:6',
            'email'          => 'required|email', 
            'contact_person' => 'required', 
        ]);
        
        if($user)
        {
            $request['password'] = bcrypt(request('password'));
            User::where('id', $id)
            ->update($request->except('_token', 'oldPassword', 'passwordConfirmation'));
            return "Data Berhasil di Update";

        }else{
            return false;
        }


       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
