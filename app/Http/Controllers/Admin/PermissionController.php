<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends Controller
{
  public function index()
  {
    $permissions = Permission::paginate(10);
    return Inertia::render('Admin/Permission/Index', ['permissions' => $permissions]);
  }

  public function create()
  {
    return Inertia::render('Admin/Permission/Create');
  }

  public function store(Request $request)
  {
    $request->validate(['name'=>'required|unique:permissions,name']);
    Permission::create($request->only('name','display_name','description'));
    return redirect()->route('admin.permissions.index')->with('success','权限创建成功');
  }

  public function edit(Permission $permission)
  {
    return Inertia::render('Admin/Permission/Edit',['permission'=>$permission]);
  }

  public function update(Request $request, Permission $permission)
  {
    $request->validate(['name'=>'required|unique:permissions,name,'.$permission->id]);
    $permission->update($request->only('name','display_name','description'));
    return redirect()->route('admin.permissions.index')->with('success','权限更新成功');
  }

  public function destroy(Permission $permission)
  {
    $permission->delete();
    return redirect()->route('admin.permissions.index')->with('success','权限删除成功');
  }
}
