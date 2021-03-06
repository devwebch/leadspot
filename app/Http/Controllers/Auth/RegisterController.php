<?php

namespace App\Http\Controllers\Auth;

use App\Notifications\NewMessage;
use App\Notifications\NewUser;
use App\SubscriptionsUsage;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\Welcome;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
            'first_name'    => 'required|max:255',
            'last_name'     => 'required|max:255',
            'email'         => 'required|email|max:255|unique:users',
            'password'      => 'required|min:6|confirmed',
            'terms_agree'   => 'required'
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
        $user = User::create([
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'email'         => $data['email'],
            'password'      => bcrypt($data['password']),
            'company'       => ''
        ]);

        $admin  = User::find(1);

        // create a subscription usage entry for this new user
        $default_quotas = [
            'search'    => ['limit' => config('subscriptions.free.limit.search'), 'used' => 0],
            'contacts'  => ['limit' => config('subscriptions.free.limit.contacts'), 'used' => 0]
        ];
        $default_quotas = json_encode($default_quotas);

        $usage = new SubscriptionsUsage();
        $usage->user_id     = $user->id;
        $usage->limit       = 0;
        $usage->used        = 0;
        $usage->quotas      = $default_quotas;

        $usage->save();

        // send notification to user
        $user->notify(new Welcome($user));
        $admin->notify(new NewUser($user));

        return $user;
    }
}
