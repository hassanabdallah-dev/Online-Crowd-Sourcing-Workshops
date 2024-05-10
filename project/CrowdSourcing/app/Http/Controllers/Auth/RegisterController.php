<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Role;
use App\Preferences;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function verified($verification){
        if($verification)
            return NULL;
        return now();
    }
    protected function create(array $data)
    {
        $validation = Preferences::where('name','validation')->first()->enable;
        $verification = Preferences::where('name','email-verification')->first()->enable;
        $role = Preferences::where('name','role')->get()->first()->enable;
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'activated' => !$validation,
            'email_verified_at' => $this->verified($verification),
            'password' => Hash::make($data['password']),
        ]);
        if(!$role)
            $part = Role::where('name', 'participant')->get()->first();
        else{
            $part = Role::where('name', isset($data['role'])?$data['role']:'participant')->get()->first();
        }
        $user->roles()->attach($part);
        if($user->hasRole('admin')){
            $user->email_verified_at = now();
        }
        //$user->notify(new \App\Notifications\Users\VerifyEmailNotification($user));
        return $user;
    }
}
