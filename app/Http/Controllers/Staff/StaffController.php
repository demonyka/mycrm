<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\User;

class StaffController extends Controller
{
    public function viewList()
    {
        $users = User::paginate(10);
        return inertia('Staff/List', ['users' => $users]);
    }
}
