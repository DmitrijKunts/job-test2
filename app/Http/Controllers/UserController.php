<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $url = config('app.rest_api_url') . '/users';
        try {
            $response = Http::acceptJson()->get($url, $request->all());
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }

        if ($response->failed()) {
            abort($response->status(), $response['message'] ?? "");
        }

        $next_url = $response->object()->links->next_url ? '?' . parse_url($response->object()->links->next_url, PHP_URL_QUERY) : '';
        $prev_url = $response->object()->links->prev_url ? '?' . parse_url($response->object()->links->prev_url, PHP_URL_QUERY) : '';
        $users = $response->object()->users;

        return view('index', compact('users', 'next_url', 'prev_url'));
    }

    public function view($id)
    {
        $url = config('app.rest_api_url') . '/users/' . $id;
        try {
            $response = Http::acceptJson()->get($url);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }

        if ($response->failed()) {
            abort($response->status(), $response['message']);
        }
        $user = $response->object()->user;
        return view('view', compact('user'));
    }

    public function positions()
    {
        $url = config('app.rest_api_url') . '/positions';
        try {
            $response = Http::acceptJson()->get($url);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }

        if ($response->failed()) {
            abort($response->status(), $response['message']);
        }
        $positions = $response->object()->positions;
        return view('positions', compact('positions'));
    }

    public function create()
    {
        return view('create');
    }

    private function getToken()
    {
        $url = config('app.rest_api_url') . '/token';
        try {
            $response = Http::acceptJson()->get($url);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }

        if ($response->failed()) {
            abort($response->status(), $response['message']);
        }

        return $response->object()->token;
    }

    public function store(Request $request)
    {
        $url = config('app.rest_api_url') . '/users';
        try {
            $response = Http::acceptJson()
                ->withToken($this->getToken())
                ->attach(
                    'photo',
                    file_get_contents($request->photo->getPathname()),
                    'ava.jpg'
                )->post($url, $request->except('photo'));
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }

        if ($response->failed()) {
            dd($response['fails']);
            abort($response->status(), $response['message']);
        }

        return redirect(route('view', $response->object()->user_id));
    }
}
