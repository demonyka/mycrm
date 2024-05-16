<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\CreateStaffUserRequest;
use App\Http\Requests\Staff\EditMainStaffUserRequest;
use App\Models\Staff\Template;
use App\Models\Staff\User;
use Illuminate\Http\Request;
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
            [
                'name' => 'Шаблоны сотрудников',
                'href' => '',
                'is_active' => '',
                'permission' => 'staff.templates.view'
            ]
        ];
    }
    public function listView()
    {
        $users = User::paginate(20);
        $users->each(function ($user) {
            $user->append('positions');
        });
        return inertia('Staff/List', ['users' => $users, 'links' => $this->links]);
    }
    public function listDismissView()
    {
        $users = User::withoutGlobalScope('work')->where('status', 'dismiss')->paginate(20);
        $users->each(function ($user) {
            $user->append('positions');
        });
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
        return redirect()->route('staff.edit.view', ['id' => $user->id]);
    }

    public function userView($id)
    {
        /* @var User $user */
        $user = User::withoutGlobalScope('work')->findOrFail($id)->append(['roles', 'positions'])->load('template');
        return inertia('Staff/User', ['user' => $user, 'links' => $this->links]);
    }
    public function userEditView($id)
    {
        /* @var User $user */
        $user = User::withoutGlobalScope('work')->findOrFail($id)->append(['roles', 'positions'])->load('template');
        $templates = Template::all();
        return inertia('Staff/Edit', ['user' => $user, 'links' => $this->links, 'templates' => $templates]);
    }

    public function edit($id, EditMainStaffUserRequest $request): RedirectResponse
    {
        /* @var User $user */
        $user = User::withoutGlobalScope('work')->findOrFail($id);
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->hasFile('avatar')) {
            $user->setAvatar($request->file('avatar'));
        }
        if ($request->has('template_id')) {
            $user->template_id = $request->template_id;
        }
        $user->save();
        return redirect()->back();
    }

    public function editTpl($id, Request $request)
    {
        /* @var User $user */

        $user = User::withoutGlobalScope('work')->findOrFail($id);
        $data = $request->all();
        foreach ($data as $key => $value) {
            $user->setTplData($key, $value);
        }
        return redirect()->back();
    }
}
