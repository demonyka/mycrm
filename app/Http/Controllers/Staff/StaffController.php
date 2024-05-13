<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\CreateStaffUserRequest;
use App\Models\Staff\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\RedirectResponse;

class StaffController extends Controller
{
    private array $links;

    public function __construct()
    {
        $this->links = [
            [
                'name' => 'Все сотрудники',
                'href' => route('staff.view.list'),
                'is_active' => Route::is('staff.view.list'),
                'permission' => 'staff.view.list'
            ],
            [
                'name' => 'Уволенные сотрудники',
                'href' => route('staff.view.dismiss'),
                'is_active' => Route::is('staff.view.dismiss'),
                'permission' => 'staff.view.dismiss'
            ],
        ];
    }
    public function listView()
    {
        $users = User::paginate(20);
        return inertia('Staff/List', ['users' => $users, 'links' => $this->links]);
    }
    public function listDismissView()
    {
        $users = User::withoutGlobalScope('work')->where('status', 'dismiss')->paginate(20);
        return inertia('Staff/DismissList', ['users' => $users, 'links' => $this->links]);
    }
    public function createView()
    {
        return inertia('Staff/Create', ['links' => $this->links]);
    }
    public function delete($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->status = 'dismiss';
        $user->save();
        return redirect()->back();
    }
    public function restore($id): RedirectResponse
    {
        $user = User::withoutGlobalScope('work')->findOrFail($id);
        $user->status = 'active';
        $user->save();
        return redirect()->back();
    }

    public function create(CreateStaffUserRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('staff.view.list');
    }

    public function userView($id)
    {
        $user = User::withoutGlobalScope('work')->findOrFail($id);
        return $user;
    }
}
