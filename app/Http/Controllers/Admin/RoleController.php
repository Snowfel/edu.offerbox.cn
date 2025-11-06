<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
  public function index()
  {
    $roles = Role::with('permissions')->paginate(10);
    return Inertia::render('Admin/Role/Index', ['roles' => $roles]);
  }

  public function create()
  {
    $permissions = Permission::all();
    return Inertia::render('Admin/Role/Create', ['permissions' => $permissions]);
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|unique:roles,name',
      'permissions' => 'array',
    ]);

    $role = Role::create($request->only('name','display_name','description'));
    if ($request->permissions) {
      $role->permissions()->sync($request->permissions);
    }

    return redirect()->route('admin.roles.index')->with('success','角色创建成功');
  }

  public function edit(Role $role)
  {
    $permissions = Permission::all();
    $role->load('permissions');
    return Inertia::render('Admin/Role/Edit', [
      'role' => $role,
      'permissions' => $permissions,
    ]);
  }

  public function update(Request $request, Role $role)
  {
    $request->validate([
      'name' => 'required|unique:roles,name,'.$role->id,
      'permissions' => 'array',
    ]);

    $role->update($request->only('name','display_name','description'));
    $role->permissions()->sync($request->permissions ?? []);

    return redirect()->route('admin.roles.index')->with('success','角色更新成功');
  }

  public function destroy(Role $role)
  {
    $role->delete();
    return redirect()->route('admin.roles.index')->with('success','角色删除成功');
  }
}
