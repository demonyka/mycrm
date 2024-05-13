<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\User;
use Illuminate\Support\Facades\Route;

class StaffController extends Controller
{
    private $links;

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
    public function list()
    {
        $users = User::paginate(20);
        return inertia('Staff/List', ['users' => $users, 'links' => $this->links]);
    }
    public function listDismiss()
    {
        $users = User::withoutGlobalScope('work')->where('status', 'dismiss')->paginate(20);
        return inertia('Staff/List', ['users' => $users, 'links' => $this->links]);
    }
}
