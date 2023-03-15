<?php

namespace App\Http\Controllers;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class AssignRoleController extends Controller
{
    public function assignRoleToUser()
    {
        $user = User::find(1);
        $role = Role::where('name', 'administrator')->first();
        $user->assignRole($role->id);

        return "Role assigned to user!";
    }
}
