<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Image;

class UserService
{
    private function cropImage($file)
    {
        Image::make($file)->crop(70, 70)->save($file);
    }

    private function tinypngCompress($file)
    {
        \Tinify\setKey(config('app.tinypng_api_key'));
        \Tinify\fromFile($file)->toFile($file);
    }

    public function create($request)
    {
        $validated = $request->validated();
        $faker = \Faker\Factory::create();
        $user = User::create($validated + ['password' => bcrypt($faker->password())]);
        if ($request->hasFile('photo')) {
            $photo = $request->photo->store('images/users');
            $this->cropImage(public_path($photo));
            $this->tinypngCompress(public_path($photo));
            $user->update(['photo' => Str::after($photo, 'images/users/')]);
        }
        return $user;
    }
}
