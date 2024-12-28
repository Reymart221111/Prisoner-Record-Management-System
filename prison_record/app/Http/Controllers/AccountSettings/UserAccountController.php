<?php

namespace App\Http\Controllers\AccountSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;  // Add this for GD driver

class UserAccountController extends Controller
{
    public function showUpdateAccountPage()
    {
        return view('contents.account_settings.update-account-settings');
    }
    public function showUpdateImgPage()
    {
        return view('contents.account_settings.updateUserImage');
    }

    public function showUpdatePasswordPage()
    {
        return view('contents.account_settings.update-password-settings');
    }

    public function updateProfileImage(Request $request)
    {
        try {
            $request->validate([
                'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $user = Auth::user();
            $oldImagePath = $user->imgPath;

            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $filename = 'profile-' . $user->id . '-' . time() . '.' . $image->getClientOriginalExtension();

                // Create new ImageManager instance with desired driver
                $manager = new ImageManager(new Driver());

                // Read image from path
                $img = $manager->read($image->getRealPath());

                // Resize image
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $path = 'uploads/profile-images/';
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->makeDirectory($path);
                }

                // Save the processed image
                Storage::disk('public')->put(
                    $path . $filename,
                    $img->toJpeg()->toString()  // or toPng() depending on your needs
                );

                $user->imgPath = $path . $filename;
                $user->save();

                if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }

                return redirect()->back()->with('success', 'Profile image updated successfully!');
            }

            return redirect()->back()->with('error', 'No image file uploaded.');
        } catch (\Exception $e) {
            if (isset($path) && isset($filename) && Storage::disk('public')->exists($path . $filename)) {
                Storage::disk('public')->delete($path . $filename);
            }

            Log::error('Profile Image Upload Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while updating your profile image. Please try again.')
                ->withInput();
        }
    }
}
