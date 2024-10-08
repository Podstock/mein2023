<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:4096'],
            'mastodon' => ['nullable', 'url'],
            'sendegate' => ['nullable', 'string'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $path = request()->file('photo')->store('logos', 'public');

            Storage::disk('public')->copy($path, 'big/'.$path);
            $img = Image::make(storage_path('app/public/big/'.$path));
            $img->resize(512, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save();

            Storage::disk('public')->copy($path, 'small/'.$path);
            $img = Image::make(storage_path('app/public/small/'.$path));
            $img->resize(256, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save();

            Storage::disk('public')->copy($path, 'tiny/'.$path);
            $img = Image::make(storage_path('app/public/tiny/'.$path));
            $img->resize(64, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save();

            $user->updateProfilePhoto($input['photo']);
        }

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'mastodon' => $input['mastodon'],
                'sendegate' => $input['sendegate'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
