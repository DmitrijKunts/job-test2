<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UsersGetRequest;
use App\Http\Requests\Api\UsersStoreRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function store(UsersStoreRequest $request, UserService $service)
    {
        $user = $service->create($request);

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'message' => 'New user successfully registered',
        ], 200);
    }

    public function users(UsersGetRequest $request)
    {
        $validated = $request->validated();

        $count = $request->count ?? 5;
        if ($request->has('offset')) {
            $users = User::with('position')->offset($request->offset)->limit($count)->get();
        } else {
            $users = User::with('position')->paginate($count);
        }

        if (isset($request->count)) {
            $users->appends(['count' => $request->count]);
        }

        if ($users->count() == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found',
            ], 404);
        } else {
            $res = [
                'success' => true,
                'count' => $users->count()
            ];
            if (!$request->has('offset')) {
                $res += [
                    'page' => $users->currentPage(),
                    'total_pages' => $users->lastPage(),
                    'total_users' => $users->total(),
                    'links' => [
                        'next_url' => $users->nextPageUrl(),
                        'prev_url' => $users->previousPageUrl(),
                    ]
                ];
            }

            return response()->json(
                $res + ['users' => UserResource::collection($users)],
                200
            );
        }
    }

    public function user($id)
    {
        $validator = Validator::make(compact('id'), [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'fails' => $validator->errors(),
            ], 400);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'The user with the requested identifier does not exist',
                'fails' => [
                    'user_id' => ['User not found']
                ]
            ], 404);
        }

        return response()->json([
            'success' => true,
            'user' => new  UserResource($user),
        ], 200);
    }
}
