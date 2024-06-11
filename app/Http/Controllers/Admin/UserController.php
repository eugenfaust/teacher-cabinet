<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Users\CreateRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class UserController
{

    private function generateRandomString($length = 32)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    public function create(Request $reqest): Response
    {
        return Inertia::render('Admin/Users/Create');
    }


    public function store(CreateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['tg_hash'] = $this->generateRandomString();
        User::create($data);
        return to_route('users.index');
    }

    public function index(Request $request): Response
    {
        $users = User::where('is_admin', '=', false)->paginate(20)->through(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        });
        return Inertia::render('Admin/Users/Index',
            [
                'users' => $users,
            ]);
    }

    public function show(Request $request, User $user): Response
    {
        return Inertia::render('Admin/Users/Show', [
            'user' => $user,
        ]);
    }

    public function edit(Request $request, User $user): Response
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user = User::find($data['id']);
        $user->update($data);

        return to_route('users.show', ['user' => $data['id']]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();
        return to_route('users.index');
    }
}
