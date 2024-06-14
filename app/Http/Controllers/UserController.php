<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends BaseController
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
            $data = User::get(['*']);
        } else {
            $data = array_slice(User::get(['*'])->skip(($page - 1) * $limit)->take($limit)->toArray(), 0);
        }
        return response()->json($data);
    }

    public static function findById(Request $request, $id)
    {
        $id = intval($id);
        $data = User::get(['*'])->where('id', '=', $id)->first();
        return response()->json($data);
    }

    public static function create(Request $request)
    {
        $body = $request->all();
        $data = User::create($body);
        return response()->json($data);
    }

    public static function update(Request $request, $id)
    {
        $body = $request->all();
        $data_original = User::get()->where('id', '=', $id)->first();
        $data_original->update($body);
        return response()->json($data_original);
    }

    public static function delete(Request $request, $id)
    {
        $data_original = User::get()->where('id', '=', $id)->first();
        $data_original->delete();
        return $data_original;
    }
}
