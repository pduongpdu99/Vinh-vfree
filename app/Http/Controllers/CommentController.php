<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class CommentController extends BaseController
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
            $data = Comment::get(['*']);
        } else {
            $data = array_slice(Comment::get(['*'])->skip(($page - 1) * $limit)->take($limit)->toArray(), 0);
        }
        return response()->json($data);
    }

    public static function findById(Request $request, $id)
    {
        $id = intval($id);
        $data = Comment::where('idcmt', '=', $id)->get(['*'])->first();
        return response()->json($data);
    }

    public static function create(Request $request)
    {
        $body = $request->all();
        $data = Comment::create($body);
        return response()->json($data);
    }

    public static function update(Request $request, $id)
    {
        $body = $request->all();
        $data_original = Comment::where('idcmt', '=', $id)->get()->first();
        $data_original->update($body);
        return response()->json($data_original);
    }

    public static function doDelete(Request $request, $id)
    {
        $data_original = Comment::find($id);
        if ($data_original) {
            $data_original->delete();
            return response()->json($data_original);
        }

        return response()->json(['message' => 'Not found']);
    }
}
