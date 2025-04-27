<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'nama' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'alamat' => ['required', 'string'],
            'no_telp' => ['required', 'string', 'max:20'],
            'nik' => ['required', 'string', 'max:20', Rule::unique(User::class)],
            'ktp' => ['required'],
        ])->validate();

        return User::create([
            'nama' => $input['nama'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'alamat' => $input['alamat'],
            'no_telp' => $input['no_telp'],
            'nik' => $input['nik'],
            'ktp' => $input['ktp'],
        ]);
    }
}
