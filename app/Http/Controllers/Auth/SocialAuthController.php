<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Events\RegistrationReferrerBonus;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\MainSetting;
use App\Models\User;
use Exception;

class SocialAuthController extends Controller
{   
    /**
     * Login with social OAuth feature
     * 
     */
    public function redirectToProvider($driver)
    {      
        return Socialite::driver($driver)->redirect();
    }


    public function handleProviderCallback(Request $request, $driver)
    {
        try {
     
            $user = Socialite::driver($driver)->user();

            $existing_user = User::where('oauth_id', $user->getId())->first();
      
            if ($existing_user) {
      
                Auth::login($existing_user, true);
     
                //return redirect()->route('user.dashboard');
                            return redirect()->to('https://a2chub.com/user/chats/custom/asst_Kan6u7rYewcIeEryv75i3nsa');

      
            } else {

                $check_user = User::where('email', $user->getEmail())->first();

                if ($check_user) {
                    $check_user->oauth_id = $user->getId();
                    $check_user->oauth_type = $driver;
                    $check_user->save(); 
                    Auth::login($check_user, true);

                   // return redirect()->route('user.dashboard');
                                return redirect()->to('https://a2chub.com/user/chats/custom/asst_Kan6u7rYewcIeEryv75i3nsa');

                    
                    
                } else {
                    $new_user = User::create([
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'oauth_id'=> $user->getId(),
                        'oauth_type'=> $driver,                    
                        'country'=> config('settings.default_country'),                    
                        'password' => Hash::make($user->getEmail()."-".rand(1000,10000)),
                    ]);
    
                    event(new Registered($new_user));
                    $settings = MainSetting::first();
    
                    $referral_code = ($request->hasCookie('referral')) ? $request->cookie('referral') : ''; 
                    $referrer = ($referral_code != '') ? User::where('referral_id', $referral_code)->firstOrFail() : '';
                    $referrer_id = ($referrer != '') ? $referrer->id : '';
            
                    $new_user->assignRole(config('settings.default_user'));
                    $new_user->status = 'active';
                    $new_user->group = config('settings.default_user');
                    $new_user->email_verified_at = now();
                    $new_user->gpt_3_turbo_credits = config('settings.free_gpt_3_turbo_credits');
                    $new_user->gpt_4_turbo_credits = config('settings.free_gpt_4_turbo_credits');
                    $new_user->gpt_4_credits = config('settings.free_gpt_4_credits');
                    $new_user->gpt_4o_credits = config('settings.free_gpt_4o_credits');
                    $new_user->gpt_4o_mini_credits = $settings->gpt_4o_mini_credits ?? 0;
                    $new_user->fine_tune_credits = config('settings.free_fine_tune_credits');
                    $new_user->claude_3_opus_credits = config('settings.free_claude_3_opus_credits');
                    $new_user->claude_3_sonnet_credits = config('settings.free_claude_3_sonnet_credits');
                    $new_user->claude_3_haiku_credits = config('settings.free_claude_3_haiku_credits');
                    $new_user->gemini_pro_credits = config('settings.free_gemini_pro_credits');
                    $new_user->available_dalle_images = config('settings.free_tier_dalle_images');
                    $new_user->available_sd_images = config('settings.free_tier_sd_images');
                    $new_user->available_chars = config('settings.voiceover_welcome_chars');
                    $new_user->available_minutes = config('settings.whisper_welcome_minutes');
                    $new_user->default_voiceover_language = config('settings.voiceover_default_language');
                    $new_user->default_voiceover_voice = config('settings.voiceover_default_voice');
                    $new_user->default_template_language = config('settings.default_language');
                    $new_user->default_model_template = config('settings.default_model_user_template');
                    $new_user->default_model_chat = config('settings.default_model_user_bot');
                    $new_user->job_role = 'Happy Person';
                    $new_user->referral_id = strtoupper(Str::random(15));
                    $new_user->referred_by = $referrer_id;
                    $new_user->save();  

                    toastr()->success(__('Congratulations! Your account is activated successfully.'));

                    Auth::login($new_user, true);

                  //  return redirect()->route('user.dashboard');
                                return redirect()->to('https://a2chub.com/user/chats/custom/asst_Kan6u7rYewcIeEryv75i3nsa');

                    
                } 
                
            }
     
        } catch (Exception $e) {
            toastr()->error(__('Login with your social media account has failed, try again or register with email'));
            return redirect()->route('login');
        }
    }

}