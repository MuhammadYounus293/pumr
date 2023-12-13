<?php

namespace App\Http\Controllers\Social\google;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationSendController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Notifications\NewUserRegister;
use Stripe\Stripe;
use Stripe\Customer;

class GoogleAuthController extends Controller
{
    //
    protected $pushnotification;

    public function __construct(NotificationSendController $pushnotification)
    {
        $this->pushnotification = $pushnotification;
    }

    public function redirectToGoogle()
    {
        // return "123";
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
       
            $user = Socialite::driver('google')->user();

            //  return $user->email;

            $existingUser = User::where('email', $user->email)->first();
            // return $existingUser;

            if ($existingUser) {
                // If the user already exists, log them in
                Auth::login($existingUser);
                 
                  if($existingUser->google_id == null){
                      
                      $existingUser->google_id = $user->id;
                      $existingUser->save();
                  }
                
                return redirect('/home');
            } else {

                Stripe::setApiKey(config('services.stripe.secret'));

                    // Create a new customer
                    $customer = Customer::create([
                        'email' => $user->email,
                        'name' => $user->name, // Provide the customer's email address
                        // Add additional customer data if needed
                    ]);
        
              

                // return $customer;
                // If the user doesn't exist, create a new user
                $newUser = new User();
                $newUser->name = $user->name;
                $newUser->email = $user->email;
                $newUser->google_id = $user->id; // Store the Google ID for future logins
                $newUser->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password
                $newUser->role = "Customer";
                $newUser->stripe_id = $customer->id;
                $newUser->save();

                Auth::login($newUser);
		        $admin = User::where('id',1)->first();
		        $admin->notify(new NewUserRegister($newUser));
                $this->pushnotification->sendNotification();
                // Redirect the user to a dashboard or home page
                return redirect('/home');
            }
       
    }
}
