<?php

namespace App\Http\Controllers;
use App\Social;
use Socialite;
use App\Customer;
use App\Customer_Info;
use Session;
use Illuminate\Http\Request;

class LoginSocialController extends Controller
{

    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->stateless()->user();
        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
        if($account){
            $account_name = Customer::where('customer_id',$account->user)->first();
            Session::put('username',$account_name->username);
            Session::put('customer_id',$account_name->customer_id);
            return redirect('/');
        }else{

            $login_customer_new = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Customer::where('email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Customer::create([
                    'username' => $provider->name,
                    'email' => $provider->email,
                    'password' => '',
                ]);
                $customer_info = Customer_Info::Create([
                    'customer_id' => $orang->customer_id,
                    'customer_fullname' => '',
                    'customer_phone' => '',
                    'customer_avt' => 'user.png',
                    'customer_gender' => '',
                    'customer_birthday' => '2000-01-01',
                ]);
                $customer_info->save();
            }
            $login_customer_new->login()->associate($orang);
            $login_customer_new->save();

            $account_name = Customer::where('customer_id', $login_customer_new->user)->first();

            Session::put('username',$account_name->username);
            Session::put('customer_id',$account_name->customer_id);
            return redirect('/');
        }
    }



    public function login_google(){
        return Socialite::driver('google')->redirect();
    }
    public function callback_google(){
        $users = Socialite::driver('google')->stateless()->user();
        $authUser = $this->findOrCreateUser($users,'google');
        if($authUser){
            $account_name = Customer::where('customer_id',$authUser->user)->first();
            Session::put('username',$account_name->username);
            Session::put('customer_id',$account_name->customer_id);
        }
        elseif($login_customer_new){
            $account_name = Customer::where('customer_id',$authUser->user)->first();
            Session::put('username',$account_name->username);
            Session::put('customer_id',$account_name->customer_id);
        }
        return redirect('/');


    }
    public function findOrCreateUser($users,$provider){
        $authUser = Social::where('provider_user_id', $users->id)->first();
        if($authUser){

            return $authUser;
        }
        else{
            $login_customer_new = new Social([
                'provider_user_id' => $users->id,
                'provider' => strtoupper($provider)
            ]);

            $orang = Customer::where('email',$users->email)->first();
                if(!$orang){
                    $orang = Customer::create([
                        'username' => $users->name,
                        'email' => $users->email,
                        'password' => '',
                    ]);
                    $customer_info = Customer_Info::Create([
                        'customer_id' => $orang->customer_id,
                        'customer_fullname' => '',
                        'customer_phone' => '',
                        'customer_avt' => 'user.png',
                        'customer_gender' => '',
                        'customer_birthday' => '2000-01-01',
                    ]);
                    $customer_info->save();
                }
            $login_customer_new->login()->associate($orang);
            $login_customer_new->save();


            return $login_customer_new;
        }
    }
}
