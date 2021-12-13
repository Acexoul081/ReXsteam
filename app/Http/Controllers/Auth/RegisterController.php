<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
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
            'fullname' => ['required', 'string'],
            'username' => ['required', 'string', 'min:6', 'unique:users'],
            'password' => ['required', 'string', 'min:6',
                function ($attribute, $value, $fail){
                    $isalpha = false;
                    $isnum = false;
                    $arrchar = str_split($value);
                    foreach ($arrchar as $char){
                        if (ctype_alpha($char)){
                            $isalpha = true;
                        }
                        else if (ctype_digit($char)){
                            $isnum = true;
                        }
                        else{
                            $fail("The ".$attribute." must be Alphanumeric");
                        }
                    }
                    if(!$isalpha || !$isnum){
                        $fail("The ".$attribute." must be Alphanumeric");
                    }
                }
            ],
            'role' => ['required', 'string',
                function ($attribute, $value, $fail){
                    if ($value !== 'Member' && $value !== 'Admin'){
                        $fail("The ".$attribute." must be Member or Admin");
                    }
                }
            ],
            
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'fullname' => $data['fullname'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);
    }
}
