<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use DB;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->stateless()->user();

            $finduser = User::where('google_id', $user->id)->first();

            $duplicateuser = User::where('email', $user->email)->first();


            if($finduser){

                Auth::login($finduser);

                return redirect()->intended('dashboard');

            }else{
                if($duplicateuser) {
                    return redirect()->back();
                } else {
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'google_id'=> $user->id,
                        'password' => encrypt('User@123$')
                    ]);

                    $finduser = User::where('google_id', $user->id)->first();

                    Team::forceCreate([
                        'user_id' => $finduser->id,
                        'name' => explode(' ', $user->name, 2)[0]."'s Team",
                        'personal_team' => true,
                    ]);

                    Auth::login($newUser);

                    return redirect()->intended('dashboard');
                }
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
