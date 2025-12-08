<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\User\StoreUserRequest;
use App\Http\Requests\UserManagement\User\UpdateUserRequest;
use App\Models\User;
use App\Models\UserManagement\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $this->checkAuthorization('user_access');

        $users = User::with('role')->whereNot('id', auth()->id())->get();

        return view('admin.userManagement.user.index', compact('users'));
    }

    public function create()
    {
        $this->checkAuthorization('user_create');

        $roles = Role::all();

        return view('admin.userManagement.user.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->checkAuthorization('user_create');

        User::create($request->validated() + [
                'user_id' => auth()->id(),
            ]);

        toast('प्रयोगकर्ता सफलतापूर्वक थपियो', 'success');

        return redirect(route('admin.userManagement.user.index'));
    }

    public function show(User $user)
    {
        $this->checkAuthorization('user_access');
    }

    public function edit(User $user)
    {
        $this->checkAuthorization('user_edit');
        $roles = Role::all();

        $user->load('role');

        return view('admin.userManagement.user.edit', compact( 'user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->checkAuthorization('user_edit');

        $user->update($request->validated());

        toast('प्रयोगकर्ता सफलतापूर्वक अद्यावधिक गरियो', 'success');

        return redirect(route('admin.userManagement.user.index'));
    }

    public function destroy(User $user)
    {
        $this->checkAuthorization('user_delete');

        $user->delete();

        toast('प्रयोगकर्ता सफलतापूर्वक मेटाइयो', 'success');

        return back();
    }

    public function updateStatus(User $user)
    {
        $this->checkAuthorization('user_edit');

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        toast('प्रयोगकर्ता स्थिति सफलतापूर्वक अद्यावधिक गरियो', 'success');

        return back();
    }
}
