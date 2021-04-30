<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        return response()->json(['message'=>'all users data received','data'=>$users],200);
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
        $rules=[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ];

        $this->validate($request,$rules);

        $data=$request->all();
       
        $data['password']=bcrypt($request->password);
        $data['verified']=User::UNVERIFIED;
        $data['verification_token']=User::generateVerificationCode();
        $data['admin']=User::REGULAR_USER;
        
        $user=User::create($data);


        return response()->json(['message'=>'user created successfully','data'=>$user],201);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::findorFail($id);
        return response()->json(['message'=>'user data received','data'=>$user],200);
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
        $user=User::findOrFail($id);

        $rules=[
          
            'email'=>'required|email|unique:users,email,'.$user->id,
            'password'=>'required|min:6|confirmed',
            'admin'=>'in:'.User::ADMIN_USER.','.User::REGULAR_USER, 
        ];

        if($request->has('name')){
            $user->name=$request->name;
        }

        
        if($request->has('email') && $user->email!=$request->email){
            $user->verified=User::UNVERIFIED;
            $user->verification_token=User::generateVerificationcode();
            $user->email=$request->email;
         }

         if($request->has('password')){
            $user->password=becrypt($request->password);
         }
    
         if(!$user->isDirty()){

            return response()->json(['message'=>'you need to 
            specify a diffirent value to update','data'=>$user],422);
         }

        $user->save();

        return response()->json(['message'=>'user updated successfully','data'=>$user],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::findOrFail($id);
        $user->delete();
        return response()->json(['message'=>'user deleted','data'=>$user],200);
        
    }
}
