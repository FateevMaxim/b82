<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required'],
            'password' => ['required', 'confirmed'],
        ]);

        if ($request['current_password'] == Auth::user()['password']){
            $request->user()->update([
                'password' => $validated['password'],
            ]);
            return back()->with('status', 'password-updated');
        }
        return back()->with('error', 'password-notupdated');
    }
}
