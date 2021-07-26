<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
    protected $redirectTo = '/register';

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
            'office' => 'required|max:100',
            'full_name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'same:password'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'office' => $data['office'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'is_active' => 1,
            'password' => Hash::make($data['password']),
            'created_at' => date("Y-m-d H:i:s"),
        ]);
    }

    /**
     * Override default registration form method from RegistersUsers trait
     *
     * @param array $request
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Override default post register method 
     * from RegistersUsers trait
     *
     * @param array $request
     */
    public function register(Request $request)
    {
        // validate details
        if ($this->validator($request->all())->fails()) {
            return redirect('register')
                ->withInput()
                ->withErrors($this->validator($request->all()));
        }

        // create new user
        $created = $this->create($request->all());

        // check if new user is created
        if ($created) {
            return view('auth.register')
                ->with([
                    'msg' => "You've successfully registered a user."
                ]);
        } else {
            return "Error. Cauld not register new user.";
        }
    }
}
