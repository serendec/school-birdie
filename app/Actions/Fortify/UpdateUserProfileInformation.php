<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'family_name'      => ['required', 'string', 'max:255'],
            'first_name'       => ['required', 'string', 'max:255'],
            'family_name_kana' => ['required', 'string', 'max:255'],
            'first_name_kana'  => ['required', 'string', 'max:255'],
            'email'            => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ])->validateWithBag('updateProfileInformation');

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'family_name'      => $input['family_name'],
                'first_name'       => $input['first_name'],
                'family_name_kana' => $input['family_name_kana'],
                'first_name_kana'  => $input['first_name_kana'],
                'email'            => $input['email'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'family_name'       => $input['family_name'],
            'first_name'        => $input['first_name'],
            'family_name_kana'  => $input['family_name_kana'],
            'first_name_kana'   => $input['first_name_kana'],
            'email'             => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
