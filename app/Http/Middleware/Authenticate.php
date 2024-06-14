<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            return response()->json(["error" => "Unauthorized"], 401);
        }
        $user = JWTAuth::parseToken()->authenticate();
        $roleId = $user->role_id;
        $role = Role::where("id", $roleId)->first();
        if ($roleId === 0 || ($role && $role['name'] === 'ADMIN')) {
            return $next($request);
        }
 
        $pathRefers = [
            'users' => 'USER',
            'auth' => 'USER',
            'role_permission' => 'ROLE_PERMISSION',
            'roles' => 'ROLE',
            'permissions' => 'PERMISSION',
            'notifications' => 'NOTIFICATION',
            'comments' => 'COMMENT',
            'activities' => 'ACTIVITY',
            'activity_groups' => 'ACTIVITY_GROUP',
        ];

        $methodRefers = [
            'POST' => 'POST',
            'GET' => 'VIEW',
            'DELETE' => 'DELETE',
            'PATCH' => 'UPDATE',
            'PUT' => 'UPDATE',
        ];

        $permissions = RolePermission::where("role_id", $roleId)->select(["permission_id"])->get()->map(function ($item) {
            return $item['permission_id'];
        });

        $permissions = Permission::whereIn('id', $permissions)->select(["name"])->get()->map(function ($item) {
            return $item->name;
        });

        $method = $methodRefers[$request->getMethod()];
        $path = $pathRefers[explode('/', $request->path())[0]];
        $substr = $path . "." . $method;

        $isExist = false;
        foreach ($permissions as &$value) {
            if(str_contains($value,$substr)) {
                $isExist = true;
                break;
            }
        }
        if(!$isExist) {
            return response()->json(["error" => "Unauthorized"], 401);
        }
        return $next($request);
    }
}
