<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class ProfileController extends Controller
{

    public function index(User $user){
        Log::info($user);
        return Inertia::render('Profile/View', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' =>new UserResource($user)
        ]);
    }

    public function updateImages(Request $request){
        $data=$request->validate([
            'cover'=> 'nullable|file|mimes:jpeg,png,jpg',
            'avatar'=> 'nullable|file|mimes:jpeg,png,jpg',
        ]);

        $cover=$data['cover'] ?? null;        
        $avatar=$data['avatar'] ?? null;        
        $user=auth()->user();
        $status=null;
        if($cover){
            if($user->cover_path){
                Storage::disk('public')->delete($user->cover_path);
            }
            $path = $cover->store('covers/'.$user->id, 'public');
            $status= 'cover-image-updated';
        }
        if($avatar){
            if($user->avatar_path){
                Storage::disk('public')->delete($user->avatar_path);
            }
            $path = $avatar->store('avatars/'.$user->id, 'public');
            $user->update(['avatar_path' =>  $path ]);
            $status= 'avatar-image-updated'; 
        }
        return back()->with('status', $status);
    }
   
    /**
     * Display the user's profile form.
     */

    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return to_route('profile' ,$request->user())->with('success', 'profile details is updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
