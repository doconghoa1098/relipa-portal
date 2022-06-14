<?php

namespace App\Services;

use App\Http\Resources\NotificationResource;
use App\Models\Member;
use App\Models\Notification;
use App\Services\BaseService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;


class HomeService extends BaseService
{
    public function getModel()
    {
        return Notification::class;
    }

    public function home($request)
    {
        $orderBy = $request->get('sort');
        $divisionId = Member::where('id', auth()->id())->with('divisions')->first();
        $divisionId = $divisionId->divisions->first()->id;
        $query = Notification::whereJsonContains('published_to', [$divisionId])
            ->orwhereJsonContains('published_to', ["all"]);
        
        if ($orderBy) {
            $query->orderBy('id', $orderBy);
        }

        return NotificationResource::collection($query->get());
    }
    public function showNotice($id)
    {
        $member = Member::where('id', auth()->id())->with('divisions')->first();
        $divisionName = $member->divisions->first()->division_name;
        $notice = Notification::findOrFail($id);
        $publishedTo = $notice->published_to;

        $array = [];
        if ($publishedTo != '["all"]') {
            foreach ($publishedTo as $val) {
                array_push($array, $val->division_name);
            }
        }

        if (in_array($divisionName, $array) || $publishedTo == '["all"]') {

            return new NotificationResource($notice);
        } else {

            return $this->errorResponse(trans('message.error'),  Response::HTTP_FORBIDDEN);
        }
    }
}
