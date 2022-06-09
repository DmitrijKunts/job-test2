<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserControllerTest extends TestCase
{
    use WithFaker;

    private static $token;

    public function test_users()
    {
        $this->get('/api/v1/users')
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->get('/api/v1/users?page=0&count=0')
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validation failed',
            ])
            ->assertJsonPath('fails.page', fn ($name) => $name != '')
            ->assertJsonPath('fails.count', fn ($name) => $name != '');

        $this->get('/api/v1/users?page=999')
            ->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Page not found',
            ]);
    }

    public function test_get_user()
    {
        $user = User::find(1);
        $this->get('/api/v1/users/1')
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonPath('user.email', $user->email);

        $this->get('/api/v1/users/dfsdfd')
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Validation failed',
            ])
            ->assertJsonPath('fails.id', fn ($name) => $name != '');

        $this->get('/api/v1/users/999')
            ->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'The user with the requested identifier does not exist',
            ])
            ->assertJsonPath('fails.user_id', fn ($name) => $name != '');
    }

    // public function test_post_user()
    // {
    //     $this->post('/api/v1/users')
    //         ->assertStatus(409)
    //         ->assertJson([
    //             'success' => false,
    //             'message' => 'The token expired.',
    //         ]);

    //     $response = $this->get('/api/v1/token');
    //     self::$token = $response['token'];

    //     $this->withToken(self::$token)->post('/api/v1/users')
    //         ->assertStatus(422)
    //         ->assertJson([
    //             'success' => false,
    //             'message' => 'Validation failed',
    //         ])
    //         ->assertJsonPath('fails.name', fn ($name) => $name != '')
    //         ->assertJsonPath('fails.email', fn ($name) => $name != '')
    //         ->assertJsonPath('fails.phone', fn ($name) => $name != '')
    //         ->assertJsonPath('fails.position_id', fn ($name) => $name != '')
    //         ->assertJsonPath('fails.photo', fn ($name) => $name != '');

    //     Storage::fake('avatars');
    //     $avatar = UploadedFile::fake()->image('avatar.jpg', 100, 100);

    //     $response = $this->withToken(self::$token)->post('/api/v1/users', [
    //         'name' => $this->faker()->name(),
    //         'email' => $this->faker()->safeEmail(),
    //         'phone' => $this->faker()->numerify('+380#########'),
    //         'position_id' => $this->faker()->numberBetween(1, 4),
    //         'photo' => $avatar,
    //     ])->assertStatus(200)
    //         ->assertJson([
    //             'success' => true,
    //             'message' => 'New user successfully registered',
    //         ])
    //         ->assertJsonPath('user_id', fn ($val) => is_int($val));
    // }

    public function test_post_user_with_old_token()
    {
        Storage::fake('avatars');
        $avatar = UploadedFile::fake()->image('avatar.jpg', 100, 100);

        $response = $this->withToken(self::$token)->post('/api/v1/users', [
            'name' => $this->faker()->name(),
            'email' => $this->faker()->safeEmail(),
            'phone' => $this->faker()->numerify('+380#########'),
            'position_id' => $this->faker()->numberBetween(1, 4),
            'photo' => $avatar,
        ])->assertStatus(409)
            ->assertJson([
                'success' => false,
                'message' => 'The token expired.',
            ]);
    }
}
