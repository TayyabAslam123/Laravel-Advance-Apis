<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use Notifiable , SoftDeletes;
    protected $dates=['deleted_at'];

    const VERIFIED='1';
    const UNVERIFIED='0';

    const ADMIN_USER='true';
    const REGULAR_USER='false'; 

    protected $table='users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email',
        'password',
        'verified',
        'verification_token',
        'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
        'verification_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    ##MUTATORS
    public function setNameAttribute($name){
        $this->attributes['name'] = "ASPIRE:".$name;
     }  

    public function setEmailAttribute($email){
        $this->attributes['email'] = strtolower($email);
     }  

    ##ACCESSOR
    public function getNameAttribute($name){
        return strtoupper($name);
    }
  
    public function getEmailAttribute($email){
        return "mailto:".$email;
    }

    #####################################################################################################
    public function isVerified(){
         $this->verified==User::VERIFIED;
    }
   public function isAdmin(){
         $this->admin==User::ADMIN_USER;
    }
    //verification code
    public static function generateVerificationcode(){
        //return str_random(40);
        return Str::random(40);
    }

}
