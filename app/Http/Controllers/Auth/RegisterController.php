<?php

namespace App\Http\Controllers\Auth;
use Session;
use Mail;
use App\User;
use App\VerifyUser;
use App\Mail\VerifyMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected function redirectTo()
    {
            // Add a mail has been sent text under title
        Session::flash('success', array('Successfully regsitered!'=>'Thanks for registering to our website.', 'Check verification mail!'=>'A mail has been sent to your address. Please check the mail and varify your account.'));
        return route('user.userinfo');
    }

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
        $messages = [
            'condition.required' => 'You have to agree with the terms and conditions!',
        ];

        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users',
            'email' => 'required|string|email|max:50|unique:users',
            'contact' => 'required|string|max:20|min:17|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'condition' => 'required',
        ],
        $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'role' => 3,
            'email' => $data['email'],
            'contact' => $data['contact'],
            'password' => Hash::make($data['password']),
        ]);
 
        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(40)
        ]);
 
        // Mail::to($user->email)->send(new VerifyMail($user));
 
        return $user;
    }
}
