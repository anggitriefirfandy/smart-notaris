<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ProfilePictureMiddleware
{
    public function handle($request, Closure $next)
    {
        $user           = Auth::user();
        $profilePicture = asset('assets/img/profiles/avatar-02.jpg'); // Default avatar

        if ($user) {
            if ($user->role_id == 2 && $user->notaris) {
                $profilePicture = $user->notaris->picture ? asset('image/' . $user->notaris->picture) : $profilePicture;
            } elseif ($user->role_id == 1 && $user->bank) {
                $profilePicture = $user->bank->picture ? asset('image/' . $user->bank->picture) : $profilePicture;
            }
        }
        // dd($profilePicture);

        view()->share('profilePicture', $profilePicture);
        return $next($request);
    }
}
