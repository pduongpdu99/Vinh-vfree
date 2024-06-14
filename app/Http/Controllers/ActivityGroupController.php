<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityGroup;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class ActivityGroupController extends BaseController
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
        $data_activities = Activity::get(['*']);

        if ($request->query('limit') === '-1') {
            $data = ActivityGroup::get(['*']);
        } else {
            $data = array_slice(ActivityGroup::get(['*'])->skip(($page - 1) * $limit)->take($limit)->toArray(), 0);
        }

        for($i = 0; $i < count($data); $i++) {
            if (!isset($data[$i]['activities'])) {
                $data[$i]['activities'] = array();
            }
        }
        
        for($i = count($data_activities)-1; $i>= 0; $i--) {
            for($j = 0; $j < count($data); $j++) {
                if($data[$j]['id'] == $data_activities[$i]['group_id']) {
                    array_push($data[$j]['activities'], $data_activities[$i]);
                }
            }
        }
        return response()->json($data);
    }

    public static function findById(Request $request, $id)
    {
        $id = intval($id);
        $data = ActivityGroup::get(['*'])->where('id', '=', $id)->first();
        $activities = Activity::get(['*'])->where('group_id','=',$id);
        $data['activities'] = $activities;
        return response()->json($data);
    }

    public static function create(Request $request)
    {
        $body = $request->all();
        $data = ActivityGroup::create($body);
        return response()->json($data);
    }

    public static function update(Request $request, $id)
    {
        $body = $request->all();
        $data_original = ActivityGroup::get()->where('id', '=', $id)->first();
        $data_original->update($body);
        return response()->json($data_original);
    }

    public static function delete(Request $request, $id)
    {
        $data_original = ActivityGroup::get()->where('id', '=', $id)->first();
        $data_original->delete();
        return $data_original;
    }
}
