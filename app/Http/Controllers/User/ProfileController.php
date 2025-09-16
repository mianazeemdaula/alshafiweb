<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        // Calculate user stats
        $stats = [
            'total_orders' => $user->orders()->count(),
            'total_spent' => $user->orders()->where('status', 'completed')->sum('total'), // Keep as rupees
            'total_reviews' => $user->productReviews()->count(),
            'days_member' => $user->created_at->diffInDays(now()),
        ];
        
        return view('user.profile.show', compact('user', 'stats'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'mobile' => 'nullable|string|max:18',
            'current_password' => 'required',
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ]);

        return redirect()->route('user.profile.show')->with('success', 'Profile updated successfully!');
    }

    public function changePassword()
    {
        return view('user.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('user.profile.show')->with('success', 'Password updated successfully!');
    }
}
