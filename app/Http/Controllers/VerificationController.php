<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        // Check if the user is already verified
        if ($user->hasVerifiedEmail()) {
            return redirect('/profile')->with('message', 'Email already verified');
        }
    
        // Check if the hash matches
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect('/email/verify-failed')->withErrors(['message' => 'Invalid verification link']);
        }
        return redirect('/profile');
    }
}
