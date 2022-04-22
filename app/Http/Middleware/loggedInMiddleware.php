<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use App\Site;
class loggedInMiddleware
{
    public $site;
    public $wallet_balance;
    public $roles;
    public $user;
    function __construct()
    {
        $this->site = new Site();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->session()->has('email')){
            return redirect('/login');
        }

        $user_id = session()->get('user_id');
        $this->wallet_balance = $this->site->getWalletBalanceByUserId($user_id);
        \Session::put('wallet_balance', $this->wallet_balance);
        $this->roles = $this->site->getUserTypeByUserId($user_id);
        \Session::put('roles', $this->roles);
        $this->user= $this->site->getUserByid($user_id);
        \Session::put('user', $this->user);

        return $next($request);
    }
}
