<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * Show the form for editing the authenticated admin's profile.
     */
    public function edit()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.settings', compact('admin'));
    }

    /**
     * Update the authenticated admin's profile information.
     */
    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'first_name'            => 'required|string|max:100',
            'last_name'             => 'required|string|max:100',
            'email'                 => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('admins', 'email')->ignore($admin->id),
            ],
            'password'              => 'nullable|string|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $admin->first_name = $validated['first_name'];
            $admin->last_name  = $validated['last_name'];
            $admin->email      = $validated['email'];

            if (!empty($validated['password'])) {
                $admin->password_hash = Hash::make($validated['password']);
            }

            $admin->save();
            DB::commit();

            return redirect()
                ->route('admin.settings.edit')
                ->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update profile: ' . $e->getMessage()]);
        }
    }
}