<?php

namespace App\Http\Controllers\Admin;
use App\Permission;
use Illuminate\Http\Request;

class PermissionController
{
    public function index()
    {
        return [
            'data' => Permission::all(),
        ];
    }
}
