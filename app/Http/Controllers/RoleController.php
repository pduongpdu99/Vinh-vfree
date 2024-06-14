<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class RoleController extends BaseController
{
    /**
     * get list.
     *
     * @return void
     */
    public static function findAll(Request $request)
    {
        $limit = $request->query('limit') ?? 25;
        $page = $request->query('page') ?? 1;

        if ($request->query('limit') === '-1') {
            $data = Role::get(['*']);
        } else {
            $data = array_slice(Role::get(['*'])->skip(($page - 1) * $limit)->take($limit)->toArray(), 0);
        }
        return response()->json($data);
    }

    public static function findById(Request $request, $id)
    {
        $id = intval($id);
        $data = Role::get(['*'])->where('id', '=', $id)->first();
        return response()->json($data);
    }

    public static function create(Request $request)
    {
        $name = $request->input('name');
        $permission = $request->input('permission') ?? [];
        $data = Role::create(['name' => $name]);
        for ($i = 0; $i < count($permission); $i++) {
            $per = Permission::create(['name' => $permission[$i]]);
            RolePermission::create(['role_id' => $data['id'], 'permission_id' => $per['id']]);
        }
        return response()->json($data);
    }

    public static function update(Request $request, $id)
    {
        $name = $request->input('name');
        $data_original = Role::get()->where('id', '=', $id)->first();
        $data_original->update(['name' => $name]);
        $permission = $request->input('permission') ?? [];

        $query = RolePermission::query()->where('role_id', '=', $id);
        $query->delete();

        for ($i = 0; $i < count($permission); $i++) {
            $per = Permission::query()->where('name', '=', $permission[$i])->first();
            if (!$per) {
                $per = Permission::create(['name' => $permission[$i]]);
            }
            RolePermission::create(['role_id' => $id, 'permission_id' => $per['id']]);
        }
        return response()->json($data_original);
    }

    public static function delete(Request $request, $id)
    {
        $data_original = Role::get()->where('id', '=', $id)->first();
        $data_original->delete();
        return $data_original;
    }
}
